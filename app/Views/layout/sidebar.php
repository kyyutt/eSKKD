<?php
// KITA TETAP PAKAI NAMA VARIABEL $current_page
// Tapi isinya kita ambil dari Segment URL supaya akurat di CI4
// Kalau link: localhost:8080/pasien -> $current_page isinya 'pasien'
$uri = service('uri');
$current_page = $uri->getSegment(1);

// Fungsi Helper (Tetap sama, cuma logikanya dirapikan sedikit)
function setActive($targetPage, $current_page)
{
    // Cek Dashboard (URL kosong)
    if ($targetPage === '' && empty($current_page)) {
        return 'bg-emerald-900/50 border-l-4 border-emerald-400 rounded-r-xl text-white';
    }

    // Cek Halaman Lain
    if ($targetPage === $current_page) {
        return 'bg-emerald-900/50 border-l-4 border-emerald-400 rounded-r-xl text-white';
    }

    // Style Tidak Aktif
    return 'hover:bg-emerald-900/30 rounded-xl text-emerald-300 hover:text-white border-l-4 border-transparent';
}

function setFontBold($targetPage, $current_page)
{
    if ($targetPage === '' && empty($current_page)) return 'font-bold';
    return ($targetPage === $current_page) ? 'font-bold' : 'font-medium';
}
?>

<aside id="sidebar"
    class="fixed md:static inset-y-0 left-0 w-72
    bg-emerald-950 text-emerald-50
    flex flex-col shadow-2xl z-40
    transform -translate-x-full md:translate-x-0
    transition-transform duration-300 ease-in-out
    overflow-y-auto">

    <!-- Logo Section -->
    <div class="p-8 border-b border-emerald-900/50">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-extrabold tracking-tight leading-none">E-SKKD</h1>
                <p class="text-[10px] font-medium text-emerald-400 uppercase tracking-widest mt-1">
                    <?= session()->get('role') === 'Admin' ? 'Admin' : 'Petugas Loket' ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto custom-scrollbar py-6 px-4 space-y-8">

        <?php if (session()->get('role') === 'Admin'): ?>
            <!-- ================= ADMIN ================= -->

            <!-- Group 1: Data Master -->
            <div class="space-y-2">
                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-[0.2em] px-4 mb-4">Data Master</p>
                <a href="<?= base_url('/') ?>" class="flex items-center space-x-3 p-3 transition-all group <?php echo setActive('', $current_page); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a11 1 0 003 3h10a1 1 0 001-1V10M9 21h6"></path>
                    </svg>
                    <span class="text-sm <?php echo setFontBold('', $current_page); ?>">Dashboard Utama</span>
                </a>
                <a href="<?= base_url('user') ?>" class="flex items-center space-x-3 p-3 transition-all group <?php echo setActive('user', $current_page); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="text-sm <?php echo setFontBold('user', $current_page); ?>">Akun Petugas</span>
                </a>
                <a href="<?= base_url('dokter') ?>" class="flex items-center space-x-3 p-3 transition-all group <?php echo setActive('dokter', $current_page); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-sm <?php echo setFontBold('dokter', $current_page); ?>">Data Dokter</span>
                </a>
                <a href="<?= base_url('pasien') ?>" class="flex items-center space-x-3 p-3 transition-all group <?php echo setActive('pasien', $current_page); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-sm <?php echo setFontBold('pasien', $current_page); ?>">Data Pasien</span>
                </a>
            </div>

            <!-- Group 2: Transaksi -->
            <div class="space-y-2">
                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-[0.2em] px-4 mb-4">Layanan</p>
                <a href="<?= base_url('pendaftaran_skkd') ?>" class="flex items-center space-x-3 p-3 transition-all group <?php echo setActive('pendaftaran_skkd', $current_page); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="text-sm <?php echo setFontBold('pendaftaran_skkd', $current_page); ?>">Pendaftaran & Pemeriksaan</span>
                </a>
            </div>

            <!-- Group 3: Output -->
            <div class="space-y-2">
                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-[0.2em] px-4 mb-4">Penerbitan SKKD</p>
                <a href="<?= base_url('skkd') ?>" class="flex items-center space-x-3 p-3 transition-all group <?php echo setActive('skkd', $current_page); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    <span class="text-sm <?php echo setFontBold('skkd', $current_page); ?>">Cetak Dokumen SKKD</span>
                </a>
            </div>

            <!-- Group 4: Report -->
            <div class="space-y-2">
                <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-[0.2em] px-4 mb-4">Laporan</p>
                <a href="<?= base_url('laporan') ?>" class="flex items-center space-x-3 p-3 transition-all group <?php echo setActive('laporan', $current_page); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-sm <?php echo setFontBold('laporan', $current_page); ?>">Rekapitulasi Laporan</span>
                </a>
            </div>
    </div>

<?php else: ?>
    <!-- ================= PETUGAS LOKET ================= -->

    <div class="space-y-2">
        <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-[0.2em] px-4 mb-4">Data Master</p>

        <a href="<?= base_url('/') ?>" class="flex items-center space-x-3 p-3 transition-all group <?php echo setActive('', $current_page); ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a11 1 0 003 3h10a1 1 0 001-1V10M9 21h6"></path>
            </svg>
            <span class="text-sm <?php echo setFontBold('', $current_page); ?>">Dashboard Utama</span>
        </a>

        <a href="<?= base_url('pasien') ?>" class="flex items-center space-x-3 p-3 transition-all group <?php echo setActive('pasien', $current_page); ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="text-sm <?php echo setFontBold('pasien', $current_page); ?>">Data Pasien</span>
        </a>
    </div>

    <div class="space-y-2">
        <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-[0.2em] px-4 mb-4">Layanan</p>

        <a href="<?= base_url('pendaftaran_skkd') ?>" class="flex items-center space-x-3 p-3 transition-all group <?php echo setActive('pendaftaran_skkd', $current_page); ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            <span class="text-sm <?php echo setFontBold('pendaftaran_skkd', $current_page); ?>">Pendaftaran & Pemeriksaan</span>
        </a>
    </div>

    <div class="space-y-2">
        <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-[0.2em] px-4 mb-4">Riwayat Pendaftaran</p>
        <a href="<?= base_url('riwayat_skkd') ?>" class="flex items-center space-x-3 p-3 transition-all group <?php echo setActive('riwayat_skkd', $current_page); ?>">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span class="text-sm <?php echo setFontBold('riwayat_skkd', $current_page); ?>">Riwayat Pendaftaran SKKD</span>
        </a>
    </div>

<?php endif; ?>

</div>

<!-- Sidebar Footer -->
<div class="p-6 border-t border-emerald-900/50">
    <a href="/logout" class="flex items-center space-x-3 text-emerald-400 hover:text-red-400 transition-colors w-full group">
        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
        </svg>
        <span class="text-sm font-bold uppercase tracking-widest">Logout</span>
    </a>
</div>

</aside>