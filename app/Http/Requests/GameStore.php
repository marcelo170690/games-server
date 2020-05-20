<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameStore extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|min:2',
            'description' => 'required'
        ];
    }
}
