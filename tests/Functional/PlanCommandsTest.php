<?php

namespace Pantheon\Terminus\Tests\Functional;

/**
 * Class PlanCommandsTest.
 *
 * @package Pantheon\Terminus\Tests\Functional
 */
class PlanCommandsTest extends TerminusTestBase
{
    /**
     * @test
     * @covers \Pantheon\Terminus\Commands\Plan\ListCommand
     *
     * @group plan
     * @group short
     */
    public function testPlanListCommand()
    {
        $plans = $this->terminusJsonResponse(sprintf('plan:list %s', $this->getSiteName()));
        $this->assertIsArray($plans);
        $this->assertNotEmpty($plans);

        foreach ($plans as $plan) {
            $this->assertIsArray($plan);
            $this->assertNotEmpty($plan);
            $this->assertArrayHasKey('sku', $plan);
            $this->assertArrayHasKey('name', $plan);
            $this->assertArrayHasKey('billing_cycle', $plan);
            $this->assertArrayHasKey('price', $plan);
            $this->assertArrayHasKey('monthly_price', $plan);
        }
    }

    /**
     * @test
     * @covers \Pantheon\Terminus\Commands\Plan\InfoCommand
     *
     * @group plan
     * @group short
     */
    public function testPlanInfoCommand()
    {
        $plan = $this->terminusJsonResponse(sprintf('plan:info %s', $this->getSiteName()));
        $this->assertIsArray($plan);
        $this->assertNotEmpty($plan);

        $this->assertArrayHasKey('id', $plan);
        $this->assertArrayHasKey('sku', $plan);
        $this->assertNotEmpty($plan['sku']);
        $this->assertArrayHasKey('name', $plan);
        $this->assertNotEmpty($plan['name']);
        $this->assertArrayHasKey('billing_cycle', $plan);
        $this->assertNotEmpty($plan['billing_cycle']);
        $this->assertArrayHasKey('price', $plan);
        $this->assertArrayHasKey('monthly_price', $plan);
    }

    /**
     * @test
     * @covers \Pantheon\Terminus\Commands\Plan\SetCommand
     *
     * @group plan
     * @group long
     */
    public function testSetPlanCommand()
    {
        $plans = $this->terminusJsonResponse(sprintf('plan:list %s', $this->getSiteName()));
        $smallPlans = array_filter($plans, fn ($plan) => false !== strpos($plan['sku'], 'small'));
        $targetPlanSku = reset($smallPlans)['sku'];

        $this->terminus(sprintf('plan:set %s %s', $this->getSiteName(), $targetPlanSku));
        $plan = $this->terminusJsonResponse(sprintf('plan:info %s', $this->getSiteName()));
        $this->assertArrayHasKey('sku', $plan);
        $this->assertNotEmpty($plan['sku']);
        $this->assertEquals($targetPlanSku, $plan['sku']);
    }
}
