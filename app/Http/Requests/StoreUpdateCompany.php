<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateCompany extends FormRequest
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
            'category_id'    => ['required', 'integer', 'exists:categories,id'],
            'name'          => ['required', 'min:3', 'max:255', 'unique:companies,name'],
            'whatsapp'      => ['required', 'unique:companies,whatsapp'],
            'email'      => ['required', 'email', 'unique:companies,email'],
            'phone'      => ['nullable', 'unique:companies,phone'],
            'facebook'      => ['nullable', 'unique:companies,facebook'],
            'instagram'      => ['nullable', 'unique:companies,instagram'],
            'youtube'      => ['nullable', 'unique:companies,youtube'],
        ];
    }
}
