<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        if(request()->isMethod('POST')){
			return [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'purchase_price' => 'nullable',
                'description' => 'nullable',
                'stock_quantity' => 'required',
                'expiration_date' => 'nullable',
                'image' => 'nullable|mimes:jpg,jpeg,png|max:6000',
                'status' => 'nullable',
                'registered_by' => 'nullable',
               
		
			];	
		} elseif(request()->isMethod('PUT')){
			return [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'purchase_price' => 'nullable',
                'description' => 'nullable',
                'stock_quantity' => 'required',
                'expiration_date' => 'nullable',
                'image' => 'nullable|mimes:jpg,jpeg,png|max:6000',
                'status' => 'nullable',
                'registered_by' => 'nullable',
               
                
			];
		}
    }
}
