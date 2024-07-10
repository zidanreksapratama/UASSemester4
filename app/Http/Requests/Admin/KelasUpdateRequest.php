<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class KelasUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Pastikan user diizinkan mengakses request ini
    }

    public function rules()
    {
        return [
            'kelas_name' => 'required|max:30|unique:kelas,kelas_name,' . $this->route('kelas'),
        ];
    }
}
