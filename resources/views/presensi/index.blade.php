<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fas fa-clock mr-2"></i> Sistem Presensi
            </h2>
            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 text-sm rounded-full text-white" id="gpsStatus">
                    <i class="fas fa-satellite-dish"></i> GPS Ready
                </span>
            </div>
        </div>
    </x-slot>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-800 p-6 rounded-xl shadow-lg">
                    <div class="text-center">
                        <h3 class="text-3xl font-bold" id="todayTotal">-</h3>
                        <p class="text-sm">Presensi Hari Ini</p>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-lg">
                    <div class="text-center">
                        <h3 class="text-3xl font-bold" id="todayWFO">-</h3>
                        <p class="text-sm">WFO Hari Ini</p>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white p-6 rounded-xl shadow-lg">
                    <div class="text-center">
                        <h3 class="text-3xl font-bold" id="todayWFF">-</h3>
                        <p class="text-sm">WFF Hari Ini</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Form Presensi -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-gradient-to-r from-green-500 to-teal-500 text-white p-6">
                        <h4 class="text-xl font-semibold text-center">
                            <i class="fas fa-user-check mr-2"></i> Form Presensi
                        </h4>
                    </div>
                    <div class="p-6">
                        <form id="presensiForm">
                            @csrf

                            <!-- Nama -->
                            <div class="mb-4">
                                <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-user mr-1"></i> Nama Lengkap
                                </label>
                                <input type="text" 
                                       class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
                                       id="nama" 
                                       name="nama"
                                       placeholder="Masukkan nama lengkap" 
                                       required>
                                <div class="text-red-500 text-sm mt-1 hidden" id="namaError"></div>
                            </div>

                            <!-- Jenis Presensi -->
                            <div class="mb-4">
                                <label for="jenis_presensi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-briefcase mr-1"></i> Jenis Presensi
                                </label>
                                <select class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
                                        id="jenis_presensi" 
                                        name="jenis_presensi" 
                                        required>
                                    <option value="">Pilih jenis presensi</option>
                                    <option value="WFO">WFO (Work From Office)</option>
                                    <option value="WFF">WFF (Work From Field)</option>
                                </select>
                                <div class="text-red-500 text-sm mt-1 hidden" id="jenisError"></div>
                            </div>

                            <!-- Lokasi WFF -->
                            <div class="mb-4 hidden" id="wffLocationGroup">
                                <label for="wff_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-map-marker-alt mr-1"></i> Lokasi WFF
                                </label>
                                <select class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
                                        id="wff_location" 
                                        name="wff_location">
                                    <option value="">Pilih lokasi WFF</option>
                                    @foreach ($wffLocations as $key => $location)
                                        <option value="{{ $key }}">{{ $location['name'] }}</option>
                                    @endforeach
                                </select>
                                <div class="text-red-500 text-sm mt-1 hidden" id="wffLocationError"></div>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 mt-2 hidden" id="wffLocationInfo">
                                    <small class="text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        <span id="wffLocationDetails"></span>
                                    </small>
                                </div>
                            </div>

                            <!-- Koordinat (Hidden) -->
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                            <input type="hidden" id="alamat_lengkap" name="alamat_lengkap">

                            <!-- Info Lokasi -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4" id="currentLocation">
                                <div class="flex items-center">
                                    <i class="fas fa-location-arrow text-blue-500 mr-2"></i>
                                    <span class="text-gray-600 dark:text-gray-400">Mendapatkan lokasi...</span>
                                    <div class="ml-auto hidden" id="loadingSpinner">
                                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-500"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center" 
                                    id="submitBtn" 
                                    disabled>
                                <i class="fas fa-check-circle mr-2"></i> Submit Presensi
                                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white ml-2 hidden" id="submitSpinner"></div>
                            </button>

                            <!-- Debug Info -->
                            <div class="mt-3">
                                <small class="text-gray-500 dark:text-gray-400">
                                    <strong>Debug Info:</strong>
                                    <div id="debugInfo">GPS belum aktif</div>
                                </small>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Riwayat Presensi -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 flex justify-between items-center">
                        <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                            <i class="fas fa-history mr-2"></i> Riwayat Presensi
                        </h4>
                        <button class="bg-teal-500 hover:bg-teal-600 text-white px-3 py-1 rounded text-sm" onclick="loadHistory()">
                            <i class="fas fa-refresh mr-1"></i> Refresh
                        </button>
                    </div>
                    <div class="p-6">
                        <!-- Filter -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <input type="text" 
                                   class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white text-sm" 
                                   id="filterNama"
                                   placeholder="Filter nama...">
                            <select class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white text-sm" 
                                    id="filterJenis">
                                <option value="">Semua jenis</option>
                                <option value="WFO">WFO</option>
                                <option value="WFF">WFF</option>
                            </select>
                        </div>

                        <!-- History List -->
                        <div id="historyList" class="max-h-96 overflow-y-auto">
                            <div class="text-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-hourglass-half"></i> Memuat data...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
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
                    $('#wffLocationGroup').removeClass('hidden');
                    $('#wff_location').prop('required', true);
                } else {
                    $('#wffLocationGroup').addClass('hidden');
                    $('#wff_location').prop('required', false);
                    $('#wffLocationInfo').addClass('hidden');
                }
                updateLocationValidation();
            });

            // WFF Location change
            $('#wff_location').change(function() {
                const locationKey = $(this).val();
                if (locationKey && wffLocations[locationKey]) {
                    const location = wffLocations[locationKey];
                    $('#wffLocationDetails').text(`${location.address} - Radius: ${location.radius}m`);
                    $('#wffLocationInfo').removeClass('hidden');
                } else {
                    $('#wffLocationInfo').addClass('hidden');
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
                $('#gpsStatus').removeClass('bg-green-500').addClass('bg-yellow-500').html(
                    '<i class="fas fa-spinner fa-spin"></i> Mencari GPS...');
                $('#loadingSpinner').removeClass('hidden');

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

                        $('#gpsStatus').removeClass('bg-yellow-500').addClass('bg-green-500').html(
                            '<i class="fas fa-satellite-dish"></i> GPS Aktif');
                        $('#loadingSpinner').addClass('hidden');

                        // Enable submit button when GPS is ready
                        $('#submitBtn').prop('disabled', false);

                        updateLocationValidation();

                        console.log('GPS berhasil didapat:', currentPosition);
                    },
                    function(error) {
                        console.error('Error getting location:', error);
                        $('#gpsStatus').removeClass('bg-yellow-500').addClass('bg-red-500').html(
                            '<i class="fas fa-exclamation-triangle"></i> GPS Error');
                        $('#loadingSpinner').addClass('hidden');

                        $('#currentLocation').html(`
                            <div class="text-red-600 dark:text-red-400">
                                <i class="fas fa-exclamation-triangle"></i>
                                Gagal mendapatkan lokasi: ${getLocationErrorMessage(error.code)}
                                <br><small>Coba <a href="javascript:void(0)" onclick="getCurrentLocation()" class="text-blue-600 dark:text-blue-400 hover:underline">refresh GPS</a> atau aktifkan lokasi di browser</small>
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
                $('#gpsStatus').removeClass('bg-green-500').addClass('bg-red-500').html(
                    '<i class="fas fa-times"></i> GPS Tidak Didukung');
                $('#currentLocation').html(`
                    <div class="text-red-600 dark:text-red-400">
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
                <div class="flex items-center">
                    <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                    <small class="text-gray-600 dark:text-gray-400">Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}</small>
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
                    <div class="text-yellow-600 dark:text-yellow-400">
                        <i class="fas fa-exclamation-triangle"></i>
                        Jarak dari kantor: ${Math.round(distance)}m (Maksimal: ${officeLocation.radius}m)
                    </div>
                `);
            } else {
                $('#currentLocation').html(`
                    <div class="text-green-600 dark:text-green-400">
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
                    <div class="text-yellow-600 dark:text-yellow-400">
                        <i class="fas fa-exclamation-triangle"></i>
                        Jarak dari ${location.name}: ${Math.round(distance)}m (Maksimal: ${location.radius}m)
                    </div>
                `);
            } else {
                $('#currentLocation').html(`
                    <div class="text-green-600 dark:text-green-400">
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
            $('#submitSpinner').removeClass('hidden');

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
                        $('#wffLocationGroup').addClass('hidden');
                        $('#wffLocationInfo').addClass('hidden');
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
                    $('#submitSpinner').addClass('hidden');
                }
            });
        }

        function showValidationErrors(errors) {
            // Clear previous errors
            $('input, select').removeClass('border-red-500');
            $('.text-red-500').addClass('hidden');

            // Show new errors
            $.each(errors, function(field, messages) {
                const input = $(`#${field}`);
                const errorDiv = $(`#${field}Error`);

                input.addClass('border-red-500');
                errorDiv.text(messages[0]).removeClass('hidden');
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
                    <div class="text-center text-red-600 dark:text-red-400">
                        <i class="fas fa-times"></i> Gagal memuat data
                    </div>
                `);
                });
        }

        function displayHistory(data) {
            if (data.length === 0) {
                $('#historyList').html(`
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-inbox"></i> Tidak ada data
                    </div>
                `);
                return;
            }

            let html = '';
            data.forEach(function(item) {
                const badgeClass = item.jenis_presensi === 'WFO' ? 'bg-blue-500' : 'bg-teal-500';
                const icon = item.jenis_presensi === 'WFO' ? 'fa-building' : 'fa-map-marker-alt';

                html += `
                    <div class="border-b border-gray-200 dark:border-gray-600 pb-3 mb-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <h6 class="font-medium text-gray-900 dark:text-gray-100 mb-1">${item.nama}</h6>
                                <small class="text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-clock"></i> ${item.waktu_presensi_formatted}
                                </small>
                            </div>
                            <span class="px-2 py-1 text-xs text-white rounded ${badgeClass}">
                                <i class="fas ${icon}"></i> ${item.jenis_presensi}
                            </span>
                        </div>
                        ${item.wff_location ? `
                                <small class="text-gray-500 dark:text-gray-400 block mt-1">
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
</x-app-layout>