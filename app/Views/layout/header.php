<?php
$role = session()->get('role');

// Asumsi enum: 'Admin' | 'Petugas Loket'
$roleLabel = match ($role) {
    'Admin'         => 'Admin',
    'Petugas Loket' => 'Petugas Loket',
};

$avatarSeed = $role;
?>
<header class="bg-white border-b border-slate-200 h-20 flex items-center justify-between px-6 md:px-10 flex-shrink-0">

    <!-- Burger Button (Mobile) -->
    <button id="burgerBtn"
        class="md:hidden bg-emerald-600 text-white p-3 rounded-xl shadow-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div>
        <h2 class="text-lg font-bold text-slate-800"><?= esc($title) ?></h2>
        <p class="text-xs text-slate-400 font-medium italic">
            <?= esc($subtitle) ?>
        </p>
    </div>

    <div class="flex items-center space-x-6 cursor-pointer hover:opacity-80 transition-all" onclick="openMyProfile()">
        <div class="text-right">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-tighter">
                <?= esc($roleLabel) ?>
            </p>
            <p class="text-[10px] text-emerald-600 font-black">
                Online
            </p>
        </div>

        <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center border-2 border-emerald-200 overflow-hidden shadow-inner">
            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?= esc($avatarSeed) ?>" alt="Avatar">
        </div>
    </div>

</header>
<script>
    // Pastikan fungsi ini ada dan bisa diakses global
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.toggle('hidden');
            modal.classList.toggle('flex');
        }
    }
</script>
<script src="<?= base_url('assets/js/profil.js') ?>"></script>
<?= $this->include('modal_profil'); ?>