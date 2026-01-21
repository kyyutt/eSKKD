<div id="modalUser" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 transition-all duration-300">
    <div class="bg-white w-full max-w-xl rounded-xl shadow-2xl overflow-hidden border border-slate-100 transform transition-all">

        <div class="bg-white px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-slate-800">Tambah Akun Petugas</h3>
                <p class="text-sm text-slate-500 mt-0.5">Buat akses baru untuk petugas rumah sakit.</p>
            </div>
            <button onclick="toggleModal('modalUser')" type="button" class="text-slate-400 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-6">
            <form id="formTambahUser" class="space-y-4">
                
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap Petugas <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </span>
                        <input 
                            type="text" 
                            name="nama_lengkap" 
                            placeholder="Contoh: Budi Santoso" 
                            class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-400" 
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            name="username" 
                            placeholder="username_petugas" 
                            class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-mono focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all" 
                            required>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Hak Akses <span class="text-red-500">*</span></label>
                        <select 
                            name="role" 
                            class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-700 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all cursor-pointer" 
                            required>
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="Admin">Admin</option>
                            <option value="Petugas Loket">Petugas Loket</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            <input 
                                type="password" 
                                name="password" 
                                id="passwordInput"
                                minlength="6"
                                placeholder="Min. 6 karakter" 
                                class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-400" 
                                required>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </span>
                            <input 
                                type="password" 
                                id="passwordConfirmInput"
                                placeholder="Ulangi password" 
                                class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-400" 
                                required>
                        </div>
                    </div>
                </div>
                <p class="text-[10px] text-slate-400 mt-1 italic leading-relaxed">*Password harus identik di kedua kolom untuk menghindari kesalahan pengetikan.</p>

            </form>
        </div>

        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
            <button onclick="toggleModal('modalUser')" type="button" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-200 transition-all">
                Batal
            </button>
            <button type="submit" form="formTambahUser" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 shadow-sm transition-all active:scale-95 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Simpan Akun
            </button>
        </div>
    </div>
</div>