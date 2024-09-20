<?php

namespace App\Http\Requests\Store;

use App\Enum\StoreTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'area' => ['required', 'numeric', 'min:1'],
            'type' => ['required', Rule::enum(StoreTypeEnum::class)],
            'utility_costs' => ['required', 'numeric', 'min:0'],
        ];
    }
}
