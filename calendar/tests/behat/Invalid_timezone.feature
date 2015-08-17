@core @core_calendar @rand
Feature: Import ical feed with invalid timezones
  In order to properly import ical feeds
  As a user
  I need to provide timezone mappings for bad timezones.

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email |
      | student1 | Student | 1 | student1@example.com |
    And the following "courses" exist:
      | fullname | shortname | format |
      | Course 1 | C1 | topics |
    And the following "course enrolments" exist:
      | user | course | role |
      | student1 | C1 | student |

  @javascript
  Scenario: I import ical file with invalid timezones
    Given I log in as "student1"
    And I expand "Site pages" node
    And I follow "calendar"
    And I press "Manage subscription"
    And I set the following fields to these values:
      | Calendar name     | Calendar |
      | Import from       | Calendar file (.ics) |
    And I upload "calendar/tests/fixtures/badtz.ics" file to "Calendar file (.ics)" filemanager
    When I press "Add"
    Then I should see "Asia/Zombieland"
    And I should see "Asia/Brains!!"
    And I set the field "Asia/Zombieland" to "UTC"
    And I set the field "Asia/Brains!!" to "UTC"
    And I press "Save changes"
    And I wait to be redirected
    And I should see "Weekly event -wed"
    And I should see "line 1"