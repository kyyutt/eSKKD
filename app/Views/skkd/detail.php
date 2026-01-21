<div id="modalDetailSKKD" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 transition-all duration-300">

    <div class="bg-white w-full max-w-xl rounded-xl shadow-2xl overflow-hidden border border-slate-100 transform transition-all max-h-[90vh] flex flex-col">

        <div class="bg-white px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-800">Detail SKKD</h3>
                    <p class="text-xs text-emerald-600 font-medium">Informasi surat yang diterbitkan.</p>
                </div>
            </div>

            <button onclick="toggleModal('modalDetailSKKD')" type="button" class="text-slate-400 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
            <div class="grid grid-cols-2 gap-y-5 gap-x-6">

                <div class="col-span-2">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Data Dokumen</p>
                    <div class="bg-emerald-50 p-4 rounded-lg border border-emerald-100">
                        <p class="text-xs font-medium text-emerald-600 mb-0.5">Nomor Surat</p>
                        <p id="detNomorSurat" class="text-base font-mono font-black text-emerald-800 tracking-wider uppercase">-</p>
                    </div>
                </div>

                <div class="col-span-2">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Identitas Pasien</p>
                    <div class="flex justify-between items-start bg-slate-50 p-3 rounded-lg border border-slate-100">
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-0.5">Nama Pasien</p>
                            <p id="detNamaPasien" class="text-base font-bold text-slate-800 capitalize">-</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-slate-500 mb-0.5">NIK</p>
                            <p id="detNik" class="text-sm font-mono font-medium text-slate-700 bg-white border border-slate-200 inline-block px-2 py-0.5 rounded tracking-wide">-</p>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Dokter Pemeriksa</p>
                    <p id="detDokter" class="text-sm font-bold text-slate-800">-</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Tanggal Terbit</p>
                    <p id="detTglTerbit" class="text-sm font-medium text-slate-900">-</p>
                </div>

                <div class="col-span-2">
                    <p class="text-sm font-medium text-slate-500 mb-1">Status Dokumen</p>
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <p id="detStatus" class="text-sm font-bold text-slate-800 uppercase tracking-tight">Diterbitkan (Selesai)</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end space-x-3">
            <button onclick="toggleModal('modalDetailSKKD')" type="button"
                class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-medium rounded-lg text-sm hover:bg-slate-100 hover:text-slate-800 transition-all shadow-sm">
                Tutup
            </button>
            <button onclick="window.print()" type="button"
                class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-lg text-sm hover:bg-emerald-700 transition-all shadow-md shadow-emerald-200 flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak SKKD</span>
            </button>
        </div>
    </div>
</div>