<?php

namespace App\Http\Controllers;

use App\Http\Requests\PresensiRequest;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PresensiController extends Controller
{
    /**
     * Menampilkan halaman presensi
     */
    public function index()
    {
        $wffLocations = Presensi::getWffLocations();
        $officeLocation = Presensi::getOfficeLocation();
        
        return view('presensi.index', compact('wffLocations', 'officeLocation'));
    }

    /**
     * Menyimpan data presensi
     */
   public function store(PresensiRequest $request): JsonResponse
{
    try {
        $data = $request->validated();
        
        // Cek apakah sudah presensi hari ini
        if (Presensi::sudahPresensiHariIni($data['nama'])) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan presensi hari ini'
            ], 409);
        }

        // Validasi lokasi
        $locationValidation = $this->validateLocation(
            $data['jenis_presensi'],
            $data['wff_location'] ?? null,
            $data['latitude'],
            $data['longitude']
        );

        if (!$locationValidation['valid']) {
            return response()->json([
                'success' => false,
                'message' => $locationValidation['message'],
                'distance' => $locationValidation['distance'] ?? null
            ], 400);
        }

        // Simpan data presensi
        $presensi = Presensi::create([
            'nama' => $data['nama'],
            'jenis_presensi' => $data['jenis_presensi'],
            'wff_location' => $data['wff_location'] ?? null,
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'alamat_lengkap' => $data['alamat_lengkap'],
            'waktu_presensi' => \Carbon\Carbon::now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil disimpan',
            'data' => [
                'id' => $presensi->id,
                'nama' => $presensi->nama,
                'jenis_presensi' => $presensi->jenis_presensi,
                'waktu_presensi' => $presensi->waktu_presensi_formatted
            ]
        ], 201);

    } catch (\Exception $e) {
        Log::error('Error saat menyimpan presensi: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan server'
        ], 500);
    }
}

    /**
     * Mengambil riwayat presensi
     */
    public function history(Request $request): JsonResponse
    {
        try {
            $query = Presensi::query();

            // Filter berdasarkan nama jika ada
            if ($request->filled('nama')) {
                $query->where('nama', 'like', '%' . $request->nama . '%');
            }

            // Filter berdasarkan jenis presensi jika ada
            if ($request->filled('jenis')) {
                $query->byJenis($request->jenis);
            }

            // Filter berdasarkan tanggal jika ada
            if ($request->filled('tanggal')) {
                $query->byDate($request->tanggal);
            }

            $presensi = $query->orderBy('waktu_presensi', 'desc')
                             ->paginate(20);

            return response()->json([
                'success' => true,
                'data' => $presensi->items(),
                'pagination' => [
                    'current_page' => $presensi->currentPage(),
                    'last_page' => $presensi->lastPage(),
                    'per_page' => $presensi->perPage(),
                    'total' => $presensi->total()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error saat mengambil riwayat presensi: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    /**
     * Mendapatkan statistik presensi
     */
    public function stats(): JsonResponse
    {
        try {
            $today = Carbon::today();
            $thisMonth = Carbon::now()->startOfMonth();

            $stats = [
                'presensi_hari_ini' => [
                    'total' => Presensi::byDate($today)->count(),
                    'wfo' => Presensi::byDate($today)->byJenis('WFO')->count(),
                    'wff' => Presensi::byDate($today)->byJenis('WFF')->count()
                ],
                'presensi_bulan_ini' => [
                    'total' => Presensi::where('waktu_presensi', '>=', $thisMonth)->count(),
                    'wfo' => Presensi::where('waktu_presensi', '>=', $thisMonth)->byJenis('WFO')->count(),
                    'wff' => Presensi::where('waktu_presensi', '>=', $thisMonth)->byJenis('WFF')->count()
                ]
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Error saat mengambil statistik: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    /**
     * Validasi lokasi presensi
     */
    private function validateLocation($jenisPresensi, $wffLocation, $latitude, $longitude): array
    {
        if ($jenisPresensi === 'WFO') {
            $office = Presensi::getOfficeLocation();
            $distance = $this->calculateDistance(
                $latitude,
                $longitude,
                $office['lat'],
                $office['lng']
            );

            if ($distance > $office['radius']) {
                return [
                    'valid' => false,
                    'message' => "Anda berada di luar radius kantor. Jarak: " . round($distance) . " meter (maksimal: {$office['radius']} meter)",
                    'distance' => round($distance)
                ];
            }
        } elseif ($jenisPresensi === 'WFF') {
            $wffLocations = Presensi::getWffLocations();
            
            if (!isset($wffLocations[$wffLocation])) {
                return [
                    'valid' => false,
                    'message' => 'Lokasi WFF tidak valid'
                ];
            }

            $targetLocation = $wffLocations[$wffLocation];
            $distance = $this->calculateDistance(
                $latitude,
                $longitude,
                $targetLocation['lat'],
                $targetLocation['lng']
            );

            if ($distance > $targetLocation['radius']) {
                return [
                    'valid' => false,
                    'message' => "Anda berada di luar radius {$targetLocation['name']}. Jarak: " . round($distance) . " meter (maksimal: {$targetLocation['radius']} meter)",
                    'distance' => round($distance)
                ];
            }
        }

        return ['valid' => true];
    }

    /**
     * Menghitung jarak menggunakan formula Haversine
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371000; // Earth radius in meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }

    /**
     * Mengambil data lokasi WFF dan kantor untuk frontend
     */
    public function locations(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'office' => Presensi::getOfficeLocation(),
                'wff_locations' => Presensi::getWffLocations()
            ]
        ]);
    }
}