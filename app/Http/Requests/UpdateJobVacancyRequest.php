<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobVacancyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // ✅ Ubah jadi true (atau tambahkan logic authorization jika perlu)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul lowongan wajib diisi.',
            'description.required' => 'Deskripsi lowongan wajib diisi.',
            'company.required' => 'Nama perusahaan wajib diisi.',
            'location.required' => 'Lokasi wajib diisi.',
            'salary.numeric' => 'Gaji harus berupa angka.',
            'logo.image' => 'File harus berupa gambar.',
            'logo.mimes' => 'Format gambar harus: jpeg, png, jpg, atau gif.',
            'logo.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
