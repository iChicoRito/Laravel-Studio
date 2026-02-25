<?php

namespace App\Http\Requests\StudioOwner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PackageStoreRequest extends FormRequest
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
        $id = $this->route('package');
        
        return [
            'studio_id' => 'required|exists:tbl_studios,id',
            'category_id' => 'required|exists:tbl_categories,id',
            'package_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tbl_packages', 'package_name')
                    ->ignore($id)
                    ->where('studio_id', $this->studio_id)
            ],
            'package_description' => 'required|string|min:10|max:1000',
            'package_inclusions' => 'required|string|min:1',
            'duration' => 'required|integer|min:1|max:24',
            'maximum_edited_photos' => 'required|integer|min:1|max:1000',
            'coverage_scope' => 'nullable|string|max:500',
            'package_price' => 'required|numeric|min:0',
            'online_gallery' => 'required|boolean',              // Added
            'photographer_count' => 'required|integer|min:0|max:10', // Added
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
            'studio_id.required' => 'Please select a studio.',
            'studio_id.exists' => 'Selected studio does not exist.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'package_name.required' => 'Package name is required.',
            'package_name.unique' => 'A package with this name already exists for this studio.',
            'package_description.required' => 'Package description is required.',
            'package_description.min' => 'Package description must be at least 10 characters.',
            'package_inclusions.required' => 'At least one inclusion is required.',
            'duration.min' => 'Duration must be at least 1 hour.',
            'duration.max' => 'Duration cannot exceed 24 hours.',
            'maximum_edited_photos.min' => 'Minimum edited photos must be at least 1.',
            'maximum_edited_photos.max' => 'Maximum edited photos cannot exceed 1000.',
            'package_price.min' => 'Package price cannot be negative.',
            'package_price.required' => 'Package price is required.',
            'online_gallery.required' => 'Please select if online gallery is included.',     // Added
            'online_gallery.boolean' => 'Invalid selection for online gallery.',             // Added
            'photographer_count.required' => 'Please specify number of photographers.',      // Added
            'photographer_count.min' => 'Photographer count cannot be negative.',            // Added
            'photographer_count.max' => 'Maximum of 10 photographers allowed.',              // Added
        ];
    }
}