<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Todo App - Catatan Digital</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .form-section {
            padding: 30px;
            border-bottom: 1px solid #e5e7eb;
        }

        .input-group {
            display: flex;
            gap: 12px;
            margin-bottom: 10px;
        }

        #todoInput {
            flex: 1;
            padding: 15px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            outline: none;
        }

        #todoInput:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        #addBtn {
            padding: 15px 25px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 100px;
        }

        #addBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
        }

        #addBtn:active {
            transform: translateY(0);
        }

        #addBtn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .error-message {
            color: #ef4444;
            font-size: 14px;
            margin-top: 8px;
            padding: 8px 12px;
            background: #fef2f2;
            border-radius: 8px;
            border-left: 4px solid #ef4444;
            display: none;
        }

        .todos-section {
            padding: 30px;
        }

        .section-title {
            font-size: 1.3rem;
            color: #374151;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .todo-list {
            list-style: none;
        }

        .todo-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 20px;
            margin-bottom: 12px;
            background: #f8fafc;
            border-radius: 12px;
            border-left: 4px solid #4f46e5;
            transition: all 0.3s ease;
            animation: slideIn 0.5s ease;
        }

        .todo-item:hover {
            background: #f1f5f9;
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .todo-text {
            flex: 1;
            font-size: 16px;
            color: #374151;
            word-break: break-word;
        }

        .todo-actions {
            display: flex;
            gap: 8px;
        }

        .delete-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            min-width: 70px;
        }

        .delete-btn:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: scale(1.05);
        }

        .delete-btn:active {
            transform: scale(0.95);
        }

        .edit-btn {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            min-width: 70px;
        }

        .edit-btn:hover {
            background: linear-gradient(135deg, #d97706, #b45309);
            transform: scale(1.05);
        }

        .edit-btn:active {
            transform: scale(0.95);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-text {
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .success-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #10b981;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            z-index: 1000;
            animation: slideInRight 0.3s ease;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            backdrop-filter: blur(4px);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 0;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            animation: modalSlideIn 0.3s ease;
        }

        .modal-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 25px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin: 0;
        }

        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .modal-input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            outline: none;
            font-family: inherit;
        }

        .modal-input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .modal-footer {
            padding: 20px 30px 30px;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 100px;
        }

        .btn-cancel {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-cancel:hover {
            background: #e5e7eb;
        }

        .btn-save {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
        }

        .btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .btn-save:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(-100px);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (max-width: 640px) {
            .container {
                margin: 10px;
                border-radius: 15px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 1.5rem;
            }
            
            .form-section, .todos-section {
                padding: 20px;
            }
            
            .input-group {
                flex-direction: column;
            }
            
            #addBtn {
                width: 100%;
            }
            
            .todo-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            
            .todo-actions {
                align-self: flex-end;
            }
            
            .modal-content {
                width: 95%;
                margin: 10px;
            }
            
            .modal-header, .modal-body, .modal-footer {
                padding: 20px;
            }
            
            .modal-footer {
                padding-top: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📝 Catatan Digital</h1>
            <p>Kelola tugas harian Anda dengan mudah</p>
        </div>

        <div class="form-section">
            <div class="input-group">
                <input 
                    type="text" 
                    id="todoInput" 
                    placeholder="Tulis tugas baru, contoh: Belajar prompt engineering..."
                    maxlength="255"
                >
                <button id="addBtn">Tambah</button>
            </div>
            <div id="errorMessage" class="error-message"></div>
        </div>

        <div class="todos-section">
            <h2 class="section-title">Daftar Tugas ({{ $todos->count() }})</h2>
            <ul id="todoList" class="todo-list">
                @forelse($todos as $todo)
                    <li class="todo-item" data-id="{{ $todo->id }}">
                        <span class="todo-text">{{ $todo->title }}</span>
                        <div class="todo-actions">
                            <button class="edit-btn" onclick="editTodo({{ $todo->id }}, '{{ addslashes($todo->title) }}')">Edit</button>
                            <button class="delete-btn" onclick="deleteTodo({{ $todo->id }})">Hapus</button>
                        </div>
                    </li>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon">📋</div>
                        <div class="empty-text">
                            Belum ada tugas yang ditambahkan.<br>
                            Mulai dengan menambahkan tugas pertama Anda!
                        </div>
                    </div>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">✏️ Edit Tugas</h3>
                <button class="close-btn" onclick="closeEditModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="editInput">Nama Tugas</label>
                    <input 
                        type="text" 
                        id="editInput" 
                        class="modal-input"
                        placeholder="Masukkan nama tugas..."
                        maxlength="255"
                    >
                    <div id="editErrorMessage" class="error-message"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-cancel" onclick="closeEditModal()">Batal</button>
                <button class="btn btn-save" id="saveBtn" onclick="saveEditTodo()">Simpan</button>
            </div>
        </div>
    </div>

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
            if (e.key === 'Escape' && editModal.classList.contains('show')) {
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
                    todoItem.style.animation = 'slideOut 0.3s ease';
                    
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
            editModal.classList.add('show');
            document.body.style.overflow = 'hidden'; // Prevent body scroll
            
            // Focus ke input setelah animasi
            setTimeout(() => {
                editInput.focus();
                editInput.select(); // Select all text
            }, 100);
            
            hideEditError();
        }

        // Fungsi untuk menutup modal edit
        function closeEditModal() {
            editModal.classList.remove('show');
            document.body.style.overflow = 'auto'; // Restore body scroll
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

        // PERBAIKAN: Fungsi untuk menambah todo ke list dengan tombol edit dan hapus
        function addTodoToList(todo) {
            const li = document.createElement('li');
            li.className = 'todo-item';
            li.setAttribute('data-id', todo.id);
            li.innerHTML = `
                <span class="todo-text">${escapeHtml(todo.title)}</span>
                <div class="todo-actions">
                    <button class="edit-btn" onclick="editTodo(${todo.id}, '${escapeHtml(todo.title).replace(/'/g, "\\'")}')">Edit</button>
                    <button class="delete-btn" onclick="deleteTodo(${todo.id})">Hapus</button>
                </div>
            `;
            
            // Insert di awal list (newest first)
            todoList.insertBefore(li, todoList.firstChild);
        }

        // PERBAIKAN: Fungsi untuk mengupdate todo di list setelah edit
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
            errorMessage.style.display = 'block';
            todoInput.style.borderColor = '#ef4444';
        }

        function hideError() {
            errorMessage.style.display = 'none';
            todoInput.style.borderColor = '#e5e7eb';
        }

        function showEditError(message) {
            editErrorMessage.textContent = message;
            editErrorMessage.style.display = 'block';
            editInput.style.borderColor = '#ef4444';
        }

        function hideEditError() {
            editErrorMessage.style.display = 'none';
            editInput.style.borderColor = '#e5e7eb';
        }

        function setLoadingState(loading) {
            addBtn.disabled = loading;
            addBtn.textContent = loading ? 'Menambah...' : 'Tambah';
            todoInput.disabled = loading;
        }

        function setEditLoadingState(loading) {
            saveBtn.disabled = loading;
            saveBtn.textContent = loading ? 'Menyimpan...' : 'Simpan';
            editInput.disabled = loading;
        }

        function updateCounter() {
            const count = todoList.querySelectorAll('.todo-item').length;
            const sectionTitle = document.querySelector('.section-title');
            sectionTitle.textContent = `Daftar Tugas (${count})`;
        }

        function showEmptyState() {
            todoList.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">📋</div>
                    <div class="empty-text">
                        Belum ada tugas yang ditambahkan.<br>
                        Mulai dengan menambahkan tugas pertama Anda!
                    </div>
                </div>
            `;
        }

        function showSuccess(message) {
            const successDiv = document.createElement('div');
            successDiv.className = 'success-message';
            successDiv.textContent = message;
            document.body.appendChild(successDiv);
            
            setTimeout(() => {
                successDiv.remove();
            }, 3000);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</body>
</html>