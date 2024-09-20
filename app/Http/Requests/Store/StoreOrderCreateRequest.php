<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'quantity' => ['required', 'array'],
            'quantity.*' => ['integer', 'min:0'],
            'providers' => ['required', 'array'],
            'providers.*' => ['integer', 'exists:providers,id'],
        ];
    }
}
