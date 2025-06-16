<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                📝 Catatan Digital
            </h2>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                Kelola tugas harian Anda dengan mudah
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Form Section -->
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input 
                            type="text" 
                            id="todoInput" 
                            placeholder="Tulis tugas baru, contoh: Belajar prompt engineering..."
                            maxlength="255"
                            class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                        >
                        <button 
                            id="addBtn"
                            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200 min-w-[120px]"
                        >
                            Tambah
                        </button>
                    </div>
                    <div id="errorMessage" class="hidden mt-2 p-3 bg-red-50 border-l-4 border-red-400 text-red-700 rounded text-sm"></div>
                </div>

                <!-- Todos Section -->
                <div class="p-6 bg-white dark:bg-gray-800">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">
                        Daftar Tugas (<span id="taskCounter">{{ $todos->count() }}</span>)
                    </h3>
                    
                    <div id="todoList" class="space-y-3">
                        @forelse($todos as $todo)
                            <div class="todo-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border-l-4 border-indigo-500 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200" data-id="{{ $todo->id }}">
                                <div class="flex justify-between items-center gap-4">
                                    <span class="todo-text text-gray-900 dark:text-gray-100 flex-1 break-words">{{ $todo->title }}</span>
                                    <div class="flex space-x-2 flex-shrink-0">
                                        <button 
                                            class="edit-btn px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white text-sm rounded transition-colors duration-200"
                                            onclick="editTodo({{ $todo->id }}, '{{ addslashes($todo->title) }}')"
                                        >
                                            Edit
                                        </button>
                                        <button 
                                            class="delete-btn px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-sm rounded transition-colors duration-200"
                                            onclick="deleteTodo({{ $todo->id }})"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state text-center py-16">
                                <div class="text-6xl mb-4 opacity-50">📋</div>
                                <div class="text-gray-500 dark:text-gray-400 text-lg">
                                    Belum ada tugas yang ditambahkan.<br>
                                    Mulai dengan menambahkan tugas pertama Anda!
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3 border-b dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">✏️ Edit Tugas</h3>
                <button 
                    class="close-btn text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-2xl font-bold"
                    onclick="closeEditModal()"
                >
                    &times;
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="py-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Nama Tugas
                </label>
                <input 
                    type="text" 
                    id="editInput" 
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                    placeholder="Masukkan nama tugas..."
                    maxlength="255"
                >
                <div id="editErrorMessage" class="hidden mt-2 p-2 bg-red-50 border-l-4 border-red-400 text-red-700 rounded text-sm"></div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex justify-end space-x-3 pt-3 border-t dark:border-gray-600">
                <button 
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded transition-colors duration-200"
                    onclick="closeEditModal()"
                >
                    Batal
                </button>
                <button 
                    id="saveBtn"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded transition-colors duration-200"
                    onclick="saveEditTodo()"
                >
                    Simpan
                </button>
            </div>
        </div>
    </div>

    <!-- Success Message Template -->
    <div id="successTemplate" class="hidden fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300"></div>

    <script>
        // Setup CSRF token untuk AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Element references
        const todoInput = document.getElementById('todoInput');
        const addBtn = document.getElementById('addBtn');
        const todoList = document.getElementById('todoList');
        const errorMessage = document.getElementById('errorMessage');
        const editModal = document.getElementById('editModal');
        const editInput = document.getElementById('editInput');
        const saveBtn = document.getElementById('saveBtn');
        const editErrorMessage = document.getElementById('editErrorMessage');
        const taskCounter = document.getElementById('taskCounter');
        
        // Variable untuk menyimpan ID todo yang sedang diedit
        let currentEditId = null;

        // Add event listeners
        addBtn.addEventListener('click', addTodo);
        todoInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                addTodo();
            }
        });

        // Event listener untuk modal
        editInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                saveEditTodo();
            }
        });

        // Close modal saat klik outside
        editModal.addEventListener('click', function(e) {
            if (e.target === editModal) {
                closeEditModal();
            }
        });

        // Close modal dengan ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !editModal.classList.contains('hidden')) {
                closeEditModal();
            }
        });

        // Auto-focus input saat halaman dimuat
        todoInput.focus();

        // Fungsi untuk menambah tugas
        async function addTodo() {
            const title = todoInput.value.trim();
            
            // Validasi input kosong
            if (!title) {
                showError('Tugas tidak boleh kosong!');
                todoInput.focus();
                return;
            }

            // Validasi panjang input
            if (title.length > 255) {
                showError('Tugas terlalu panjang! Maksimal 255 karakter.');
                return;
            }

            // Set loading state
            setLoadingState(true);
            hideError();

            try {
                const response = await fetch('/todos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ title: title })
                });

                const data = await response.json();

                if (data.success) {
                    // Hapus empty state jika ada
                    const emptyState = todoList.querySelector('.empty-state');
                    if (emptyState) {
                        emptyState.remove();
                    }

                    // Tambah item ke list
                    addTodoToList(data.todo);
                    
                    // Reset form
                    todoInput.value = '';
                    todoInput.focus();
                    
                    // Update counter
                    updateCounter();
                    
                    // Show success message
                    showSuccess('Tugas berhasil ditambahkan!');
                } else {
                    throw new Error('Gagal menambahkan tugas');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                setLoadingState(false);
            }
        }

        // Fungsi untuk menghapus tugas
        async function deleteTodo(id) {
            if (!confirm('Yakin ingin menghapus tugas ini?')) {
                return;
            }

            const todoItem = document.querySelector(`[data-id="${id}"]`);
            if (!todoItem) return;

            // Set loading state pada item
            todoItem.style.opacity = '0.6';
            todoItem.style.pointerEvents = 'none';

            try {
                const response = await fetch(`/todos/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Animasi hapus
                    todoItem.style.transform = 'translateX(-100%)';
                    todoItem.style.transition = 'all 0.3s ease';
                    
                    setTimeout(() => {
                        todoItem.remove();
                        updateCounter();
                        
                        // Tampilkan empty state jika tidak ada tugas
                        if (todoList.children.length === 0) {
                            showEmptyState();
                        }
                    }, 300);
                    
                    showSuccess('Tugas berhasil dihapus!');
                } else {
                    throw new Error('Gagal menghapus tugas');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Gagal menghapus tugas. Silakan coba lagi.');
                
                // Reset loading state
                todoItem.style.opacity = '1';
                todoItem.style.pointerEvents = 'auto';
            }
        }

        // Fungsi untuk membuka modal edit
        function editTodo(id, title) {
            currentEditId = id;
            editInput.value = title;
            editModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Focus ke input setelah animasi
            setTimeout(() => {
                editInput.focus();
                editInput.select();
            }, 100);
            
            hideEditError();
        }

        // Fungsi untuk menutup modal edit
        function closeEditModal() {
            editModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentEditId = null;
            editInput.value = '';
            hideEditError();
            setEditLoadingState(false);
        }

        // Fungsi untuk menyimpan perubahan edit
        async function saveEditTodo() {
            const title = editInput.value.trim();
            
            // Validasi input kosong
            if (!title) {
                showEditError('Tugas tidak boleh kosong!');
                editInput.focus();
                return;
            }

            // Validasi panjang input
            if (title.length > 255) {
                showEditError('Tugas terlalu panjang! Maksimal 255 karakter.');
                return;
            }

            // Set loading state
            setEditLoadingState(true);
            hideEditError();

            try {
                const response = await fetch(`/todos/${currentEditId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ title: title })
                });

                const data = await response.json();

                if (data.success) {
                    // Update tampilan todo di list
                    updateTodoInList(data.todo);
                    
                    // Close modal
                    closeEditModal();
                    
                    // Show success message
                    showSuccess('Tugas berhasil diupdate!');
                } else {
                    throw new Error('Gagal mengupdate tugas');
                }
            } catch (error) {
                console.error('Error:', error);
                showEditError('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                setEditLoadingState(false);
            }
        }

        // Fungsi untuk menambah todo ke list
        function addTodoToList(todo) {
            const div = document.createElement('div');
            div.className = 'todo-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border-l-4 border-indigo-500 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200';
            div.setAttribute('data-id', todo.id);
            div.innerHTML = `
                <div class="flex justify-between items-center gap-4">
                    <span class="todo-text text-gray-900 dark:text-gray-100 flex-1 break-words">${escapeHtml(todo.title)}</span>
                    <div class="flex space-x-2 flex-shrink-0">
                        <button 
                            class="edit-btn px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white text-sm rounded transition-colors duration-200"
                            onclick="editTodo(${todo.id}, '${escapeHtml(todo.title).replace(/'/g, "\\'")}')"
                        >
                            Edit
                        </button>
                        <button 
                            class="delete-btn px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-sm rounded transition-colors duration-200"
                            onclick="deleteTodo(${todo.id})"
                        >
                            Hapus
                        </button>
                    </div>
                </div>
            `;
            
            // Insert di awal list (newest first)
            todoList.insertBefore(div, todoList.firstChild);
        }

        // Fungsi untuk mengupdate todo di list setelah edit
        function updateTodoInList(todo) {
            const todoItem = document.querySelector(`[data-id="${todo.id}"]`);
            if (todoItem) {
                const todoText = todoItem.querySelector('.todo-text');
                if (todoText) {
                    todoText.textContent = todo.title;
                }
                
                // Update onclick handler untuk tombol edit dengan title yang baru
                const editBtn = todoItem.querySelector('.edit-btn');
                if (editBtn) {
                    editBtn.setAttribute('onclick', `editTodo(${todo.id}, '${escapeHtml(todo.title).replace(/'/g, "\\'")}')`)
                }
            }
        }

        function showError(message) {
            errorMessage.textContent = message;
            errorMessage.classList.remove('hidden');
            todoInput.classList.add('border-red-500');
        }

        function hideError() {
            errorMessage.classList.add('hidden');
            todoInput.classList.remove('border-red-500');
        }

        function showEditError(message) {
            editErrorMessage.textContent = message;
            editErrorMessage.classList.remove('hidden');
            editInput.classList.add('border-red-500');
        }

        function hideEditError() {
            editErrorMessage.classList.add('hidden');
            editInput.classList.remove('border-red-500');
        }

        function setLoadingState(loading) {
            addBtn.disabled = loading;
            addBtn.textContent = loading ? 'Menambah...' : 'Tambah';
            todoInput.disabled = loading;
            
            if (loading) {
                addBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                addBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        function setEditLoadingState(loading) {
            saveBtn.disabled = loading;
            saveBtn.textContent = loading ? 'Menyimpan...' : 'Simpan';
            editInput.disabled = loading;
            
            if (loading) {
                saveBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                saveBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        function updateCounter() {
            const count = todoList.querySelectorAll('.todo-item').length;
            taskCounter.textContent = count;
        }

        function showEmptyState() {
            todoList.innerHTML = `
                <div class="empty-state text-center py-16">
                    <div class="text-6xl mb-4 opacity-50">📋</div>
                    <div class="text-gray-500 dark:text-gray-400 text-lg">
                        Belum ada tugas yang ditambahkan.<br>
                        Mulai dengan menambahkan tugas pertama Anda!
                    </div>
                </div>
            `;
        }

        function showSuccess(message) {
            const successDiv = document.createElement('div');
            successDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300';
            successDiv.textContent = message;
            document.body.appendChild(successDiv);
            
            // Slide in animation
            setTimeout(() => {
                successDiv.style.transform = 'translateX(0)';
            }, 10);
            
            // Remove after 3 seconds
            setTimeout(() => {
                successDiv.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    successDiv.remove();
                }, 300);
            }, 3000);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</x-app-layout>