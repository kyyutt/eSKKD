<div id="modalVerifikasiPendaftaran" class="fixed inset-0 z-[100] hidden items-center justify-center bg-emerald-950/60 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl overflow-hidden p-8 text-center border border-slate-200">
        <div class="mx-auto flex items-center justify-center w-16 h-16 bg-amber-50 text-amber-500 rounded-full mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <h3 class="text-xl font-black text-slate-800 tracking-tight">Verifikasi Data?</h3>
        <p class="mt-2 text-sm text-slate-500 font-medium px-4">Pastikan data fisik pasien sudah benar sebelum diverifikasi untuk cetak.</p>

        <div class="mt-8 space-y-3">
            <button onclick="confirmVerifikasi()"
                class="w-full py-4 bg-amber-500 hover:bg-amber-600 text-white font-black rounded-2xl shadow-xl shadow-amber-500/20 transition-all uppercase tracking-widest text-[10px]">
                Ya, Verifikasi Sekarang
            </button>

            <button onclick="toggleModal('modalVerifikasiPendaftaran')"
                class="w-full py-4 bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold rounded-2xl transition-all uppercase tracking-widest text-[10px]">
                Kembali
            </button>
        </div>
    </div>
</div>