<?php

namespace Pantheon\Terminus\Tests\Functional;

class OrgCommandsTest extends TerminusTestBase
{
    /**
     * Test org:info command
     *
     * @test
     * @group org
     * @group short
     */
    public function testOrgInfoCommand()
    {
        $org = $this->terminusJsonResponse("org:info " . $this->getOrg());
        $this->assertIsArray(
            $org,
            "Response from org info should be an array"
        );
        $this->assertArrayHasKey(
            'id',
            $org,
            "Orgs from org info should have an id property"
        );
        $this->assertNotEmpty($org['id'], 'Orgs ID should not be empty');

        $this->assertArrayHasKey(
            'name',
            $org,
            "Orgs from org info should have a name property"
        );
        $this->assertNotEmpty($org['name'], 'Orgs Name should not be empty');

        $this->assertArrayHasKey(
            'label',
            $org,
            "Orgs from org info should have a label property"
        );
        $this->assertNotEmpty($org['label'], 'Orgs Label should not be empty');
    }

    /**
     * @test
     * @covers \Pantheon\Terminus\Commands\Org\ListCommand
     *
     * @group org
     * @group short
     */
    public function testOrgListCommand()
    {
        $orgList = $this->terminusJsonResponse("org:list");
        $this->assertIsArray(
            $orgList,
            "Response from org list should be an array of orgs"
        );
        $org = array_shift($orgList);

        $this->assertIsArray(
            $org,
            "row from org list array of orgs should be an org item"
        );
        $this->assertArrayHasKey(
            'id',
            $org,
            "Orgs from org list should have an id property"
        );
        $this->assertNotEmpty($org['id'], 'Orgs ID should not be empty');

        $this->assertArrayHasKey(
            'name',
            $org,
            "Orgs from org list should have a name property"
        );
        $this->assertNotEmpty($org['name'], 'Orgs Name should not be empty');

        $this->assertArrayHasKey(
            'label',
            $org,
            "Orgs from org list should have a label property"
        );
        $this->assertNotEmpty($org['label'], 'Orgs Label should not be empty');
    }

    /**
     * @test
     * @covers \Pantheon\Terminus\Commands\Org\People\ListCommand
     *
     * @group org
     * @group short
     */
    public function testOrgPeopleListCommand()
    {
        $people = $this->terminusJsonResponse(
            "org:people:list " . $this->getOrg()
        );
        $this->assertIsArray(
            $people,
            'Response from org:people:list should be an array'
        );

        foreach ($people as $user) {
            $this->assertIsArray(
                $user,
                'A user record should be an array'
            );

            $this->assertArrayHasKey('id', $user, 'User should contain an ID');
            $this->assertNotEmpty($user['id'], 'User ID should not be empty');
            $this->assertArrayHasKey(
                'email',
                $user,
                'User should contain an email'
            );
            $this->assertNotEmpty(
                $user['email'],
                'User email should not be empty'
            );
        }
    }

    /**
     * @test
     * @covers \Pantheon\Terminus\Commands\Org\Site\ListCommand
     *
     * @group org
     * @group short
     */
    public function testOrgSiteListCommand()
    {
        $orgSites = $this->terminusJsonResponse(
            "org:site:list " . $this->getOrg()
        );
        $this->assertIsArray(
            $orgSites,
            "Response from org list should be an array of orgs"
        );
        $site = array_shift($orgSites);

        $this->assertIsArray(
            $site,
            "row from org list array of orgs should be an org item"
        );
        $this->assertArrayHasKey(
            'id',
            $site,
            "Sites from org list should have an id property"
        );
        $this->assertArrayHasKey(
            'name',
            $site,
            "Sites from org list should have a name property"
        );
    }

    /**
     * @test
     * @covers \Pantheon\Terminus\Commands\Org\Upstream\ListCommand
     *
     * @group org
     * @group short
     */
    public function testOrgUpstreamList()
    {
        $upstreams = $this->terminusJsonResponse(
            "org:upstream:list " . $this->getOrg()
        );
        $this->assertIsArray(
            $upstreams,
            "Response from org list should be an array of orgs"
        );
        $upstream = array_shift($upstreams);

        $this->assertIsArray(
            $upstream,
            "row from org list array of orgs should be an org item"
        );
        $this->assertArrayHasKey(
            'id',
            $upstream,
            "Orgs from org list should have an id property"
        );
        $this->assertArrayHasKey(
            'label',
            $upstream,
            "Orgs from org list should have a name property"
        );
        $this->assertArrayHasKey(
            'machine_name',
            $upstream,
            "Orgs from org list should have a name property"
        );
    }
}
