<div id="modalPasien" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 transition-all duration-300">
    
    <div class="bg-white w-full max-w-3xl rounded-xl shadow-2xl overflow-hidden border border-slate-100 transform transition-all">

        <div class="bg-white px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-slate-800">Tambah Pasien Baru</h3>
                <p class="text-sm text-slate-500 mt-0.5">Lengkapi formulir di bawah ini dengan data yang valid.</p>
            </div>
            <button onclick="toggleModal('modalPasien')" type="button" class="text-slate-400 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
            <form id="formTambahPasien" class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">NIK <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        name="nik" 
                        inputmode="numeric"
                        minlength="16" 
                        maxlength="16" 
                        pattern="[0-9]{16}"
                        title="NIK harus 16 digit angka"
                        placeholder="Contoh: 9101xxxxxxxxxxxx" 
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-mono focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-400" 
                        required
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        name="nama_lengkap" 
                        minlength="3" 
                        pattern="[a-zA-Z\s\.\,\'\-]+"
                        title="Nama hanya boleh huruf dan tanda baca standar"
                        placeholder="Sesuai KTP" 
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-400 uppercase" 
                        required
                        oninput="this.value = this.value.toUpperCase()">
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tempat Lahir</label>
                    <input 
                        type="text" 
                        name="tempat_lahir" 
                        pattern="[a-zA-Z\s]+"
                        placeholder="Nama Kota/Kab" 
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-400 uppercase"
                        oninput="this.value = this.value.toUpperCase()">
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input 
                        id="tglLahirInput"
                        type="date" 
                        name="tanggal_lahir" 
                        required
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <div class="flex gap-3">
                        <label class="flex items-center space-x-2 cursor-pointer p-2.5 border border-slate-200 rounded-lg hover:bg-emerald-50 w-full justify-center has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50 transition-all">
                            <input type="radio" name="jenis_kelamin" value="L" required class="w-4 h-4 text-emerald-600 border-slate-300 focus:ring-emerald-500">
                            <span class="text-sm font-normal text-slate-700">Laki-laki</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer p-2.5 border border-slate-200 rounded-lg hover:bg-emerald-50 w-full justify-center has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50 transition-all">
                            <input type="radio" name="jenis_kelamin" value="P" required class="w-4 h-4 text-emerald-600 border-slate-300 focus:ring-emerald-500">
                            <span class="text-sm font-normal text-slate-700">Perempuan</span>
                        </label>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Pekerjaan</label>
                    <input 
                        type="text" 
                        name="pekerjaan" 
                        minlength="3" 
                        placeholder="PNS, Swasta, dll" 
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-400 uppercase"
                        oninput="this.value = this.value.toUpperCase()">
                </div>

                <div class="md:col-span-2 space-y-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea 
                        name="alamat" 
                        rows="3" 
                        minlength="10" 
                        required
                        placeholder="Jl. Nama Jalan, No Rumah, RT/RW..." 
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-400 resize-none uppercase"
                        oninput="this.value = this.value.toUpperCase()"></textarea>
                </div>

            </form>
        </div>

        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
            <button onclick="toggleModal('modalPasien')" type="button" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-200 transition-all">
                Batal
            </button>
            <button type="submit" form="formTambahPasien" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 shadow-sm transition-all active:scale-95">
                Simpan Data
            </button>
        </div>
    </div>
</div>