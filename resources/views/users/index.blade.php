@extends('layouts.app')

@section('title', 'Master User')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Master User</h1>
            <p class="text-sm text-slate-500">Kelola pengguna sistem (Dokter dan Perawat)</p>
        </div>
        <button onclick="toggleUserModal()" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow transition cursor-pointer">
            <svg class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah User
        </button>
    </div>



    <!-- Users Table -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
        <div class="p-5 border-b border-slate-200 bg-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="text-base font-bold text-slate-900">Daftar Pengguna Sistem</h2>
            <div class="relative max-w-xs w-full">
                <input type="text" id="userSearch" onkeyup="filterUserTable()" placeholder="Cari user..." class="block w-full pl-9 pr-3 py-1.5 border border-slate-300 rounded-lg text-sm bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Peran</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanda Tangan</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $user->username }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $user->role === 'superadmin' ? 'bg-red-100 text-red-800' : ($user->role === 'dokter' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }} uppercase">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($user->signature)
                                    <img src="{{ $user->signature }}" alt="TTD {{ $user->name }}" class="h-10 border border-slate-200 rounded p-0.5 bg-slate-50">
                                @else
                                    <span class="text-xs text-amber-600 font-semibold bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">Belum diupload</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold space-x-2">
                                <button onclick="editUser({{ json_encode($user) }})" class="text-blue-600 hover:text-blue-900 cursor-pointer">Edit</button>
                                @if($user->id !== auth()->id())
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('{{ $user->id }}', 'Apakah Anda yakin ingin menghapus user ini?')" class="text-red-600 hover:text-red-900 cursor-pointer">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Create / Edit User -->
<div id="userModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-slate-900/30 backdrop-blur-sm" onclick="toggleUserModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 relative z-10">
            <form id="userForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                
                <div class="bg-white px-6 pt-6 pb-4">
                    <h3 class="text-lg font-bold text-slate-900" id="modalTitle">Tambah User Baru</h3>
                    
                    <div class="mt-4 space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                            <input type="text" name="name" id="name" required class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                        </div>
                        
                        <div>
                            <label for="username" class="block text-sm font-semibold text-slate-700">Username</label>
                            <input type="text" name="username" id="username" required class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                            <input type="email" name="email" id="email" required class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi (Isi untuk mengganti)</label>
                            <div class="mt-1 relative">
                                <input type="password" name="password" id="password" class="appearance-none block w-full pl-3 pr-10 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                    <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-semibold text-slate-700">Peran</label>
                            <select name="role" id="role" onchange="toggleSignatureField(this.value)" required class="mt-1 appearance-none block w-full px-3 py-2 border border-slate-300 rounded-lg bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm">
                                <option value="perawat">Perawat</option>
                                <option value="dokter">Dokter</option>
                                <option value="superadmin">Superadmin (IT)</option>
                            </select>
                        </div>

                        <div id="signatureField" class="hidden">
                            <label for="signature_file" class="block text-sm font-semibold text-slate-700">Tanda Tangan (.png / .jpg / .jpeg, maks 1MB)</label>
                            <input type="file" name="signature_file" id="signature_file" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
                
                <div class="bg-slate-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-slate-200">
                    <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto cursor-pointer">Simpan</button>
                    <button type="button" onclick="toggleUserModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto cursor-pointer">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleSignatureField(role) {
        const field = document.getElementById('signatureField');
        if (role === 'dokter') {
            field.classList.remove('hidden');
        } else {
            field.classList.add('hidden');
        }
    }

    function toggleUserModal() {
        const modal = document.getElementById('userModal');
        modal.classList.toggle('hidden');
        if (modal.classList.contains('hidden')) {
            // Reset form
            document.getElementById('userForm').reset();
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('userForm').action = "{{ route('users.store') }}";
            document.getElementById('modalTitle').textContent = 'Tambah User Baru';
            document.getElementById('password').required = true;
            document.getElementById('signatureField').classList.add('hidden');
        }
    }

    function editUser(user) {
        toggleUserModal();
        document.getElementById('modalTitle').textContent = 'Edit User';
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('userForm').action = "/users/" + user.id;
        
        document.getElementById('name').value = user.name;
        document.getElementById('username').value = user.username;
        document.getElementById('email').value = user.email;
        document.getElementById('role').value = user.role;
        document.getElementById('password').required = false;
        
        toggleSignatureField(user.role);
    }

    function filterUserTable() {
        const input = document.getElementById("userSearch");
        const filter = input.value.toLowerCase();
        const tbody = document.querySelector("table tbody");
        const rows = tbody.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName("td");
            if (cells.length < 4) continue;
            
            const nama = cells[0].textContent.toLowerCase();
            const username = cells[1].textContent.toLowerCase();
            const email = cells[2].textContent.toLowerCase();
            const role = cells[3].textContent.toLowerCase();

            if (nama.includes(filter) || username.includes(filter) || email.includes(filter) || role.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    }
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />`;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        }
    }
    function confirmDelete(id, message) {
        showConfirm('Konfirmasi Hapus', message, () => {
            document.getElementById('delete-form-' + id).submit();
        });
    }
</script>
@endsection
