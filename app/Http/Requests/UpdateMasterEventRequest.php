<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'position_id' => 'required|exists:event_positions,id', // Validate position_id exists in event_positions
            'name' => 'required|string|max:255', // Adjust max length as needed
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date', // Ensure end_date is after or equal to start_date
            'isActive' => 'required|boolean', // Ensure isActive is a boolean
            'order' => 'required|integer|min:1', // Ensure order is a positive integer
        ];
    }
}
