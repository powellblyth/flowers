<?php

namespace App\Http\Requests;

use App\Models\Entrant;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\User;
use App\Models\MembershipPurchase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ManualSubscriptionRenewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Only administrators can do this.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()?->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required', 'exists:'. User::class.',id',
            ],
            'entrant_id' => [
                'nullable', 'exists:'. Entrant::class.',id',
                // 'required_if:type,' . MembershipPurchase::TYPE_INDIVIDUAL,
            ],
            'membership_type' => [
                Rule::in(array_keys(Membership::getTypes())),'required'
            ],
            'payment_method' => [
                Rule::in(array_keys(Payment::getAllPaymentTypes())),'required'
            ]
        ];
    }
}
