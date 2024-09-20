<?php

namespace App\Http\Requests\Sale;

use App\Enum\PaymentMethodEnum;
use App\Enum\StoreTypeEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SaleCompleteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'payment_method' => ['required', Rule::enum(PaymentMethodEnum::class)],
        ];

        /** @var User $user */
        $user = Auth::user();
        if ($user->store->type !== StoreTypeEnum::Minimarket) {
            $rules['customer_id'] = ['required', 'exists:customers,id'];
        }

        return $rules;
    }
}

