<?php

namespace App\Http\Requests\EventPicture;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventPictureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create-event-picture');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'events' => ['required'],
            'event_pictures' => ['required', 'array']
        ];
    }
}
