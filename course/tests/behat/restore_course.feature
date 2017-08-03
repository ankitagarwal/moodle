@core @core_course @javascript
Feature: Course restore shifts dates
  In order to verify if course restore works properly
  As an admin
  I need to restore a course and check for dates

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
    And I backup "Course 1 1" course using this options:
      | Confirmation | Filename | test_backup.mbz |

  Scenario: Restore course with overwrite_conf set to No (course start date can't be set in this case)
    When I restore "test_backup.mbz" backup into "Course 1 2" course using this options:
      | Schema | Overwrite course configuration | No |
    And I click on "assign1" "link"
    And I navigate to "Edit settings" in current page administration
    # we just check month here, we don't want timezone fails.
    Then the following fields match these values:
    | allowsubmissionsfromdate[month] | February |

  Scenario: Restore course with overwrite_conf checked and restore_merge_course_startdate unchecked
    When I restore "test_backup.mbz" backup into "Course 1 2" course using this options:
      | Schema | Overwrite course configuration | Yes |
      | Schema | id_setting_course_course_startdate_customize | 0 |
    And I click on "assign1" "link"
    And I navigate to "Edit settings" in current page administration
    # we just check month here, we don't want timezone fails.
    Then the following fields match these values:
      | allowsubmissionsfromdate[month] | February |

  Scenario: Restore course with restore_merge_overwrite_conf checked and restore_merge_course_startdate checked
    When I restore "test_backup.mbz" backup into "Course 1 2" course using this options:
      | Schema | Overwrite course configuration | Yes |
      | Schema | id_setting_course_course_startdate_customize | 1 |
    And I click on "assign1" "link"
    And I navigate to "Edit settings" in current page administration
    # we just check month here, we don't want timezone fails.
    Then the following fields match these values:
     | allowsubmissionsfromdate[month] | January |

  Scenario: Restore course with overwrite_conf set to No (course start date can't be set in this case, but we use site default)
    Given I set the following administration settings values:
      | restore_merge_overwrite_conf   | 1 |
      | restore_merge_course_startdate | 1 |
    And I am on "Course 1 1" course homepage
    And I navigate to "Restore" in current page administration
    When I restore "test_backup.mbz" backup into "Course 1 2" course using this options:
      | Schema | Overwrite course configuration | No |
    And I click on "assign1" "link"
    And I navigate to "Edit settings" in current page administration
    # we just check month here, we don't want timezone fails.
    Then the following fields match these values:
      | allowsubmissionsfromdate[month] | February |