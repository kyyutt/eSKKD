<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Data Penerbitan SKKD</h2>
        <p class="text-xs text-slate-500 font-medium">Monitoring surat keterangan keterangan dokter</p>
    </div>
</div>

<div class="bg-white p-4 mt-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col md:flex-row gap-4 items-center">

    <div class="relative flex-1 w-full text-nowrap">
        <input id="searchSKKD" type="text"
            placeholder="Cari Nomor Surat, NIK, atau Nama Pasien..."
            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition-all placeholder:text-slate-400">
        <svg class="w-5 h-5 absolute left-4 top-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </div>

    <div class="flex items-center space-x-3 w-full md:w-auto">
        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">Tampilkan:</span>
        <div class="relative min-w-[100px]">
            <select id="limitSKKD"
                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 outline-none focus:ring-2 focus:ring-emerald-500 appearance-none cursor-pointer">
                <option value="10">10 Baris</option>
                <option value="20">20 Baris</option>
                <option value="30">30 Baris</option>
                <option value="50">50 Baris</option>
                <option value="100">100 Baris</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="bg-white mt-6 rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-emerald-900 text-white/90">
                <tr>
                    <th class="px-8 py-4 text-xs font-semibold uppercase tracking-wider rounded-tl-2xl">No. Surat</th>
                    <th class="px-8 py-4 text-xs font-semibold uppercase tracking-wider">Identitas Pasien</th>
                    <th class="px-8 py-4 text-xs font-semibold uppercase tracking-wider">Dokter Pemeriksa</th>
                    <th class="px-8 py-4 text-xs font-semibold uppercase tracking-wider">Tgl Terbit</th>
                    <th class="px-8 py-4 text-xs font-semibold uppercase tracking-wider text-center">Status</th>
                    <th class="px-8 py-4 text-xs font-semibold uppercase tracking-wider text-right rounded-tr-2xl">Aksi</th>
                </tr>
            </thead>

            <tbody id="tbodySKKD" class="divide-y divide-slate-100 bg-white">
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="pagination-info text-xs font-medium text-slate-500"></p>
        <div class="pagination-nav flex items-center space-x-1"></div>
    </div>
</div>

<script src="<?= base_url('assets/js/skkd.js') ?>"></script>

<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<?php echo view('skkd/detail'); ?>
<?php echo view('skkd/hapus'); ?>
<?= $this->endSection() ?>