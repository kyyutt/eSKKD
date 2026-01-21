<div id="modalCariPasien" class="fixed inset-0 z-[110] hidden items-center justify-center bg-emerald-900/60 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl overflow-hidden border border-emerald-100">
        <div class="bg-emerald-50 p-8 border-b border-emerald-100">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-xl font-black text-emerald-900 tracking-tight">Cari Data Pasien</h3>
                <button onclick="closeSearchModal()" class="text-emerald-400 hover:text-red-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest">Gunakan NIK atau Nama Lengkap</p>
        </div>

        <div class="p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-emerald-900 uppercase ml-1">Nama Pasien</label>
                    <input type="text" id="searchNama" placeholder="Masukkan nama..." class="w-full px-4 py-3 bg-emerald-50/30 border border-emerald-100 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all text-sm">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-emerald-900 uppercase ml-1">Nomor NIK</label>
                    <input type="text" id="searchNIK" placeholder="16 Digit NIK..." class="w-full px-4 py-3 bg-emerald-50/30 border border-emerald-100 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none transition-all text-sm font-mono">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <a href="<?= base_url('pasien') ?>" class="py-3 border-2 border-emerald-100 text-emerald-600 font-black rounded-xl hover:bg-emerald-50 transition-all uppercase tracking-widest text-[10px] text-center flex items-center justify-center">
                    Tambah Pasien Baru
                </a>
                <button type="button" onclick="doSearch()" class="py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-xl shadow-lg shadow-emerald-200 transition-all uppercase tracking-widest text-[10px] flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Cari Pasien</span>
                </button>
            </div>

            <div id="searchResultArea" class="hidden overflow-hidden border border-emerald-100 rounded-2xl">
                <div class="overflow-x-auto max-h-60 custom-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-emerald-50 text-[9px] font-black text-emerald-800 uppercase tracking-widest border-b border-emerald-100 sticky top-0">
                            <tr>
                                <th class="px-4 py-3">NIK</th>
                                <th class="px-4 py-3">Nama Lengkap</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50 text-xs bg-white">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalKonfirmasi" class="fixed inset-0 z-[120] hidden items-center justify-center bg-emerald-900/60 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden border border-emerald-100">
        <div class="bg-emerald-50 p-8 border-b border-emerald-100 flex justify-center text-center">
            <div>
                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-emerald-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-emerald-900 tracking-tight">Konfirmasi Data SKKD</h3>
                <p class="text-xs text-emerald-600 font-bold uppercase tracking-widest mt-1">Pastikan semua data sudah benar</p>
            </div>
        </div>

        <div class="p-8 space-y-4">
            <div class="bg-gray-50 p-6 rounded-3xl space-y-3">
                <div class="flex justify-between text-xs border-b border-gray-100 pb-2">
                    <span class="text-gray-400 font-bold uppercase">Pasien</span>
                    <span id="summaryPasien" class="text-emerald-900 font-black">-</span>
                </div>
                <div class="flex justify-between text-xs border-b border-gray-100 pb-2">
                    <span class="text-gray-400 font-bold uppercase">Dokter</span>
                    <span id="summaryDokter" class="text-emerald-900 font-black">-</span>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <span class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">Fisik (TB/BB)</span>
                        <span id="summaryFisik" class="text-emerald-900 font-black text-sm">-</span>
                    </div>
                    <div class="flex flex-col text-right">
                        <span class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">Goldar & Tensi</span>
                        <span id="summaryKesehatan" class="text-emerald-900 font-black text-sm">-</span>
                    </div>
                </div>
                <div class="pt-2">
                    <span class="text-[9px] text-gray-400 font-bold uppercase">Keperluan</span>
                    <p id="summaryKeperluan" class="text-xs text-gray-600 font-medium leading-relaxed italic mt-1 line-clamp-2">-</p>
                </div>
            </div>
        </div>

        <div class="p-8 pt-0 grid grid-cols-2 gap-4">
            <button onclick="closeConfirmation()" class="py-4 bg-gray-100 hover:bg-gray-200 text-gray-500 font-black rounded-2xl transition-all uppercase tracking-widest text-xs">Kembali</button>
            <button onclick="saveData()" class="py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-2xl shadow-lg shadow-emerald-200 transition-all uppercase tracking-widest text-xs">Simpan</button>
        </div>
    </div>
</div>