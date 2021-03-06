<?php

namespace Tests\Unit\Helpers;

use App\Helpers\RepaymentScheduleHelper;
use App\Models\Loan;
use Tests\TestCase;

class RepaymentScheduleHelperTest extends TestCase
{
    public function test_generate_repayment_schedule_by_loan()
    {
        $loan = Loan::factory()->make([
            'loan_amount' => 10000,
            'loan_term' => 1,
            'interest_rate' => 10,
            'started_at' => '2021-01-01 00:00:00',
        ]);

        $repaymentSchedules = RepaymentScheduleHelper::generateRepaymentSchedules($loan->loan_amount, $loan->loan_term, $loan->interest_rate, $loan->started_at);

        $this->assertEquals($repaymentSchedules[0]['payment_no'], 1);
        $this->assertEquals($repaymentSchedules[0]['date'], '2021-01-01 00:00:00');
        $this->assertEquals($repaymentSchedules[0]['payment_amount'], 879.1588723001);
        $this->assertEquals($repaymentSchedules[0]['principal'], 795.82553896677);
        $this->assertEquals($repaymentSchedules[0]['interest'], 83.333333333333);
        $this->assertEquals($repaymentSchedules[0]['balance'], 9204.1744610332);

        $this->assertEquals($repaymentSchedules[1]['payment_no'], 2);
        $this->assertEquals($repaymentSchedules[1]['date'], '2021-02-01 00:00:00');
        $this->assertEquals($repaymentSchedules[1]['payment_amount'], 879.1588723001);
        $this->assertEquals($repaymentSchedules[1]['principal'], 802.45741845816);
        $this->assertEquals($repaymentSchedules[1]['interest'], 76.701453841944);
        $this->assertEquals($repaymentSchedules[1]['balance'], 8401.7170425751);
        
        $this->assertEquals($repaymentSchedules[2]['payment_no'], 3);
        $this->assertEquals($repaymentSchedules[2]['date'], '2021-03-01 00:00:00');
        $this->assertEquals($repaymentSchedules[2]['payment_amount'], 879.1588723001);
        $this->assertEquals($repaymentSchedules[2]['principal'], 809.14456361197);
        $this->assertEquals($repaymentSchedules[2]['interest'], 70.014308688126);
        $this->assertEquals($repaymentSchedules[2]['balance'], 7592.5724789631);

        $this->assertEquals($repaymentSchedules[3]['payment_no'], 4);
        $this->assertEquals($repaymentSchedules[3]['date'], '2021-04-01 00:00:00');
        $this->assertEquals($repaymentSchedules[3]['payment_amount'], 879.1588723001);
        $this->assertEquals($repaymentSchedules[3]['principal'], 815.88743497541);
        $this->assertEquals($repaymentSchedules[3]['interest'], 63.271437324693);
        $this->assertEquals($repaymentSchedules[3]['balance'], 6776.6850439877);

        
        $this->assertEquals($repaymentSchedules[4]['payment_no'], 5);
        $this->assertEquals($repaymentSchedules[4]['date'], '2021-05-01 00:00:00');
        $this->assertEquals($repaymentSchedules[4]['payment_amount'], 879.1588723001);
        $this->assertEquals($repaymentSchedules[4]['principal'], 822.68649693353);
        $this->assertEquals($repaymentSchedules[4]['interest'], 56.472375366564);
        $this->assertEquals($repaymentSchedules[4]['balance'], 5953.9985470542);

        $this->assertEquals($repaymentSchedules[5]['payment_no'], 6);
        $this->assertEquals($repaymentSchedules[5]['date'], '2021-06-01 00:00:00');
        $this->assertEquals($repaymentSchedules[5]['payment_amount'], 879.1588723001);
        $this->assertEquals($repaymentSchedules[5]['principal'], 829.54221774131);
        $this->assertEquals($repaymentSchedules[5]['interest'], 49.616654558785);
        $this->assertEquals($repaymentSchedules[5]['balance'], 5124.4563293129);

        $this->assertEquals($repaymentSchedules[6]['payment_no'], 7);
        $this->assertEquals($repaymentSchedules[6]['date'], '2021-07-01 00:00:00');
        $this->assertEquals($repaymentSchedules[6]['payment_amount'], 879.1588723001);
        $this->assertEquals($repaymentSchedules[6]['principal'], 836.45506955582);
        $this->assertEquals($repaymentSchedules[6]['interest'], 42.703802744274);
        $this->assertEquals($repaymentSchedules[6]['balance'], 4288.001259757);

        $this->assertEquals($repaymentSchedules[7]['payment_no'], 8);
        $this->assertEquals($repaymentSchedules[7]['date'], '2021-08-01 00:00:00');
        $this->assertEquals($repaymentSchedules[7]['payment_amount'], 879.1588723001);
        $this->assertEquals($repaymentSchedules[7]['principal'], 843.42552846879);
        $this->assertEquals($repaymentSchedules[7]['interest'], 35.733343831308574);
        $this->assertEquals($repaymentSchedules[7]['balance'], 3444.5757312882383);

        $this->assertEquals($repaymentSchedules[8]['payment_no'], 9);
        $this->assertEquals($repaymentSchedules[8]['date'], '2021-09-01 00:00:00');
        $this->assertEquals($repaymentSchedules[8]['payment_amount'], 879.1588723001);
        $this->assertEquals($repaymentSchedules[8]['principal'], 850.45407453936);
        $this->assertEquals($repaymentSchedules[8]['interest'], 28.704797760735);
        $this->assertEquals($repaymentSchedules[8]['balance'], 2594.1216567489);

        $this->assertEquals($repaymentSchedules[9]['payment_no'], 10);
        $this->assertEquals($repaymentSchedules[9]['date'], '2021-10-01 00:00:00');
        $this->assertEquals($repaymentSchedules[9]['payment_amount'], 879.1588723001);
        $this->assertEquals($repaymentSchedules[9]['principal'], 857.54119182719);
        $this->assertEquals($repaymentSchedules[9]['interest'], 21.617680472907);
        $this->assertEquals($repaymentSchedules[9]['balance'], 1736.5804649217);

        $this->assertEquals($repaymentSchedules[10]['payment_no'], 11);
        $this->assertEquals($repaymentSchedules[10]['date'], '2021-11-01 00:00:00');
        $this->assertEquals($repaymentSchedules[10]['payment_amount'], 879.1588723001);
        $this->assertEquals($repaymentSchedules[10]['principal'], 864.68736842575);
        $this->assertEquals($repaymentSchedules[10]['interest'], 14.471503874347);
        $this->assertEquals($repaymentSchedules[10]['balance'], 871.89309649593);

        $this->assertEquals($repaymentSchedules[11]['payment_no'], 12);
        $this->assertEquals($repaymentSchedules[11]['date'], '2021-12-01 00:00:00');
        $this->assertEquals($repaymentSchedules[11]['payment_amount'], 879.1588723001);
        $this->assertEquals($repaymentSchedules[11]['principal'], 871.89309649597);
        $this->assertEquals($repaymentSchedules[11]['interest'], 7.2657758041328);
        $this->assertEquals($repaymentSchedules[11]['balance'], -3.3537617127877E-11);
    }

    public function test_calculate_pmt()
    {
        $pmt = RepaymentScheduleHelper::calculatePMT(10000, 10, 1);

        $this->assertEquals(879.1588723000987, $pmt);
    }

    public function test_calculate_interest()
    {
        $interest = RepaymentScheduleHelper::calculateInterest(10, 10000);

        $this->assertEquals(83.33333333333333, $interest);
    }

    public function test_calculate_principal()
    {
        $pmt = RepaymentScheduleHelper::calculatePMT(10000, 10, 1);
        $interest = RepaymentScheduleHelper::calculateInterest(10, 10000);
        $principal = RepaymentScheduleHelper::calculatePrincipal($pmt, $interest);

        $this->assertEquals(795.8255389667653, $principal);
    }
}