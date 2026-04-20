<div id="modalEditPasien" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 transition-all duration-300">
    
    <div class="bg-white w-full max-w-3xl rounded-xl shadow-2xl overflow-hidden border border-slate-100">
        
        <div class="bg-white px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-slate-800">Edit Data Pasien</h3>
            <button onclick="toggleModal('modalEditPasien')" type="button" class="text-slate-400 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
            <form id="formEditPasien" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span></label>
                    <input type="number" name="nik" readonly 
                        class="w-full px-3 py-2.5 bg-slate-100 border border-slate-300 rounded-lg text-sm text-slate-500 font-normal focus:outline-none cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap Pasien <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" 
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" 
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" 
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <div class="flex gap-3">
                        <label class="flex items-center space-x-2 cursor-pointer p-2.5 border border-slate-200 rounded-lg hover:bg-slate-50 w-full justify-center has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 transition-all">
                            <input type="radio" name="jenis_kelamin" value="L" class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                            <span class="text-sm font-normal text-slate-700">Laki-laki</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer p-2.5 border border-slate-200 rounded-lg hover:bg-slate-50 w-full justify-center has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 transition-all">
                            <input type="radio" name="jenis_kelamin" value="P" class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                            <span class="text-sm font-normal text-slate-700">Perempuan</span>
                        </label>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Pekerjaan <span class="text-red-500">*</span></label>
                    <input type="text" name="pekerjaan" 
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="alamat" rows="3" 
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all resize-none"></textarea>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
            <button onclick="toggleModal('modalEditPasien')" type="button" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-200 transition-all">
                Batal
            </button>
            <button type="submit" form="formEditPasien" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 shadow-sm transition-all">
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>