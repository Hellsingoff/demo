<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMoveSuppliesRequest extends FormRequest
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
            'store' => ['required', 'exists:stores,id'],
        ];
    }
}

