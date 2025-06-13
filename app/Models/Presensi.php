<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
        'nama',
        'jenis_presensi',
        'wff_location',
        'latitude',
        'longitude',
        'alamat_lengkap',
        'waktu_presensi'
    ];

    protected $casts = [
        'waktu_presensi' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];

    // TAMBAHKAN INI: Include accessor dalam JSON serialization
    protected $appends = [
        'waktu_presensi_formatted',
        'jenis_presensi_label'
    ];

    // Accessor untuk format waktu presensi
    public function getWaktuPresensiFormattedAttribute()
    {
        return $this->waktu_presensi ? $this->waktu_presensi->format('d/m/Y H:i:s') : null;
    }

    // Accessor untuk nama jenis presensi yang readable
    public function getJenisPresensiLabelAttribute()
    {
        return $this->jenis_presensi === 'WFO' ? 'Work From Office' : 'Work From Field';
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('waktu_presensi', $date);
    }

    // Scope untuk filter berdasarkan jenis presensi
    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis_presensi', $jenis);
    }

    // Method untuk cek apakah sudah presensi hari ini
    public static function sudahPresensiHariIni($nama)
    {
        return self::where('nama', $nama)
            ->whereDate('waktu_presensi', Carbon::today())
            ->exists();
    }

    // Method untuk mendapatkan koordinat lokasi WFF
    public static function getWffLocations()
    {
        return [
            'mall_plaza' => [
                'name' => 'Mall Plaza Andalas',
                'address' => 'Jl. Veteran No.1, Padang',
                'lat' => -0.9492,
                'lng' => 100.3543,
                'radius' => 100
            ],
            'universitas_andalas' => [
                'name' => 'Universitas Andalas',
                'address' => 'Limau Manis, Padang',
                'lat' => -0.9149,
                'lng' => 100.4627,
                'radius' => 600
            ],
            'bandara_minangkabau' => [
                'name' => 'Bandara Minangkabau',
                'address' => 'Padang Pariaman',
                'lat' => -0.7868,
                'lng' => 100.2797,
                'radius' => 300
            ],
            'rs_dr_m_djamil' => [
                'name' => 'RS Dr. M. Djamil',
                'address' => 'Jl. Perintis Kemerdekaan, Padang',
                'lat' => -0.9213,
                'lng' => 100.3585,
                'radius' => 150
            ],
            'balai_kota_padang' => [
                'name' => 'Balai Kota Padang',
                'address' => 'Jl. Bagindo Aziz Chan, Padang',
                'lat' => -0.9471,
                'lng' => 100.4172,
                'radius' => 200
            ]
        ];
    }

    // Method untuk mendapatkan koordinat kantor pusat
    public static function getOfficeLocation()
    {
        return [
            'name' => 'Kantor Pusat',
            'lat' => -0.9145094,
            'lng' => 100.4660308,
            'radius' => 200
        ];
    }
}