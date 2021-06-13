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
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => [
                'required', 'min:2'
            ],
            'lastname' => [
                'required', 'min:2'
            ],
            'email' => [
                'required_without_all:address,postcode', 'max:255',
//                'required', 'email', Rule::unique((new UserResource)->getTable())->ignore($this->route()->user->id ?? null)
            ],
            'address' => ['required_without:email', 'max:255'],
            'addresstown' => ['required_without:email', 'max:255'],
            'postcode' => ['required_without:email', 'max:10'],
        ];
    }
}
