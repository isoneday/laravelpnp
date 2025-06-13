<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Tambah Pengguna Baru
            </h2>
            <a href="{{ route('penggunas.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800">
                    <!-- Notifikasi -->
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('penggunas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid gap-6 mb-6 md:grid-cols-1">
                            <!-- Nama -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    Nama <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}" 
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                       required>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                       required>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                       required>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    Konfirmasi Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password_confirmation"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                       required>
                            </div>

                            <!-- Telepon -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    Nomor Telepon
                                </label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- File Upload -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    Upload File (PDF/JPG/PNG)
                                </label>
                                <input type="file" name="file_upload" accept=".pdf,.jpg,.jpeg,.png"
                                       class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600">
                                @error('file_upload')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Format: PDF, JPG, JPEG, PNG (Maks. 2MB)</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-indigo-500 dark:hover:bg-indigo-600">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>