Feature: Managing site organizational memberships
  In order to manage what organizations a site is a member of
  As a user
  I need to be able to add and remove those relationships.

  Background: I am authenticated and have a site named [[test_site_name]]
    Given I am authenticated
    And a site named "[[test_site_name]]"

  @vcr site-org-add.yml
  Scenario: Adding a supporting organization to a site
    When I run "[[executable]] site:org:add [[test_site_name]] '[[organization_name]]'"
    Then I should get:
    """
    Adding [[organization_name]] as a supporting organization to [[test_site_name]].
    """
    And I should get:
    """
    Added "[[organization_name]]" as a supporting organization
    """


  @vcr site-org-remove.yml
  Scenario: Removing a supporting organization from a site
    When I run "[[executable]] site:org:remove [[test_site_name]] '[[organization_name]]'"
    Then I should get:
    """
    Removing [[organization_name]] as a supporting organization from [[test_site_name]].
    """
    And I should get:
    """
    Removed supporting organization
    """

  @vcr site-org-remove.yml
  Scenario: Listing the supporting organizations of a site
    When I run "[[executable]] site:org:list [[test_site_name]]"
    Then I should not see a warning
    And I should see a table with rows like:
    """
        Name
        ID
    """
    And that table should have 1 row
    And I should get: "[[organization_name]]"

  @vcr site-org-list-empty.yml
  Scenario: Listing the supporting organizations of a site
    When I run "[[executable]] site:org:list [[test_site_name]]"
    Then I should get the warning: "This site has no supporting organizations."
    And I should see a table with rows like:
    """
        Name
        ID
    """
    And that table should have no rows
