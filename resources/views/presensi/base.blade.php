<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Presensi</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
        }

        .card-header {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            text-align: center;
            padding: 1.5rem;
        }

        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
        }

        .btn-info {
            background: linear-gradient(45deg, #17a2b8, #138496);
            border: none;
            border-radius: 10px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .location-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 10px;
        }

        .status-badge {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .stats-card {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            color: #333;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .loading-spinner {
            display: none;
        }

        .map-container {
            height: 300px;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .card {
                margin: 10px 0;
            }
        }
    </style>
</head>

<body>
    <!-- Status Badge -->
    <div class="status-badge">
        <span class="badge bg-success" id="gpsStatus">
            <i class="fas fa-satellite-dish"></i> GPS Ready
        </span>
    </div>

    <div class="container py-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="text-white mb-2">
                <i class="fas fa-clock"></i> Sistem Presensi
            </h1>
            <p class="text-white-50">Lakukan presensi dengan mudah dan akurat</p>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card text-center">
                    <h3 id="todayTotal">-</h3>
                    <p class="mb-0">Presensi Hari Ini</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card text-center">
                    <h3 id="todayWFO">-</h3>
                    <p class="mb-0">WFO Hari Ini</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card text-center">
                    <h3 id="todayWFF">-</h3>
                    <p class="mb-0">WFF Hari Ini</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Form Presensi -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-user-check"></i> Form Presensi
                        </h4>
                    </div>
                    <div class="card-body">
                        <form id="presensiForm">
                            @csrf

                            <!-- Nama -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    <i class="fas fa-user"></i> Nama Lengkap
                                </label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Masukkan nama lengkap" required>
                                <div class="invalid-feedback" id="namaError"></div>
                            </div>

                            <!-- Jenis Presensi -->
                            <div class="mb-3">
                                <label for="jenis_presensi" class="form-label">
                                    <i class="fas fa-briefcase"></i> Jenis Presensi
                                </label>
                                <select class="form-select" id="jenis_presensi" name="jenis_presensi" required>
                                    <option value="">Pilih jenis presensi</option>
                                    <option value="WFO">WFO (Work From Office)</option>
                                    <option value="WFF">WFF (Work From Field)</option>
                                </select>
                                <div class="invalid-feedback" id="jenisError"></div>
                            </div>

                            <!-- Lokasi WFF -->
                            <div class="mb-3" id="wffLocationGroup" style="display: none;">
                                <label for="wff_location" class="form-label">
                                    <i class="fas fa-map-marker-alt"></i> Lokasi WFF
                                </label>
                                <select class="form-select" id="wff_location" name="wff_location">
                                    <option value="">Pilih lokasi WFF</option>
                                    @foreach ($wffLocations as $key => $location)
                                        <option value="{{ $key }}">{{ $location['name'] }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="wffLocationError"></div>
                                <div class="location-info" id="wffLocationInfo" style="display: none;">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        <span id="wffLocationDetails"></span>
                                    </small>
                                </div>
                            </div>

                            <!-- Koordinat (Hidden) -->
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                            <input type="hidden" id="alamat_lengkap" name="alamat_lengkap">

                            <!-- Info Lokasi -->
                            <div class="location-info mb-3" id="currentLocation">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-location-arrow text-primary me-2"></i>
                                    <span class="text-muted">Mendapatkan lokasi...</span>
                                    <div class="loading-spinner ms-auto">
                                        <div class="spinner-border spinner-border-sm" role="status"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100" id="submitBtn" disabled>
                                <i class="fas fa-check-circle"></i> Submit Presensi
                                <div class="spinner-border spinner-border-sm ms-2 d-none" id="submitSpinner"></div>
                            </button>

                            <!-- Debug Info (Remove in production) -->
                            <div class="mt-2">
                                <small class="text-muted">
                                    <strong>Debug Info:</strong>
                                    <div id="debugInfo">GPS belum aktif</div>
                                </small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Riwayat Presensi -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-history"></i> Riwayat Presensi
                        </h4>
                        <button class="btn btn-info btn-sm" onclick="loadHistory()">
                            <i class="fas fa-refresh"></i> Refresh
                        </button>
                    </div>
                    <div class="card-body">
                        <!-- Filter -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control form-control-sm" id="filterNama"
                                    placeholder="Filter nama...">
                            </div>
                            <div class="col-md-6">
                                <select class="form-select form-select-sm" id="filterJenis">
                                    <option value="">Semua jenis</option>
                                    <option value="WFO">WFO</option>
                                    <option value="WFF">WFF</option>
                                </select>
                            </div>
                        </div>

                        <!-- History List -->
                        <div id="historyList" style="max-height: 400px; overflow-y: auto;">
                            <div class="text-center text-muted">
                                <i class="fas fa-hourglass-half"></i> Memuat data...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Global variables
        let currentPosition = null;
        let wffLocations = @json($wffLocations);
        let officeLocation = @json($officeLocation);

        // Initialize app
        $(document).ready(function() {
            initializeApp();
        });

        function initializeApp() {
            setupCSRFToken();
            getCurrentLocation();
            loadStats();
            loadHistory();
            setupEventListeners();
        }

        function setupCSRFToken() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        function setupEventListeners() {
            // Jenis presensi change
            $('#jenis_presensi').change(function() {
                const jenis = $(this).val();
                if (jenis === 'WFF') {
                    $('#wffLocationGroup').slideDown();
                    $('#wff_location').prop('required', true);
                } else {
                    $('#wffLocationGroup').slideUp();
                    $('#wff_location').prop('required', false);
                    $('#wffLocationInfo').hide();
                }
                updateLocationValidation();
            });

            // WFF Location change
            $('#wff_location').change(function() {
                const locationKey = $(this).val();
                if (locationKey && wffLocations[locationKey]) {
                    const location = wffLocations[locationKey];
                    $('#wffLocationDetails').text(`${location.address} - Radius: ${location.radius}m`);
                    $('#wffLocationInfo').slideDown();
                } else {
                    $('#wffLocationInfo').slideUp();
                }
                updateLocationValidation();
            });

            // Form submit
            $('#presensiForm').submit(function(e) {
                e.preventDefault();
                submitPresensi();
            });

            // Filter handlers
            $('#filterNama, #filterJenis').on('input change', function() {
                setTimeout(loadHistory, 300);
            });
        }

        function getCurrentLocation() {
            if (navigator.geolocation) {
                $('#gpsStatus').removeClass('bg-success').addClass('bg-warning').html(
                    '<i class="fas fa-spinner fa-spin"></i> Mencari GPS...');
                $('.loading-spinner').show();

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        currentPosition = {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude,
                            accuracy: position.coords.accuracy
                        };

                        $('#latitude').val(currentPosition.latitude);
                        $('#longitude').val(currentPosition.longitude);

                        // Get address from coordinates
                        getAddressFromCoordinates(currentPosition.latitude, currentPosition.longitude);

                        $('#gpsStatus').removeClass('bg-warning').addClass('bg-success').html(
                            '<i class="fas fa-satellite-dish"></i> GPS Aktif');
                        $('.loading-spinner').hide();

                        // Enable submit button when GPS is ready
                        $('#submitBtn').prop('disabled', false);

                        updateLocationValidation();

                        console.log('GPS berhasil didapat:', currentPosition);
                    },
                    function(error) {
                        console.error('Error getting location:', error);
                        $('#gpsStatus').removeClass('bg-warning').addClass('bg-danger').html(
                            '<i class="fas fa-exclamation-triangle"></i> GPS Error');
                        $('.loading-spinner').hide();

                        $('#currentLocation').html(`
                            <div class="text-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                                Gagal mendapatkan lokasi: ${getLocationErrorMessage(error.code)}
                                <br><small>Coba <a href="javascript:void(0)" onclick="getCurrentLocation()">refresh GPS</a> atau aktifkan lokasi di browser</small>
                            </div>
                        `);

                        // Disable submit button when GPS fails
                        $('#submitBtn').prop('disabled', true);
                    }, {
                        enableHighAccuracy: true,
                        timeout: 15000,
                        maximumAge: 60000
                    }
                );
            } else {
                $('#gpsStatus').removeClass('bg-success').addClass('bg-danger').html(
                    '<i class="fas fa-times"></i> GPS Tidak Didukung');
                $('#currentLocation').html(`
                    <div class="text-danger">
                        <i class="fas fa-times"></i>
                        Browser tidak mendukung geolocation
                        <br><small>Gunakan browser yang mendukung GPS</small>
                    </div>
                `);
                $('#submitBtn').prop('disabled', true);
            }
        }

        function getAddressFromCoordinates(lat, lng) {
            // Simulasi mendapatkan alamat dari koordinat
            // Dalam implementasi nyata, gunakan reverse geocoding API
            $('#alamat_lengkap').val(`Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`);
            $('#currentLocation').html(`
                <div class="d-flex align-items-center">
                    <i class="fas fa-map-marker-alt text-success me-2"></i>
                    <small class="text-muted">Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}</small>
                </div>
            `);

            // Update debug info
            $('#debugInfo').html(`GPS: ✓ | Lat: ${lat.toFixed(4)} | Lng: ${lng.toFixed(4)}`);
        }

        function getLocationErrorMessage(code) {
            switch (code) {
                case 1:
                    return 'Izin akses lokasi ditolak';
                case 2:
                    return 'Lokasi tidak tersedia';
                case 3:
                    return 'Timeout saat mendapatkan lokasi';
                default:
                    return 'Error tidak diketahui';
            }
        }

        function updateLocationValidation() {
            if (!currentPosition) return;

            const jenis = $('#jenis_presensi').val();
            const wffLocation = $('#wff_location').val();

            if (jenis === 'WFO') {
                validateOfficeLocation();
            } else if (jenis === 'WFF' && wffLocation) {
                validateWFFLocation(wffLocation);
            }
        }

        function validateOfficeLocation() {
            const distance = calculateDistance(
                currentPosition.latitude,
                currentPosition.longitude,
                officeLocation.lat,
                officeLocation.lng
            );

            if (distance > officeLocation.radius) {
                $('#currentLocation').html(`
                    <div class="text-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        Jarak dari kantor: ${Math.round(distance)}m (Maksimal: ${officeLocation.radius}m)
                    </div>
                `);
            } else {
                $('#currentLocation').html(`
                    <div class="text-success">
                        <i class="fas fa-check-circle"></i>
                        Lokasi valid - Jarak dari kantor: ${Math.round(distance)}m
                    </div>
                `);
            }
        }

        function validateWFFLocation(locationKey) {
            const location = wffLocations[locationKey];
            const distance = calculateDistance(
                currentPosition.latitude,
                currentPosition.longitude,
                location.lat,
                location.lng
            );

            if (distance > location.radius) {
                $('#currentLocation').html(`
                    <div class="text-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        Jarak dari ${location.name}: ${Math.round(distance)}m (Maksimal: ${location.radius}m)
                    </div>
                `);
            } else {
                $('#currentLocation').html(`
                    <div class="text-success">
                        <i class="fas fa-check-circle"></i>
                        Lokasi valid - Jarak dari ${location.name}: ${Math.round(distance)}m
                    </div>
                `);
            }
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371000; // Earth's radius in meters
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function submitPresensi() {
            // Debug: Log current position
            console.log('Current Position:', currentPosition);
            console.log('Form Data:', $('#presensiForm').serialize());

            if (!currentPosition) {
                Swal.fire({
                    icon: 'error',
                    title: 'GPS Tidak Aktif',
                    text: 'Mohon aktifkan GPS dan refresh halaman'
                });
                return;
            }

            const formData = new FormData($('#presensiForm')[0]);

            // Debug: Log form data
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            if ($('#jenis_presensi').val() === 'WFO') {
                $('#wff_location').prop('disabled', true); // agar tidak ikut dikirim
            } else {
                $('#wff_location').prop('disabled', false);
            }
            $('#submitBtn').prop('disabled', true);
            $('#submitSpinner').removeClass('d-none');

            $.ajax({
                url: '{{ route('api.presensi.store') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $('#presensiForm')[0].reset();
                        $('#wffLocationGroup').hide();
                        $('#wffLocationInfo').hide();
                        loadStats();
                        loadHistory();
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;

                    if (xhr.status === 422) {
                        // Validation errors
                        showValidationErrors(response.errors);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message || 'Terjadi kesalahan'
                        });
                    }
                },
                complete: function() {
                    $('#submitBtn').prop('disabled', false);
                    $('#submitSpinner').addClass('d-none');
                }
            });
        }

        function showValidationErrors(errors) {
            // Clear previous errors
            $('.form-control, .form-select').removeClass('is-invalid');
            $('.invalid-feedback').text('');

            // Show new errors
            $.each(errors, function(field, messages) {
                const input = $(`#${field}`);
                const errorDiv = $(`#${field}Error`);

                input.addClass('is-invalid');
                errorDiv.text(messages[0]);
            });
        }

        function loadStats() {
            $.get('{{ route('api.presensi.stats') }}')
                .done(function(response) {
                    if (response.success) {
                        const stats = response.data;
                        $('#todayTotal').text(stats.presensi_hari_ini.total);
                        $('#todayWFO').text(stats.presensi_hari_ini.wfo);
                        $('#todayWFF').text(stats.presensi_hari_ini.wff);
                    }
                })
                .fail(function() {
                    $('#todayTotal, #todayWFO, #todayWFF').text('Error');
                });
        }

        function loadHistory() {
            const nama = $('#filterNama').val();
            const jenis = $('#filterJenis').val();

            $.get('{{ route('api.presensi.history') }}', {
                    nama: nama,
                    jenis: jenis
                })
                .done(function(response) {
                    if (response.success) {
                        displayHistory(response.data);
                    }
                })
                .fail(function() {
                    $('#historyList').html(`
                    <div class="text-center text-danger">
                        <i class="fas fa-times"></i> Gagal memuat data
                    </div>
                `);
                });
        }

        function displayHistory(data) {
            if (data.length === 0) {
                $('#historyList').html(`
                    <div class="text-center text-muted">
                        <i class="fas fa-inbox"></i> Tidak ada data
                    </div>
                `);
                return;
            }

            let html = '';
            data.forEach(function(item) {
                const badge = item.jenis_presensi === 'WFO' ? 'bg-primary' : 'bg-info';
                const icon = item.jenis_presensi === 'WFO' ? 'fa-building' : 'fa-map-marker-alt';

                html += `
                    <div class="border-bottom pb-2 mb-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">${item.nama}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> ${item.waktu_presensi_formatted}
                                </small>
                            </div>
                            <span class="badge ${badge}">
                                <i class="fas ${icon}"></i> ${item.jenis_presensi}
                            </span>
                        </div>
                        ${item.wff_location ? `
                                <small class="text-muted d-block">
                                    <i class="fas fa-map-pin"></i> ${item.wff_location}
                                </small>
                            ` : ''}
                    </div>
                `;
            });

            $('#historyList').html(html);
        }

        // Auto-refresh stats setiap 5 menit
        setInterval(loadStats, 300000);
    </script>
</body>

</html>
