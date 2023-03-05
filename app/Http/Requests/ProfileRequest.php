<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
            'first_name' => ['required', 'min:3'],
            'last_name' => ['required', 'min:3'],
            'address_1' => ['nullable', 'min:3'],
            'address_2' => ['nullable', 'min:3'],
            'telephone' => ['nullable', 'regex:/\+?[\(\)0-9 ]*/', 'min:11'],
            'address_town' => ['required_with:address_1', 'min:3'],
            'postcode' => ['required_with:address_1', 'min:3'],
            'email' => ['required', 'email', Rule::unique((new User)->getTable())->ignore(auth()->id())],
        ];
    }
}
