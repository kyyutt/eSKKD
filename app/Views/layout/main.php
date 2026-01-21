<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin TU | E-SKKD Puskesmas Elly Uyo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #064e3b;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-slate-50 h-screen flex overflow-hidden">
    <!-- Sidebar -->
    <?= view('layout/sidebar'); ?>
    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Top Navbar -->
        <?= view('layout/header'); ?>

        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto p-10 custom-scrollbar space-y-10">

            <!-- Dynamic Page Content -->
            <?= $this->renderSection('content'); ?>

            <!-- Footer Sign -->
            <?= view('layout/footer'); ?>
        </div>
        <?= $this->renderSection('modals') ?>
    </main>
    <script>
        const burgerBtn = document.getElementById('burgerBtn');
        const sidebar = document.getElementById('sidebar');

        burgerBtn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Klik di luar sidebar → auto close (mobile)
        document.addEventListener('click', function(e) {
            if (
                window.innerWidth < 768 &&
                !sidebar.contains(e.target) &&
                !burgerBtn.contains(e.target)
            ) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
</body>

</html>