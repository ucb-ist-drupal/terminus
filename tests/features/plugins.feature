Feature: Plugin Commands
  In order to extend Terminus
  As a user
  I need to be able to add commands to Terminus using the plugin mechanism.

  Scenario: Running a plugin that has not been installed
    When I run "[[executable]] hello"
    Then I should get:
    """
    Command "hello" is not defined.
    """

  Scenario: Running a simple plugin command that does not need autoloading
    When I am using "no-namespace" plugins
    And I run "[[executable]] global:hello"
    Then I should get:
    """
    [notice] Hello, World!
    """

  Scenario: Running a simple plugin command that does not need autoloading
    When I am using "no-namespace" plugins
    And I run "[[executable]] with-global-base-class:hello"
    Then I should get:
    """
    [notice] Hello, everyone!
    """

  Scenario: Running a simple plugin command that uses autoloading but does not have dependencies
    When I am using "with-namespace" plugins
    And I run "[[executable]] hello"
    Then I should get:
    """
    [notice] Hello, World!
    """

  Scenario: Running a simple plugin command that needs autoloading for its base class
    When I am using "with-namespace" plugins
    And I run "[[executable]] with-base-class:hello"
    Then I should get:
    """
    [notice] Hello, everyone!
    """

  Scenario: Running a simple plugin command that has trivial dependencies
    When I am using "with-dependencies" plugins
    And I run "[[executable]] dependencies:hello"
    Then I should get:
    """
    [notice] LengthUnits class NOT found in pre-init.
    [notice] LengthUnits class found in post-init.
    [notice] LengthUnits class found in main command implementation.
    [notice] Hello, yd!
     """

  Scenario: Running a simple plugin command that needs autoloading for its base class
    When I am using "outdated" plugins
    And I run "[[executable]] global:hello"
    Then I should get:
    """
    [warning] Could not load plugin pantheon-systems/terminus-plugin-example because it is not compatible with this version of Terminus.
    """

  Scenario: Running a simple plugin command that uses autoloading to include a hook which adds an option
    When I am using "with-hooks" plugins
    And I run "[[executable]] hello:again --new"
    Then I should get:
    """
    [notice] Ohai!
    """
    And I should not see an error

