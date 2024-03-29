<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => [
                'required', 'min:2'
            ],
            'last_name' => [
                'required', 'min:2'
            ],
            'email' => [
                'required_without_all:address_1,postcode', 'max:255',
//                'required', 'email', Rule::unique((new UserResource)->getTable())->ignore($this->route()->user->id ?? null)
            ],
            'address_1' => ['required_without:email', 'max:255'],
            'address_2' => ['required_without:email', 'max:255'],
            'address_town' => ['required_without:email', 'max:255'],
            'telephone' => ['nullable', 'max:15'],
            'postcode' => ['required_without:email', 'max:10'],
            'can_retain_data' => ['nullable', 'int', 'min:0', 'max:1'],
            'can_email' => ['nullable', 'int', 'min:0', 'max:1'],
            'can_phone' => ['nullable', 'int', 'min:0', 'max:1'],
            'can_sms' => ['nullable', 'int', 'min:0', 'max:1'],
            'can_post' => ['nullable', 'int', 'min:0', 'max:1'],
        ];
    }
}
