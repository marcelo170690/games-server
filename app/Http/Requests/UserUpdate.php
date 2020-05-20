<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|confirmed|string|min:8',
            'degrees' => 'required|integer',
        ];
    }
}
