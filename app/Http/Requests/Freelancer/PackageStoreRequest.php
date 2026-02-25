<?php

namespace App\Http\Requests\Freelancer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PackageStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'freelancer';
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Convert package_inclusions to array if it's a JSON string
        if ($this->has('package_inclusions') && is_string($this->package_inclusions)) {
            try {
                $inclusions = json_decode($this->package_inclusions, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $this->merge([
                        'package_inclusions' => $inclusions
                    ]);
                }
            } catch (\Exception $e) {
                // If JSON decode fails, keep as is
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:tbl_categories,id',
            'package_name' => 'required|string|max:255',
            'package_description' => 'required|string',
            'package_inclusions' => 'required|array|min:1',
            'package_inclusions.*' => 'required|string|max:255',
            'duration' => 'required|integer|min:1|max:24',
            'maximum_edited_photos' => 'required|integer|min:1|max:1000',
            'coverage_scope' => 'nullable|string|max:255',
            'package_price' => 'required|numeric|min:0',
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
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category is invalid.',
            'package_name.required' => 'Package name is required.',
            'package_description.required' => 'Package description is required.',
            'package_inclusions.required' => 'At least one inclusion is required.',
            'package_inclusions.min' => 'At least one inclusion is required.',
            'package_inclusions.*.required' => 'Each inclusion field is required.',
            'duration.required' => 'Duration is required.',
            'duration.min' => 'Duration must be at least 1 hour.',
            'duration.max' => 'Duration cannot exceed 24 hours.',
            'maximum_edited_photos.required' => 'Maximum edited photos is required.',
            'maximum_edited_photos.min' => 'Minimum of 1 photo is required.',
            'maximum_edited_photos.max' => 'Maximum of 1000 photos allowed.',
            'package_price.required' => 'Package price is required.',
            'package_price.min' => 'Package price must be at least 0.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be either active or inactive.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}