<?php

namespace App\Http\Requests\Loan;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{ 
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'started_at' => Carbon::create($this->year, $this->month, 1, 00, 00, 00, 'UTC'),
        ]);
    }
    
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
            'loan_amount' => ['required', 'numeric', 'min:1000', 'max:100000000'],
            'loan_term' => ['required', 'numeric', 'min:1', 'max:50'],
            'interest_rate' => ['required', 'numeric', 'min:1', 'max:36'],
            'month' => ['required', 'numeric', 'min:1', 'max:12'],
            'year' => ['required', 'numeric', 'min:2017', 'max:2050']
        ];
    }

    public function attributes()
    {
        return [
            //
        ];
    }
}
