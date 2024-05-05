<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleStoreRequest extends FormRequest
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
            'schedulable_id' => ['required', 'string'],
            'schedulable_type' => ['required', 'string'],
            'weekday' => ['required', 'string'],
            'start_hour' => ['required', 'integer'],
            'start_minute' => ['required', 'integer'],
            'end_hour' => ['required', 'integer'],
            'end_minute' => ['required', 'integer'],
        ];
    }
}
