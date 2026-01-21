<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFilterRequest extends FormRequest
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
            'category'    => ['nullable', 'string', 'exists:categories,name'],
            'search'      => ['nullable', 'string', 'max:255'],
            'per_page'    => ['nullable', 'integer', 'min:1', 'max:15'],
        ];
    }

    /**
     * Массив содержащий только фильтры
     * 
     * @return array
     */
    public function filters(): array
    {
        return $this->only([
            'category',
            'search',
        ]);
    }

    /**
     * @return int
     */
    public function perPage(): int
    {
        return (int) $this->input('per_page', 15);
    }
}
