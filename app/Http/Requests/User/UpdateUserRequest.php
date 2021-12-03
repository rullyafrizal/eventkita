<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Validator;

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
            'email' => $this->email(),
            'phone' =>$this->phone(),
            'password' => $this->password(),
            'role' => ['sometimes', 'required']
        ];
    }

    /**
     * Make custom validation in form request
     * https://github.com/laravel/framework/commit/bf8a36ac3df03a2c889cbc9aa535e5cf9ff48777#diff-0661ffaf8f2b04ba74d0df5b9e0d1daa57d400930d4aa1170d592657902bf85aR88
     *
     * @param Validator $validator
     */
    protected function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            if ($this->request->get('password') && $this->old_password) {
                if (!Hash::check($this->old_password, auth()->user()->password)) {
                    $validator->errors()->add('old_password', 'Your old password does not match');
                }
            }
        });
    }

    protected function email()
    {
        if (Request::wantsJson()) {
           return ['sometimes', 'required', 'max:50', 'email', 'unique:users,email,' . $this->user()->id];
        }

        return ['sometimes', 'required', 'max:50', 'email', Rule::unique('users')->ignore($this->user)];
    }

    protected function phone()
    {
        return Request::wantsJson() ?
            ['sometimes', 'required', 'max:50', 'unique:users,phone,' . $this->user()->id] :
            ['sometimes', 'required', 'max:50', Rule::unique('users')->ignore($this->user)];
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
