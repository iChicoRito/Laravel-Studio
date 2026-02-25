<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LocationStoreRequest extends FormRequest
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
        return [
            'province' => 'required|string|in:cavite',
            'municipality' => 'required|string|max:255|unique:tbl_locations,municipality',
            'barangay' => 'required|array|min:1',
            'barangay.*' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10|unique:tbl_locations,zip_code',
            'status' => 'required|in:active,inactive',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'province.in' => 'Province must be "cavite".',
            'municipality.required' => 'Municipality field is required.',
            'municipality.unique' => 'This municipality already exists.',
            'barangay.required' => 'At least one barangay is required.',
            'barangay.min' => 'At least one barangay is required.',
            'barangay.*.required' => 'Each barangay field is required.',
            'zip_code.required' => 'ZIP Code field is required.',
            'zip_code.unique' => 'This ZIP Code already exists.',
            'status.required' => 'Status field is required.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ensure province is always "cavite"
        $this->merge([
            'province' => 'cavite',
        ]);

        // Filter out empty barangay values
        if ($this->has('barangay')) {
            $barangays = array_filter($this->input('barangay'), function ($value) {
                return !empty(trim($value));
            });
            $this->merge([
                'barangay' => array_values($barangays),
            ]);
        }
    }
}