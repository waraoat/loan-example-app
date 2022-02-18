<?php

namespace App\Repositories;

use App\Models\RepaymentSchedule;
use Carbon\Carbon;

class RepaymentScheduleRepository
{
    protected $repayment_schedule;

    public function __construct(RepaymentSchedule $repayment_schedule)
    {
        $this->repayment_schedule = $repayment_schedule;
    }

    public function insert($data)
    {
        return $this->repayment_schedule::insert($data);
    }

    public function deleteByLoanId($id)
    {
        $repayment_schedules = $this->repayment_schedule->where('loan_id', '=', $id);
        $repayment_schedules->delete();

        return $repayment_schedules;
    }
}