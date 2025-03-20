<?php

namespace Modules\ACL\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }
}
