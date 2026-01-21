<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Data Master User</h2>
        <p class="text-xs text-slate-500 font-medium">Database user terpusat Puskesmas Elly Uyo</p>
    </div>
    <button onclick="toggleModal('modalUser')"
        class="inline-flex items-center justify-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-600/20 transition-all active:scale-95 space-x-2 text-xs uppercase tracking-wider">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        <span>Tambah User</span>
    </button>
</div>

<div class="bg-white p-4 mt-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col md:flex-row gap-4 items-center">

    <div class="relative flex-1 w-full text-nowrap">
        <input id="searchUser" type="text"
            placeholder="Cari Username atau Nama Lengkap..."
            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition-all placeholder:text-slate-400">
        <svg class="w-5 h-5 absolute left-4 top-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </div>

    <div class="flex items-center space-x-3 w-full md:w-auto">
        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">Tampilkan:</span>
        <div class="relative min-w-[100px]">
            <select id="limitUser"
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
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-center w-14 rounded-tl-2xl">No</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider">Nama Lengkap</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider">Username</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider">Role</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-right rounded-tr-2xl">Aksi</th>
                </tr>
            </thead>

            <tbody id="tbodyUser" class="divide-y divide-slate-100 bg-white"></tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="pagination-info text-xs font-medium text-slate-500"></p>
        <div class="pagination-nav flex items-center space-x-1"></div>
    </div>
</div>

<script src="<?= base_url('assets/js/user.js') ?>"></script>

<?= $this->endSection() ?>

<?= $this->section('modals') ?>
<?php echo view('user/tambah'); ?>
<?php echo view('user/edit'); ?>
<?php echo view('user/hapus'); ?>
<?= $this->endSection() ?>