<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:5'],
            'phone' => ['required', 'string', 'regex:/^\d{10,11}$/'],
            'email' => ['required', 'email'],
            'number_card' => ['required', 'integer', 'digits:10', 'unique:customers,number_card'],
        ];
    }
}

