<div id="modalEditUser" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 transition-all duration-300">
    <div class="bg-white w-full max-w-xl rounded-xl shadow-2xl overflow-hidden border border-slate-100">

        <div class="bg-white px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-slate-800">Edit Akun Petugas</h3>
                <p class="text-sm text-slate-500 mt-0.5">Perbarui informasi akun atau hak akses petugas.</p>
            </div>
            <button onclick="toggleModal('modalEditUser')" type="button" class="text-slate-400 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-6">
            <form id="formEditUser" class="space-y-4">
                <input type="hidden" name="id_user">

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap"
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                        <input type="text" name="username" readonly
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-500 font-mono cursor-not-allowed outline-none">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Hak Akses <span class="text-red-500">*</span></label>
                        <select name="role" class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-700 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none cursor-pointer" required>
                            <option value="Admin">Admin</option>
                            <option value="Petugas Loket">Petugas Loket</option>
                        </select>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100">
                    <p class="text-[11px] font-bold text-blue-600 uppercase tracking-wider mb-3">Ubah Password (Kosongkan jika tidak ingin diubah)</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Password Baru <span class="text-red-500">*</span></label>
                            <input type="password" name="password" id="edit_password" placeholder="••••••••"
                                class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <input type="password" id="edit_password_confirm" placeholder="••••••••"
                                class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
            <button onclick="toggleModal('modalEditUser')" type="button" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-200 transition-all">
                Batal
            </button>
            <button type="submit" form="formEditUser" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 shadow-sm transition-all active:scale-95">
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>