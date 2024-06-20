<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
        if ($this->isMethod('POST')) {
            return [
                
                'total_sale' => 'required',
                'status' => 'nullable',
                'registered_by' => 'nullable',
                
            ];
        } elseif ($this->isMethod('PUT')) {
            return [
                'total_sale' => 'required',
                'status' => 'nullable',
                'registered_by' => 'nullable',
                'sale_details' => 'required',
                'sale_details.*.quantity' => 'required',
                'sale_details.*.subtotal' => 'required',
            ];
        }
    }
}
