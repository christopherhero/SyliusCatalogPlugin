@managing_catalogs
Feature: Adding new catalog
  In order to present other products user might be interested in
  As an Administrator
  I want to be able to add new catalog to the store

  Background:
    Given the store operates on a single channel in "United States"
    And I am logged in as an administrator

  @ui
  Scenario: Adding new catalog with no rules
    When I go to the create catalog page
    And I fill the code with "new_catalog"
    And I fill the name with "New catalog name"
    And I add it
    Then I should be notified that new catalog has been created

  @ui
  Scenario: Deleting catalog
    Given there is a catalog in the store
    When I go to the catalogs page
    And I delete this catalog
    Then I should be notified that the catalog has been deleted
    And I should see empty list of catalogs
