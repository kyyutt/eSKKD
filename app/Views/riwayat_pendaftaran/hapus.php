<div id="modalHapusPendaftaran" class="fixed inset-0 z-[100] hidden items-center justify-center bg-emerald-950/60 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl overflow-hidden p-8 text-center border border-slate-200">
        <h3 class="text-xl font-black text-slate-800 tracking-tight">Hapus Data?</h3>

        <div class="mt-8 space-y-3">
            <button onclick="confirmDelete()"
                class="w-full py-4 bg-red-600 hover:bg-red-700 text-white font-black rounded-2xl shadow-xl shadow-red-600/20 transition-all uppercase tracking-widest text-[10px]">
                Ya, Hapus Permanen
            </button>

            <button onclick="toggleModal('modalHapusPendaftaran')"
                class="w-full py-4 bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold rounded-2xl transition-all uppercase tracking-widest text-[10px]">
                Batalkan
            </button>
        </div>
    </div>
</div>