<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="bg-white p-8 rounded-[1rem] shadow-sm border border-slate-200 space-y-6">
    <div class="flex items-center space-x-3 mb-2">
        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-700 shadow-inner">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
        </div>
        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest text-nowrap">Filter Berdasarkan Periode</h3>
    </div>

    <form class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Mulai Dari Tanggal</label>
            <input type="date" id="startDate" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none text-sm font-bold text-slate-700">
        </div>

        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Hingga Tanggal</label>
            <input type="date" id="endDate" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 outline-none text-sm font-bold text-slate-700">
        </div>

        <div class="flex space-x-3 text-nowrap">
            <button type="button" id="btnFilter" class="flex-1 py-4 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-600/20 hover:bg-emerald-700 transition-all uppercase tracking-widest text-[10px]">
                Tampilkan Laporan
            </button>
            <button type="button" id="btnReset" class="p-4 bg-slate-100 text-slate-400 rounded-2xl hover:bg-slate-200 transition-all shadow-sm" title="Reset Filter">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </button>
        </div>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-lg transition-all text-nowrap">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total SKKD Terbit</p>
        <h3 class="text-2xl font-black text-slate-800 mt-2">
            <span id="summaryTotal">0</span>
            <span class="text-[10px] font-bold text-emerald-500 ml-1">Surat</span>
        </h3>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-lg transition-all text-nowrap">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pasien Laki-laki</p>
        <h3 class="text-2xl font-black text-slate-800 mt-2">
            <span id="summaryLaki">0</span>
            <span class="text-[10px] font-bold text-blue-500 ml-1">Jiwa</span>
        </h3>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-lg transition-all text-nowrap">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pasien Perempuan</p>
        <h3 class="text-2xl font-black text-slate-800 mt-2">
            <span id="summaryPerempuan">0</span>
            <span class="text-[10px] font-bold text-rose-500 ml-1">Jiwa</span>
        </h3>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm hover:shadow-lg transition-all text-nowrap">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Rata-rata / Hari</p>
        <h3 class="text-2xl font-black text-slate-800 mt-2">
            <span id="summaryRata">0</span>
            <span class="text-[10px] font-bold text-amber-500 ml-1 text-nowrap">Pasien</span>
        </h3>
    </div>
</div>

<div class="bg-white rounded-[1rem] shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <div>
            <h4 class="text-lg font-black text-slate-800 tracking-tight text-nowrap">Data Rekapitulasi Periode</h4>
            <p class="text-xs text-slate-400 font-medium italic">Rincian surat keterangan yang diterbitkan</p>
        </div>

        <button id="btnCetak" class="px-8 py-3 bg-emerald-950 text-white text-[10px] font-black rounded-2xl shadow-xl hover:bg-black transition-all uppercase tracking-[0.2em] flex items-center space-x-2 text-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span>Cetak Laporan</span>
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-emerald-950 text-white text-[10px] font-black uppercase tracking-[0.2em]">
                <tr>
                    <th class="px-8 py-5 text-center w-16">No</th>
                    <th class="px-8 py-5">Tanggal Terbit</th>
                    <th class="px-8 py-5">No. SKKD</th>
                    <th class="px-8 py-5">Nama Pasien</th>
                    <th class="px-8 py-5">NIK</th>
                    <th class="px-8 py-5">Dokter</th>
                    <th class="px-8 py-5 text-right">Status</th>
                </tr>
            </thead>
            <tbody id="tbodyLaporan" class="divide-y divide-slate-50 text-sm">
                <tr>
                    <td colspan="7" class="text-center py-10 text-slate-400 font-medium italic">
                        Memuat data laporan...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="px-10 py-6 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p id="paginationInfo" class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
            Total Data: <span class="text-emerald-950 font-black">0 Rekaman</span>
        </p>

        <div id="paginationNav" class="flex items-center space-x-2">
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/laporan.js') ?>"></script>

<?= $this->endSection() ?>