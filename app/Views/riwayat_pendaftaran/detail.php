<div id="modalDetailPendaftaran" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 transition-all duration-300">

    <div class="bg-white w-full max-w-xl rounded-xl shadow-2xl overflow-hidden border border-slate-100 transform transition-all max-h-[90vh] flex flex-col">

            <div class="bg-white px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">Detail Pemeriksaan</h3>
                        <p class="text-xs text-blue-600 font-medium">Data fisik dan keperluan surat.</p>
                    </div>
                </div>

                <button onclick="toggleModal('modalDetailPendaftaran')" type="button" class="text-slate-400 hover:text-red-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
                <div class="grid grid-cols-2 gap-y-5 gap-x-6">

                    <div class="col-span-2">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Identitas Pasien</p>
                        <div class="flex justify-between items-start bg-slate-50 p-3 rounded-lg border border-slate-100">
                            <div>
                                <p class="text-sm font-medium text-slate-500 mb-0.5">Nama Pasien</p>
                                <p id="detail_nama_pasien" class="text-base font-bold text-slate-800 capitalize">-</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-slate-500 mb-0.5">NIK</p>
                                <p id="detail_nik" class="text-sm font-mono font-medium text-emerald-700 bg-emerald-100/50 inline-block px-2 py-0.5 rounded tracking-wide">-</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Dokter Pemeriksa</p>
                        <p id="detail_dokter" class="text-sm font-bold text-slate-800">-</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Tanggal Periksa</p>
                        <p id="detail_tgl" class="text-sm font-medium text-slate-900">-</p>
                    </div>

                    <div class="col-span-2 py-3 border-y border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Hasil Pemeriksaan Fisik</p>
                        <div class="grid grid-cols-4 gap-4 text-center">
                            <div class="bg-blue-50/50 p-2 rounded-lg border border-blue-50">
                                <span class="block text-[10px] text-slate-500 font-bold uppercase">Tinggi</span>
                                <span id="detail_tb" class="block text-sm font-bold text-blue-700 mt-1">-</span>
                            </div>
                            <div class="bg-blue-50/50 p-2 rounded-lg border border-blue-50">
                                <span class="block text-[10px] text-slate-500 font-bold uppercase">Berat</span>
                                <span id="detail_bb" class="block text-sm font-bold text-blue-700 mt-1">-</span>
                            </div>
                            <div class="bg-blue-50/50 p-2 rounded-lg border border-blue-50">
                                <span class="block text-[10px] text-slate-500 font-bold uppercase">Tensi</span>
                                <span id="detail_td" class="block text-sm font-bold text-blue-700 mt-1">-</span>
                            </div>
                            <div class="bg-blue-50/50 p-2 rounded-lg border border-blue-50">
                                <span class="block text-[10px] text-slate-500 font-bold uppercase">Goldar</span>
                                <span id="detail_gd" class="block text-sm font-bold text-blue-700 mt-1">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-2">
                        <p class="text-sm font-medium text-slate-500 mb-1">Keperluan Surat</p>
                        <p id="detail_keperluan" class="text-sm font-normal text-slate-700 leading-relaxed italic bg-slate-50 p-3 rounded-lg border border-slate-100">-</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm font-medium text-slate-500 mb-1">Status Pengajuan</p>
                        <p id="detail_status" class="text-sm font-bold text-slate-800">-</p>
                    </div>

                    <div class="pt-2 border-t border-slate-50">
                        <p class="text-sm font-medium text-slate-500 mb-1">Dibuat Oleh</p>
                        <p id="detail_created_by" class="text-xs font-normal text-slate-600 leading-relaxed">-</p>
                    </div>

                    <div class="pt-2 border-t border-slate-50">
                        <p class="text-sm font-medium text-slate-500 mb-1">Diubah Oleh</p>
                        <p id="detail_updated_by" class="text-xs font-normal text-slate-600 leading-relaxed">-</p>
                    </div>

                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button onclick="toggleModal('modalDetailPendaftaran')" type="button"
                    class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-medium rounded-lg text-sm hover:bg-slate-100 hover:text-slate-800 transition-all shadow-sm">
                    Tutup Detail
                </button>
            </div>
        </div>
    </div>