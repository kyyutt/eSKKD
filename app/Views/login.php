<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-SKKD Puskesmas Elly Uyo</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom Mint Cream Background */
        .bg-mint-cream {
            background-color: #F5FFFA;
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>

<body class="bg-mint-cream min-h-screen flex flex-col justify-center items-center p-4">

    <!-- Login Card Container -->
    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-2xl shadow-emerald-900/10 overflow-hidden border border-emerald-100">

            <!-- Header & Logo Section -->
            <div class="p-8 pb-4 text-center">
                <div class="mb-6 flex justify-center">
                    <!-- Placeholder Logo -->
                    <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center border-2 border-emerald-100 shadow-inner">
                        <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo Puskesmas Elly Uyo" class="w-20 h-20 object-contain">
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-emerald-900 tracking-tight">E-SKKD</h1>
                <p class="text-emerald-600 text-sm mt-1 font-medium uppercase tracking-wider">Puskesmas Elly Uyo</p>
                <div class="h-1 w-12 bg-emerald-500 mx-auto mt-4 rounded-full"></div>
            </div>
            <!-- Di bagian atas form di login.php -->
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="mx-8 mb-2">
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                </div>
            <?php endif; ?>


            <!-- Form Section -->
            <form class="p-8 pt-4 space-y-6" method="POST" action="<?= base_url('/login') ?>">
                <?= csrf_field() ?>
                <!-- Username Field -->
                <div class="space-y-2">
                    <label for="username" class="text-sm font-semibold text-emerald-800 ml-1">Nama Pengguna</label>
                    <div class="relative">
                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="Masukkan username Anda"
                            class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition-all text-gray-700"
                            required>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center ml-1">
                        <label for="password" class="text-sm font-semibold text-emerald-800">Kata Sandi</label>
                        <a href="#" class="text-xs text-emerald-600 hover:text-emerald-800 font-medium transition-colors">Lupa sandi?</a>
                    </div>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent focus:bg-white transition-all text-gray-700"
                            required>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center space-x-2 ml-1">
                    <input type="checkbox" id="remember" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer">
                    <label for="remember" class="text-sm text-emerald-700 cursor-pointer select-none">Ingat saya</label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full py-4 bg-emerald-700 hover:bg-emerald-950 text-white font-bold rounded-xl shadow-lg shadow-emerald-700/20 active:transform active:scale-[0.98] transition-all flex items-center justify-center space-x-2">
                    <span>Masuk ke Sistem</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" view_box="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>

            <!-- Bottom Note -->
            <div class="bg-gray-50 p-4 text-center border-t border-gray-100">
                <p class="text-xs text-gray-500">Butuh bantuan akses? <a href="#" class="text-emerald-700 font-semibold hover:underline">Hubungi Admin IT</a></p>
            </div>
        </div>

        <!-- Footer Text -->
        <footer class="mt-8 text-center space-y-1">
            <p class="text-emerald-800/60 text-xs font-medium uppercase tracking-widest">
                &copy; 2026 Puskesmas Elly Uyo
            </p>
            <p class="text-emerald-800/40 text-[10px] font-normal">
                Sistem Administrasi E-SKKD v1.0.4
            </p>
        </footer>
    </div>

</body>

</html>