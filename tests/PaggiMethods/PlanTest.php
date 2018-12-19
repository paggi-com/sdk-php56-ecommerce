<?php

/**
 * This file will test the Plan
 *
 * PHP version 5.6, 7.0, 7.1, 7.2
 *
 * @category Plan_Test_File
 * @package  Paggi
 * @author   Paggi Integracoes <ti-integracoes@paggi.com>
 * @license  GNU GPLv3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     http://developers.paggi.com
 */
namespace Paggi\Tests;

use Paggi\SDK;
use PHPUnit\Framework\TestCase;

/**
 * This class will test the Plan validation
 *
 * @category Plan_Test_Class
 * @package  Paggi
 * @author   Paggi Integracoes <ti-integracoes@paggi.com>
 * @license  GNU GPLv3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     http://developers.paggi.com
 */
class PlanTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Function responsible for testing the the method who get
     * the list of Plans
     *
     * @return void
     */
    public function testGetPlans()
    {
        $envConfiguration = new \Paggi\SDK\EnvironmentConfiguration();
        $PlansFinder = new \Paggi\SDK\Plan();
        $envConfiguration->setEnv("Staging");
        $envConfiguration->setToken(getenv("TOKEN"));
        $envConfiguration->setPartnerIdByToken(getenv("TOKEN"));

        $Plans = $PlansFinder->find([], "03277df9-175d-468f-a99c-77e056434138");
        $this->assertTrue(isset($Plans->id));
    }

    public function testCreatePlan()
    {
        $envConfiguration = new \Paggi\SDK\EnvironmentConfiguration();
        $plan = new \Paggi\SDK\Plan();

        $envConfiguration->setEnv("Staging");
        $envConfiguration->setToken(getenv("TOKEN"));
        $envConfiguration->setPartnerIdByToken(getenv("TOKEN"));

        $planParams
        = [
            "name" => "Meu primeiro plano",
            "price" => 1990,
            "interval" => "1m",
            "trial_period" => "2d",
            "external_identifier" => "12345",
            "description" => "teste",
        ];
        $plans = $plan->create($planParams);

        $this->assertRegexp(
            "/\w+-*/",
            $plans->id
        );
    }

    public function testUpdatePlan()
    {
        $envConfiguration = new \Paggi\SDK\EnvironmentConfiguration();
        $plan = new \Paggi\SDK\Plan();

        $envConfiguration->setEnv("Staging");
        $envConfiguration->setToken(getenv("TOKEN"));
        $envConfiguration->setPartnerIdByToken(getenv("TOKEN"));

        $planParams
        = [
            "name" => "Meu primeiro plano",
            "price" => 1990,
            "interval" => "1m",
            "trial_period" => "2d",
            "external_identifier" => "12345",
            "description" => "teste",
        ];
        $PlanResponse = $plan->create($planParams);

        $updateParams
        = [
            "description" => "abcde",
        ];
        $alterPlan = $plan->update($updateParams, $PlanResponse->id);
        $this->assertTrue($PlanResponse->description != $alterPlan->description);
    }

    public function testDeletePlan()
    {
        $envConfiguration = new \Paggi\SDK\EnvironmentConfiguration();
        $plan = new \Paggi\SDK\Plan();

        $envConfiguration->setEnv("Staging");
        $envConfiguration->setToken(getenv("TOKEN"));
        $envConfiguration->setPartnerIdByToken(getenv("TOKEN"));

        $planParams
        = [
            "name" => "Meu primeiro plano",
            "price" => 1990,
            "interval" => "1m",
            "trial_period" => "2d",
            "external_identifier" => "12345",
            "description" => "teste",
        ];
        $PlanResponse = $plan->create($planParams);

        $updateParams
        = [
            "description" => "abcde",
        ];
        $alterPlan = $plan->delete($PlanResponse->id);
        $this->assertEquals($alterPlan->code, 204);
    }
}
