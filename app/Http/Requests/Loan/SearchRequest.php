<?php

namespace App\Http\Requests\Loan;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'min_loan_amount' => ['numeric', 'min:1000', 'max:100000000'],
            'max_loan_amount' => ['numeric', 'min:1000', 'max:100000000'],
            'min_loan_term' => ['numeric', 'min:1', 'max:50'],
            'max_loan_term' => ['numeric', 'min:1', 'max:50'],
            'min_interest_rate' => ['numeric', 'min:1', 'max:36'],
            'max_interest_rate' => ['numeric', 'min:1', 'max:36']

        ];
    }
}
