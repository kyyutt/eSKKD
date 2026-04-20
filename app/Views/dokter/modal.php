<!-- Modal Tambah -->
<div id="modalDokter" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 transition-all duration-300">

    <div class="bg-white w-full max-w-xl rounded-xl shadow-2xl overflow-hidden border border-slate-100 transform transition-all">

        <div class="bg-white px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-slate-800">Tambah Dokter Baru</h3>
                <p class="text-sm text-slate-500 mt-0.5">Lengkapi formulir di bawah ini dengan data yang valid.</p>
            </div>
            <button onclick="toggleModal('modalDokter')" type="button" class="text-slate-400 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
            <form id="formTambahDokter" class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="col-span-2 space-y-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Identitas (NIP/SIP)<span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="nomor_identitas"
                        placeholder="Contoh: NIP.1981... atau SIP 33/SIP..."
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-mono focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-400"
                        required>
                </div>
                <div class="col-span-2 space-y-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Dokter<span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="nama_dokter"
                        minlength="3"
                        pattern="[a-zA-Z\s\.\,\'\-]+"
                        title="Nama hanya boleh huruf dan tanda baca standar"
                        placeholder="Sesuai Nama Dokter"
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all placeholder:text-slate-400"
                        required>
                </div>

            </form>
        </div>

        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
            <button onclick="toggleModal('modalDokter')" type="button" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-200 transition-all">
                Batal
            </button>
            <button type="submit" form="formTambahDokter" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 shadow-sm transition-all active:scale-95">
                Simpan Data
            </button>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEditDokter" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 transition-all duration-300">

    <div class="bg-white w-full max-w-xl rounded-xl shadow-2xl overflow-hidden border border-slate-100">

        <div class="bg-white px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-slate-800">Edit Data Dokter</h3>
            <button onclick="toggleModal('modalEditDokter')" type="button" class="text-slate-400 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
            <form id="formEditDokter" class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Identitas<span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_identitas"
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap Dokter<span class="text-red-500">*</span></label>
                    <input type="text" name="nama_dokter"
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all" required>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
            <button onclick="toggleModal('modalEditDokter')" type="button" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-200 transition-all">
                Batal
            </button>
            <button type="submit" form="formEditDokter" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 shadow-sm transition-all">
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>
<!-- Modal Hapus -->
 <div id="modalHapusDokter" class="fixed inset-0 z-[100] hidden items-center justify-center bg-emerald-950/60 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl overflow-hidden p-8 text-center border border-slate-200">
        <h3 class="text-xl font-black text-slate-800 tracking-tight">Hapus Data?</h3>

        <div class="mt-8 space-y-3">
            <button onclick="confirmDelete()"
                class="w-full py-4 bg-red-600 hover:bg-red-700 text-white font-black rounded-2xl shadow-xl shadow-red-600/20 transition-all uppercase tracking-widest text-[10px]">
                Ya, Hapus Permanen
            </button>

            <button onclick="toggleModal('modalHapusDokter')"
                class="w-full py-4 bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold rounded-2xl transition-all uppercase tracking-widest text-[10px]">
                Batalkan
            </button>
        </div>
    </div>
</div>