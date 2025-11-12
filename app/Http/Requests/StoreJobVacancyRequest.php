<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobVacancyRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'jenis_pekerjaan' => 'required|in:full_time,part_time'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul lowongan wajib diisi',
            'description.required' => 'Deskripsi lowongan wajib diisi',
            'location.required' => 'Lokasi wajib diisi',
            'company.required' => 'Nama perusahaan wajib diisi',
            'logo.image' => 'File harus berupa gambar',
            'logo.mimes' => 'Format gambar harus JPG, PNG, atau JPEG',
            'logo.max' => 'Ukuran gambar maksimal 2MB',
            'jenis_pekerjaan.required' => 'Jenis pekerjaan wajib diisi',
            'jenis_pekerjaan.in' => 'Jenis pekerjaan harus berupa full_time atau part_time'
        ];
    }
}
