<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorStoreRequest extends FormRequest
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
            'id_card' => ['required', 'string'],
            // 'doctor_id' => ['required', 'string'],
            // 'doctor_name' => ['required', 'string'],
            // 'doctor_title' => ['required', 'string'],
            // 'speciality_name' => ['required', 'string'],
            // 'medical_education' => ['required', 'string'],
            // 'medical_degree' => ['required', 'string'],
            // 'medical_license' => ['required', 'string'],
            // 'poli' => ['required', 'string'],
            // 'specialist' => ['string'],
            // 'phone' => ['required', 'string'],
            // 'durationPerPatient' => ['required', 'string'],
            // 'room' => ['required', 'string'],
            // 'attend' => ['required', 'string'],
            // 'department' => ['required', 'string'],
            // 'salary' => ['required', 'string'],
            // 'doctorType' => ['required', 'string'],
            // 'transportFee' => ['required', 'string'],
            // 'endTime' => ['required', 'string'],

        ];
    }
}
