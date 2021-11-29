<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create-event');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'location' => ['required', 'max:255'],
            'description' => ['required', 'max:15000'],
            'quota' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'end_date' => ['date'],
            'event_type' => ['required', 'numeric'],
            'event_pictures' => ['required', 'array'],
            'event_informations' => ['required']
        ];
    }
}
