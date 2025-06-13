<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-green-600 dark:text-green-400 leading-tight">
                Dashboard Pengguna
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800">
                    <div class="text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-2">Halo, {{ auth()->user()->name }}! 👋</h3>
                        <p class="mb-4">Ini adalah halaman dashboard kamu sebagai pengguna biasa.</p>

                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-gray-500 dark:text-gray-400">
                                Silakan perbarui profil atau mulai menggunakan layanan kami.
                            </p>
                            
                            <div class="mt-4 space-x-4">
                                <a href="{{ route('profile.edit') }}" 
                                   class="bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200">
                                    Update Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>