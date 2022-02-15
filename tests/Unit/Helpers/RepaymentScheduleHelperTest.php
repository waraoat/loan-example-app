<?php

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use App\Http\Helpers\RepaymentScheduleHelper;

class RepaymentScheduleHelperTest extends TestCase
{
    public function testCalculatePMT()
    {
        $pmt = RepaymentScheduleHelper::calculatePMT(10000, 10, 1);

        $this->assertEquals(879.1588723000987, $pmt);
    }

    public function testCalculateInterest()
    {
        $interest = RepaymentScheduleHelper::calculateInterest(10, 10000);

        $this->assertEquals(83.33333333333333, $interest);
    }

    public function testCalculatePrincipal()
    {
        $pmt = RepaymentScheduleHelper::calculatePMT(10000, 10, 1);
        $interest = RepaymentScheduleHelper::calculateInterest(10, 10000);
        $principal = RepaymentScheduleHelper::calculatePrincipal($pmt, $interest);

        $this->assertEquals(795.8255389667653, $principal);
    }
}