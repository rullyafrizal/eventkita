<?php

namespace App\Http\Requests\EventPicture;

use Illuminate\Foundation\Http\FormRequest;

class UploadPictureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('upload-event-picture');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => ['max:10240'],
            'store_path' => ['required'],
        ];
    }
}
