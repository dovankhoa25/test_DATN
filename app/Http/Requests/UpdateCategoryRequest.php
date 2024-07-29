<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:1,0'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Trường tên là bắt buộc',
            'name.string' => 'Tên phải là chuỗi ký tự',
            'name.max' => 'Tên không vượt quá 255 ký tự',

            'status.required' => 'Trường Status là bắt buộc',
            'status.in' => 'Status chỉ là public hoặc Private',
        ];
    }
}
