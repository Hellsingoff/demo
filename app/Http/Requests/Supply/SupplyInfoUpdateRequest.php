<?php

namespace App\Http\Requests\Supply;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplyInfoUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'price' => ['required', 'numeric', 'min:0'],
            'barcode' => [
                'required',
                'numeric',
                'min:1',
                Rule::unique('supply_infos', 'barcode')->ignore($this->route('supply.id'))
            ],
            'description' => ['string', 'min:3'],
            'providers' => ['required', 'array'],
            'providers.*' => ['required', 'integer', 'exists:providers,id'],
        ];
    }
}

