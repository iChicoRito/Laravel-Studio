<?php

namespace App\Http\Requests\StudioPhotographer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentStatusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'status' => 'required|in:confirmed,in_progress,completed,cancelled',
            'cancellation_reason' => 'required_if:status,cancelled|nullable|string|max:500'
        ];
    }

    public function messages()
    {
        return [
            'status.required' => 'Status is required',
            'status.in' => 'Invalid status value',
            'cancellation_reason.required_if' => 'Cancellation reason is required when cancelling assignment',
            'cancellation_reason.max' => 'Cancellation reason cannot exceed 500 characters'
        ];
    }
}