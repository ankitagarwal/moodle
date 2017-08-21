@rotty @core @core_course @javascript
Feature: Course import shifts dates
  In order to verify if course restore works properly
  As an admin
  I need to import a course and check for dates

  Background:
    Given the following "courses" exist:
      | fullname     | shortname   | startdate  |
      # Date in Month of Jan.
      | Course 1 1   | COURSE1_1   | 1515400000 |
      # Date in Month of Feb.
      | Course 1 2   | COURSE1_2   | 1518000000 |
    And the following "activities" exist:
      | activity | course    | name     | allowsubmissionsfromdate | idnumber | allowsubmissionsfromdate_enabled |
      | assign   | COURSE1_1 | assign1  | 1515400001               | assign1  | 1                                |
    And I log in as "admin"

  Scenario: Import course with both config unchecked
    Given I set the following administration settings values:
      | restore_merge_overwrite_conf   | 0 |
      | restore_merge_course_startdate | 0 |
    And I am on "Course 1 2" course homepage with editing mode on
    When I navigate to "Import" in current page administration
    And I click on "(//input[@type='radio'])[3]" "xpath_element"
    And I press "Continue"
    And I press "Jump to final step"
    And I press "Continue"
    And I click on "assign1" "link"
    And I navigate to "Edit settings" in current page administration
    # we just check month here, we don't want timezone fails.
    Then the following fields match these values:
    | allowsubmissionsfromdate[month] | February |

  Scenario: Import course with restore_merge_overwrite_conf checked and restore_merge_course_startdate unchecked
    Given I set the following administration settings values:
      | restore_merge_overwrite_conf   | 1 |
      | restore_merge_course_startdate | 0 |
    And I am on "Course 1 2" course homepage with editing mode on
    When I navigate to "Import" in current page administration
    And I click on "(//input[@type='radio'])[3]" "xpath_element"
    And I press "Continue"
    And I press "Jump to final step"
    And I press "Continue"
    And I click on "assign1" "link"
    And I navigate to "Edit settings" in current page administration
    # we just check month here, we don't want timezone fails.
    Then the following fields match these values:
      | allowsubmissionsfromdate[month] | February |

  Scenario: Import course with restore_merge_overwrite_conf unchecked and restore_merge_course_startdate checked
    Given I set the following administration settings values:
      | restore_merge_overwrite_conf   | 0 |
      | restore_merge_course_startdate | 1 |
    And I am on "Course 1 2" course homepage with editing mode on
    When I navigate to "Import" in current page administration
    And I click on "(//input[@type='radio'])[3]" "xpath_element"
    And I press "Continue"
    And I press "Jump to final step"
    And I press "Continue"
    And I click on "assign1" "link"
    And I navigate to "Edit settings" in current page administration
    # we just check month here, we don't want timezone fails.
    Then the following fields match these values:
      | allowsubmissionsfromdate[month] | February |

  Scenario: Import course with restore_merge_overwrite_conf checked and restore_merge_course_startdate checked
    Given I set the following administration settings values:
      | restore_merge_overwrite_conf   | 1 |
      | restore_merge_course_startdate | 1 |
    And I am on "Course 1 2" course homepage with editing mode on
    When I navigate to "Import" in current page administration
    And I click on "(//input[@type='radio'])[3]" "xpath_element"
    And I press "Continue"
    And I press "Jump to final step"
    And I press "Continue"
    And I click on "assign1" "link"
    And I navigate to "Edit settings" in current page administration
    # we just check month here, we don't want timezone fails.
    # This is the only scenario where the dates should not roll.
    Then the following fields match these values:
      | allowsubmissionsfromdate[month] | January |