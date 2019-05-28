<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Validation\Rule;
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
//            'firstname' => 'required|string|max:255',
//            'lastname' => 'required|string|max:255',
//            'email' => 'required_without_all:address,postcode|unique:users|string|email|max:255',
//            'address' => 'required_without:email|unique:users|string|email|max:255',
//            'postcode' => 'required_without:email|unique:users|string|email|max:255',
//            'password' => 'required|string|min:2|confirmed',

        return [
            'firstname' => [
                'required', 'min:3'
            ],
            'lastname' => [
                'required', 'min:3'
            ],
            'email' => [
                'required_without_all:address,postcode', 'max:255',
//                'required', 'email', Rule::unique((new User)->getTable())->ignore($this->route()->user->id ?? null)
            ],
            'address' => 'required_without:email', 'users', 'string', 'max:255',
            'postcode' => 'required_without:email', 'string', 'max:10',
//            'password' => [
//                $this->route()->user ? 'nullable' : 'required', 'confirmed', 'min:6'
//            ]
        ];
    }
}
