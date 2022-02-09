<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    public function repayment_schedule()
    {
        return $this->hasMany('App\Models\RepaymentSchedules', 'loan_id', 'id');
    }
}
