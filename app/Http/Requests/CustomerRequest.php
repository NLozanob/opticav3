<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        if (request()->isMethod('POST')) {
            return [
                'first_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'identification_document' => 'nullable',
                'email' => 'required',
                'phone' => 'nullable', 
                'address' => 'nullable',
                'image' => 'nullable|mimes:jpg,jpeg,png|max:6000',
                
            ];
        } elseif (request()->isMethod('PUT')) {
            return [
                'first_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'identification_document' => 'nullable|string',
                'email' => 'required',
                'phone' => 'nullable', 
                'address' => 'nullable',
                'image' => 'nullable|mimes:jpg,jpeg,png|max:6000',
                
            ];
        }
    }
}
