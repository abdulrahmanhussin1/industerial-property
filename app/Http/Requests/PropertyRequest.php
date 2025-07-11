<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
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
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'location_id' => ['nullable', 'exists:locations,id'],
            'property_type_id' => ['required', 'exists:property_types,id'],

            'title' => ['required', 'string', 'max:255'],
            'land_area' => ['required', 'integer', 'min:1'],

            'hangar_type' => ['nullable', Rule::in(['hangar', 'truss'])],
            'hangar_area' => ['nullable', 'integer', 'min:0'],
            'hangar_height' => ['nullable', 'numeric', 'min:0', 'max:999.99'],

            'admin_floors' => ['nullable', 'integer', 'min:0'],
            'electricity_power' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'electricity_unit' => ['nullable', Rule::in(['kw', 'mega'])],

            'license_expiry_date' => ['nullable', 'date'],

            'status' => ['required', Rule::in(['active', 'inactive'])],
            'cranes_count' => ['nullable', 'integer', 'min:0'],
            'price' => ['nullable', 'numeric', 'min:0'],

            'notes' => ['nullable', 'string', 'max:1000'],
            'attachments[]' => [
                'nullable',
                'array',
                'max:10',
            ],
            'attachments.*' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'mimetypes:image/jpeg,image/png,image/jpg',
                'max:2048',
        ]
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The property title is required.',
            'land_area.required' => 'Land area is mandatory.',
            'property_type_id.required' => 'Property type must be selected.',
            'status.in' => 'Status must be either active or inactive.',
        ];
    }
}
