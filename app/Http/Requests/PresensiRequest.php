<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Presensi;

class PresensiRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'nama' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-zA-Z\s]+$/' // Hanya huruf dan spasi
            ],
            'jenis_presensi' => [
                'required',
                'in:WFO,WFF'
            ],
            'wff_location' => [
                'required_if:jenis_presensi,WFF',
                'nullable',
                'string',
                'max:50',
                function ($attribute, $value, $fail) {
                    if ($this->jenis_presensi === 'WFF' && $value) {
                        $wffLocations = array_keys(Presensi::getWffLocations());
                        if (!in_array($value, $wffLocations)) {
                            $fail('Lokasi WFF yang dipilih tidak valid.');
                        }
                    }
                }
            ],
            'latitude' => [
                'required',
                'numeric',
                'between:-90,90'
            ],
            'longitude' => [
                'required',
                'numeric',
                'between:-180,180'
            ],
            'alamat_lengkap' => [
                'nullable',
                'string',
                'max:255'
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'nama.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            
            'jenis_presensi.required' => 'Jenis presensi wajib dipilih.',
            'jenis_presensi.in' => 'Jenis presensi harus WFO atau WFF.',
            
            'wff_location.required_if' => 'Lokasi WFF wajib dipilih untuk jenis presensi WFF.',
            'wff_location.string' => 'Lokasi WFF harus berupa teks.',
            'wff_location.max' => 'Lokasi WFF maksimal 50 karakter.',
            
            'latitude.required' => 'Koordinat latitude wajib diisi.',
            'latitude.numeric' => 'Koordinat latitude harus berupa angka.',
            'latitude.between' => 'Koordinat latitude harus antara -90 dan 90.',
            
            'longitude.required' => 'Koordinat longitude wajib diisi.',
            'longitude.numeric' => 'Koordinat longitude harus berupa angka.',
            'longitude.between' => 'Koordinat longitude harus antara -180 dan 180.',
            
            'alamat_lengkap.string' => 'Alamat lengkap harus berupa teks.',
            'alamat_lengkap.max' => 'Alamat lengkap maksimal 255 karakter.'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Bersihkan dan format nama
        if ($this->has('nama')) {
            $this->merge([
                'nama' => trim(ucwords(strtolower($this->nama)))
            ]);
        }

        // Konversi koordinat ke float
        if ($this->has('latitude')) {
            $this->merge([
                'latitude' => (float) $this->latitude
            ]);
        }

        if ($this->has('longitude')) {
            $this->merge([
                'longitude' => (float) $this->longitude
            ]);
        }
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Cek apakah sudah presensi hari ini
            if (!$validator->errors()->has('nama')) {
                if (Presensi::sudahPresensiHariIni($this->nama)) {
                    $validator->errors()->add('nama', 'Anda sudah melakukan presensi hari ini.');
                }
            }

            // Validasi koordinat tidak boleh 0,0 (kemungkinan error GPS)
            if ($this->latitude == 0 && $this->longitude == 0) {
                $validator->errors()->add('latitude', 'Koordinat GPS tidak valid. Pastikan GPS aktif.');
            }
        });
    }
}