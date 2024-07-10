<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AlternativeStoreRequest extends FormRequest
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
    public function rules()
    {
        return [
            'student_id' => 'required|string|regex:/^\d+\s\d+$/',
            'criteria_id' => 'required|array',
            'criteria_id.*' => 'exists:criterias,id',
            'alternative_value' => 'required|array',
            'alternative_value.*' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'ID siswa diperlukan.',
            'student_id.regex' => 'ID siswa harus berupa dua angka yang dipisahkan oleh spasi (misalnya, "3 1").',
            'criteria_id.required' => 'ID kriteria diperlukan.',
            'criteria_id.*.exists' => 'ID kriteria tidak valid.',
            'alternative_value.required' => 'Nilai alternatif diperlukan.',
            'alternative_value.*.numeric' => 'Nilai alternatif harus berupa angka.',
        ];
    }

}
