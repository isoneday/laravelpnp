<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenggunaRequest extends FormRequest
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
            //
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:penggunas',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|digits_between:9,13',
            'file_upload' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Nama Tidak boleh kosong',
            'email.required' => 'Email Tidak boleh kosong',
            'email.unique' => 'Email tersebut sudah digunakan',
            'password.required' => 'Password Tidak boleh kosong',
            'password.confirmed' => 'Konfirmasi Password Tidak Cocok',
            'file_upload.required' => 'Upload File Tidak boleh kosong',
        ];
    }
}
