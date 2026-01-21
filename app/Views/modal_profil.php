<div id="modalEditProfil" class="fixed inset-0 z-[100] hidden items-center justify-center bg-emerald-950/60 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-200">
        
        <div class="bg-emerald-50 p-8 border-b border-emerald-100 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-emerald-600 shadow-sm border border-emerald-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-black text-slate-800 tracking-tight">Pengaturan Profil</h3>
                    <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest mt-1">Sesi: <?= session()->get('role') ?></p>
                </div>
            </div>
            <button onclick="toggleModal('modalEditProfil')" class="p-3 bg-white text-slate-400 rounded-2xl hover:bg-red-50 hover:text-red-500 transition-all shadow-sm border border-slate-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form id="formEditProfil">
            <?= csrf_field() ?>
            <div class="p-10 max-h-[70vh] overflow-y-auto custom-scrollbar">
                <div class="space-y-4">
                    <h4 class="text-[10px] font-black text-emerald-600 uppercase tracking-widest border-b border-emerald-100 pb-2">Informasi Dasar</h4>
                    <div class="space-y-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase ml-1">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="prof_nama" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all text-sm font-bold text-slate-700" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase ml-1">Username</label>
                                <input type="text" name="username" id="prof_username" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all text-sm font-mono text-slate-700" required>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase ml-1">Role Akses</label>
                                <input type="text" id="prof_role" disabled class="w-full px-5 py-3.5 bg-slate-100 border border-slate-200 rounded-2xl text-sm font-bold text-slate-400 cursor-not-allowed italic">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 pt-4">
                    <h4 class="text-[10px] font-black text-rose-500 uppercase tracking-widest border-b border-rose-100 pb-2">Ganti Kata Sandi</h4>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase ml-1">Password Lama</label>
                            <input type="password" name="password_lama" id="prof_pass_lama" placeholder="••••••••" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-rose-400 outline-none transition-all text-sm">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase ml-1">Password Baru</label>
                            <input type="password" name="password_baru" id="prof_pass_baru" placeholder="Minimal 6 karakter" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-rose-400 outline-none transition-all text-sm">
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-8 bg-slate-50 border-t border-slate-100 flex items-center justify-end space-x-3">
                <button type="button" onclick="toggleModal('modalEditProfil')" class="px-6 py-4 text-slate-400 font-bold hover:text-emerald-950 transition-all uppercase tracking-widest text-[10px]">Batal</button>
                <button type="submit" class="px-10 py-4 bg-emerald-950 text-white font-black rounded-2xl shadow-xl shadow-emerald-950/20 active:scale-95 transition-all uppercase tracking-widest text-[10px]">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
