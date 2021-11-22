<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'max:50'],
            'email' => ['sometimes', 'required', 'max:50', 'email', Rule::unique('users')->ignore($this->user)],
            'phone' => ['sometimes', 'required', 'max:50', Rule::unique('users')->ignore($this->user)],
            'password' => $this->password(),
            'role' => ['sometimes', 'required']
        ];
    }

    protected function password()
    {
        if($this->password) {
            return [
                'sometimes',
                'required',
                'max:16',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ];
        } else {
            return [
                'sometimes',
                'max:16',
            ];
        }
    }
}
