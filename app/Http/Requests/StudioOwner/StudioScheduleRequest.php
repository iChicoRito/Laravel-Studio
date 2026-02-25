<?php

namespace App\Http\Requests\StudioOwner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudioScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'operating_days' => 'required|array|min:1',
            'operating_days.*' => 'string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i|after:opening_time',
            'booking_limit' => 'required|integer|min:1|max:100',
            'advance_booking' => 'required|integer|min:1|max:30',
            'coverage_area.*' => 'string|exists:tbl_locations,municipality',
        ];

        // Only require studio_id for creation (store method)
        if ($this->isMethod('post')) {
            $rules['studio_id'] = [
                'required',
                'exists:tbl_studios,id',
                Rule::exists('tbl_studios', 'id')->where('status', 'verified')
            ];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'studio_id.required' => 'Please select a studio.',
            'studio_id.exists' => 'The selected studio is invalid or not verified.',
            'operating_days.required' => 'Please select at least one operating day.',
            'opening_time.required' => 'Opening time is required.',
            'closing_time.required' => 'Closing time is required.',
            'closing_time.after' => 'Closing time must be after opening time.',
            'booking_limit.required' => 'Booking limit is required.',
            'advance_booking.required' => 'Advance booking days is required.',
        ];
    }
}