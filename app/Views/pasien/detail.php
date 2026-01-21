<div id="modalDetailPasien" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 transition-all duration-300">

    <div class="bg-white w-full max-w-xl rounded-xl shadow-2xl overflow-hidden border border-slate-100 transform transition-all">

        <div class="bg-white px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-800">Informasi Pasien</h3>
                    <p class="text-xs text-emerald-600 font-medium">Detail data lengkap dari database.</p>
                </div>
            </div>

            <button onclick="toggleModal('modalDetailPasien')" type="button" class="text-slate-400 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-2 gap-y-5 gap-x-6">

                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Nomor NIK</p>
                    <p id="detail_nik" class="text-sm font-mono font-medium text-emerald-700 bg-emerald-50 inline-block px-2 py-1 rounded-md tracking-wide">-</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Jenis Kelamin</p>
                    <p id="detail_jk" class="text-sm font-medium text-slate-900">-</p>
                </div>

                <div class="col-span-2">
                    <p class="text-sm font-medium text-slate-500 mb-1">Nama Lengkap</p>
                    <p id="detail_nama" class="text-base font-bold text-slate-800 uppercase tracking-wide">-</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Tempat, Tanggal Lahir</p>
                    <p id="detail_ttl" class="text-sm font-medium text-slate-900">-</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Pekerjaan Utama</p>
                    <p id="detail_pekerjaan" class="text-sm font-medium text-slate-900">-</p>
                </div>

                <div class="col-span-2 pt-4 border-t border-slate-50">
                    <p class="text-sm font-medium text-slate-500 mb-1">Alamat Domisili</p>
                    <p id="detail_alamat" class="text-sm font-normal text-slate-700 leading-relaxed italic">-</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Dibuat Oleh</p>
                    <p id="detail_created_by" class="text-sm font-normal text-slate-700 leading-relaxed italic">-</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Diubah Oleh</p>
                    <p id="detail_updated_by" class="text-sm font-normal text-slate-700 leading-relaxed italic">-</p>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
            <button onclick="toggleModal('modalDetailPasien')" type="button"
                class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-medium rounded-lg text-sm hover:bg-slate-100 hover:text-slate-800 transition-all shadow-sm">
                Tutup Detail
            </button>
        </div>
    </div>
</div>