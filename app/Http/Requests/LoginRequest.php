<?php

namespace ksec\Http\Requests;

use ksec\Http\Requests\Request;

class LoginRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'unit' => 'required|integer|exists:units,id',
            'username' => 'required|exists:users,username',
            'password' => 'required'
        ];
    }
}
