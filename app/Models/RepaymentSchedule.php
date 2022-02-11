<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepaymentSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id', 'payment_no', 'date',  'payment_amount', 'principal', 'interest_rate', 'balance'
    ];

    public function loan()
    {
        return $this->belongsTo('App\Models\Loan', 'loan_id');
    }
}
