<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EntrantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'string|required|min:1',
            'family_name' => 'string|required|min:1',
            'age' => 'sometimes|nullable|integer|min:0|max:17',
            'membernumber' => 'sometimes|nullable|string',
            'team_id' => ['prohibited_if:age,>17',
                'nullable',
                          'integer',
                          Rule::exists('teams', 'id')->where(function ($query) {
                              $query
                                  ->where('min_age', '<=', $this->input('age'))
                                  ->where('max_age', '>=', $this->input('age'));
                              return $query;
                          })],
            'can_retain_data' => 'sometimes:boolean',
        ];
    }
}
