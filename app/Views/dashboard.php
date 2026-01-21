<?= $this->extend('layout/main'); ?>
<?= $this->section('content'); ?>
<?php
if (session()->get('role') === 'Admin') {
?>
   <div class="bg-emerald-950 rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl">
      <div class="relative z-10 space-y-1">
         <h2 class="text-2xl font-black italic tracking-tight">Halo, Selamat Bekerja!</h2>
         <p class="text-emerald-300 text-xs font-medium italic">Pantau pendaftaran pasien dan pastikan proses verifikasi berjalan dengan lancar.</p>
      </div>
      <div class="absolute -right-16 -bottom-16 w-48 h-48 bg-emerald-600 rounded-full opacity-20 blur-3xl"></div>
      <div class="absolute right-8 top-0 w-24 h-24 bg-emerald-400 rounded-full opacity-10 blur-2xl"></div>
   </div>

   <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:shadow-emerald-900/5 transition-all group">
         <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-all">
               <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
               </svg>
            </div>
            <span class="text-[10px] font-black text-emerald-600 bg-emerald-100 px-2 py-1 rounded-lg">Hari Ini</span>
         </div>
         <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Pasien Masuk</p>
         <h3 class="text-3xl font-black text-slate-800 mt-1"><?= $stats['totalPasienHariIni'] ?></h3>
      </div>

      <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl transition-all group">
         <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all">
               <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
               </svg>
            </div>
            <span class="text-[10px] font-black text-blue-600 bg-blue-100 px-2 py-1 rounded-lg">Total</span>
         </div>
         <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total SKKD Terbit</p>
         <h3 class="text-3xl font-black text-slate-800 mt-1"><?= $stats['totalSKKDTerbit'] ?></h3>
      </div>

      <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl transition-all group">
         <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-all">
               <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
               </svg>
            </div>
         </div>
         <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Dokter Terdaftar</p>
         <h3 class="text-3xl font-black text-slate-800 mt-1"><?= str_pad($stats['totalDokter'], 2, '0', STR_PAD_LEFT) ?></h3>
      </div>

      <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl transition-all group">
         <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600 group-hover:bg-rose-600 group-hover:text-white transition-all">
               <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
               </svg>
            </div>
            <span class="text-[10px] font-black text-rose-600 bg-rose-100 px-2 py-1 rounded-lg">Live</span>
         </div>
         <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Antrean Menunggu</p>
         <h3 class="text-3xl font-black text-slate-800 mt-1"><?= $stats['antreanLoket'] ?></h3>
      </div>
   </div>

   <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">

      <div class="xl:col-span-2 bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
         <div class="p-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
               <h4 class="text-lg font-black text-slate-800 tracking-tight">Riwayat SKKD Terbaru</h4>
               <p class="text-xs text-slate-400 font-medium">Monitoring penerbitan dokumen secara live</p>
            </div>
            <a href="#" class="px-5 py-2.5 bg-emerald-950 text-white text-[10px] font-bold rounded-xl shadow-lg hover:shadow-emerald-900/20 transition-all uppercase tracking-widest">Lihat Semua</a>
         </div>
         <div class="overflow-x-auto">
            <table class="w-full text-left">
               <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                  <tr>
                     <th class="px-8 py-4">No. SKKD</th>
                     <th class="px-8 py-4">Nama Pasien</th>
                     <th class="px-8 py-4">Dokter</th>
                     <th class="px-8 py-4">Status</th>
                  </tr>
               </thead>
               <tbody class="divide-y divide-slate-50">
                  <?php if (empty($recentSKKD)) : ?>
                     <tr>
                        <td colspan="5" class="px-8 py-5 text-center text-slate-400 text-xs italic">Belum ada data SKKD diterbitkan.</td>
                     </tr>
                  <?php else : ?>
                     <?php foreach ($recentSKKD as $row) : ?>
                        <tr class="hover:bg-emerald-50/30 transition-colors">
                           <td class="px-8 py-5 text-emerald-700 font-bold text-xs whitespace-nowrap"><?= $row['nomor_surat'] ?></td>
                           <td class="px-8 py-5">
                              <p class="text-sm font-bold text-slate-800"><?= $row['nama_pasien'] ?></p>
                              <p class="text-[10px] text-slate-400 font-mono">NIK: <?= $row['nik'] ?></p>
                           </td>
                           <td class="px-8 py-5 text-slate-600 text-xs font-medium italic"><?= $row['nama_dokter'] ?></td>
                           <td class="px-8 py-5">
                              <?php
                              $badgeColor = 'bg-slate-100 text-slate-700';
                              if ($row['status'] == 'Terverifikasi') {
                                 $badgeColor = 'bg-blue-100 text-blue-700';
                              } elseif ($row['status'] == 'Selesai') {
                                 $badgeColor = 'bg-green-100 text-green-700';
                              }
                              ?>
                              <span class="px-3 py-1 <?= $badgeColor ?> rounded-full text-[9px] font-black uppercase tracking-wider"><?= $row['status'] ?></span>
                           </td>
                        </tr>
                     <?php endforeach; ?>
                  <?php endif; ?>
               </tbody>
            </table>
         </div>
      </div>

      <!-- Simplified Shortcut Area (1/3) - UPDATED -->
      <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-200 p-8 space-y-6 text-nowrap">
         <div>
            <h4 class="text-lg font-black text-slate-800 tracking-tight">Pintasan Menu</h4>
            <p class="text-xs text-slate-400 font-medium italic text-wrap">Navigasi cepat ke menu utama</p>
         </div>

         <div class="grid grid-cols-1 gap-3">
            <!-- Manajemen Pasien -->
            <a href="<?= base_url('pasien') ?>" class="flex items-center justify-between p-4 bg-emerald-50 rounded-2xl border border-emerald-100 hover:bg-emerald-600 hover:text-white transition-all group">
               <div class="flex items-center space-x-3">
                  <svg class="w-5 h-5 text-emerald-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                  </svg>
                  <span class="text-[11px] font-black uppercase tracking-wider">Database Pasien</span>
               </div>
               <svg class="w-4 h-4 opacity-30 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
               </svg>
            </a>
            <!-- Rekap Laporan -->
            <a href="<?= base_url('laporan') ?>" class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-200 hover:bg-emerald-950 hover:text-white transition-all group">
               <div class="flex items-center space-x-3">
                  <svg class="w-5 h-5 text-slate-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                  </svg>
                  <span class="text-[11px] font-black uppercase tracking-wider">Rekap Laporan</span>
               </div>
               <svg class="w-4 h-4 opacity-30 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
               </svg>
            </a>
         </div>

         <div class="p-6 bg-emerald-50 rounded-2xl border border-emerald-100 text-wrap">
            <div class="flex items-center space-x-2 text-emerald-800 mb-2">
               <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
               </svg>
               <span class="text-[10px] font-black uppercase tracking-widest text-nowrap">Informasi Sistem</span>
            </div>
            <p class="text-[10px] text-emerald-700 leading-relaxed italic font-medium uppercase tracking-tight">Gunakan pintasan di atas untuk mempercepat akses administrasi data pasien dan pelaporan berkala.</p>
         </div>
      </div>

   </div>
<?php
} else {
?>
   <div class="bg-emerald-950 rounded-[2.5rem] p-10 text-white relative overflow-hidden shadow-2xl">
      <div class="relative z-10 space-y-2">
         <h2 class="text-3xl font-black italic tracking-tight">Halo, Selamat Bekerja!</h2>
         <p class="text-emerald-300 text-sm font-medium italic">Pantau pendaftaran pasien dan pastikan proses verifikasi berjalan dengan lancar.</p>
      </div>
      <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-emerald-600 rounded-full opacity-20 blur-3xl"></div>
      <div class="absolute right-10 top-0 w-32 h-32 bg-emerald-400 rounded-full opacity-10 blur-2xl"></div>
   </div>

   <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-white p-8 rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl transition-all group">
         <div class="flex justify-between items-start mb-4">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-all">
               <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
               </svg>
            </div>
            <span class="text-[10px] font-black text-emerald-600 bg-emerald-100 px-3 py-1 rounded-full uppercase">Hari Ini</span>
         </div>
         <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pasien Baru</p>
         <h3 class="text-4xl font-black text-slate-800 mt-1"><?= $stats['totalPasienHariIni'] ?></h3>
      </div>

      <div class="bg-white p-8 rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl transition-all group">
         <div class="flex justify-between items-start mb-4">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all">
               <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
               </svg>
            </div>
            <span class="text-[10px] font-black text-blue-600 bg-blue-100 px-3 py-1 rounded-full uppercase">Proses</span>
         </div>
         <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Sedang Verifikasi</p>
         <h3 class="text-4xl font-black text-slate-800 mt-1"><?= $stats['sedangVerifikasi'] ?></h3>
      </div>

      <div class="bg-white p-8 rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl transition-all group">
         <div class="flex justify-between items-start mb-4">
            <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-all">
               <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
               </svg>
            </div>
            <span class="text-[10px] font-black text-green-600 bg-green-100 px-3 py-1 rounded-full uppercase">Selesai</span>
         </div>
         <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pasien Selesai</p>
         <h3 class="text-4xl font-black text-slate-800 mt-1"><?= $stats['selesaiHariIni'] ?></h3>
      </div>
   </div>

   <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">

      <div class="xl:col-span-2 bg-white rounded-[2.5rem] shadow-sm border border-slate-200 overflow-hidden">
         <div class="p-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/50 text-nowrap">
            <div>
               <h4 class="text-lg font-black text-slate-800 tracking-tight">Antrean Pasien Hari Ini</h4>
               <p class="text-xs text-slate-400 font-medium italic">Data pendaftaran real-time</p>
            </div>
            <div class="flex space-x-2">
               <button onclick="window.location.reload()" class="px-4 py-2 bg-emerald-100 text-emerald-700 text-[10px] font-black rounded-xl hover:bg-emerald-200 transition-all uppercase">Refresh</button>
            </div>
         </div>
         <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
               <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                  <tr>
                     <th class="px-8 py-5">Waktu</th>
                     <th class="px-8 py-5">Nama Pasien</th>
                     <th class="px-8 py-5">NIK</th>
                     <th class="px-8 py-5">Status</th>
                  </tr>
               </thead>
               <tbody class="divide-y divide-slate-50">
                  <?php if (empty($recentAntrean)) : ?>
                     <tr>
                        <td colspan="4" class="px-8 py-6 text-center text-slate-400 text-xs italic">Belum ada antrean hari ini.</td>
                     </tr>
                  <?php else : ?>
                     <?php foreach ($recentAntrean as $row) : ?>
                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                           <td class="px-8 py-6 text-xs font-bold text-slate-400 uppercase tracking-tighter">
                              <?= date('H:i', strtotime($row['created_at'])) ?> WIT
                           </td>
                           <td class="px-8 py-6">
                              <p class="text-sm font-black text-slate-800 uppercase tracking-tight"><?= $row['nama_lengkap'] ?></p>
                           </td>
                           <td class="px-8 py-6 font-mono text-emerald-600 text-xs font-bold tracking-widest"><?= $row['nik'] ?></td>
                           <td class="px-8 py-6">
                              <?php
                              $badgeColor = 'bg-slate-100 text-slate-700'; // Default

                              if ($row['status'] == 'Menunggu') {
                                 $badgeColor = 'bg-amber-100 text-amber-700';
                              } elseif ($row['status'] == 'Terverifikasi') {
                                 $badgeColor = 'bg-blue-100 text-blue-700';
                              } elseif ($row['status'] == 'Selesai') {
                                 $badgeColor = 'bg-green-100 text-green-700';
                              }
                              ?>
                              <span class="px-3 py-1 <?= $badgeColor ?> rounded-full text-[9px] font-black uppercase tracking-wider"><?= $row['status'] ?></span>
                           </td>
                        </tr>
                     <?php endforeach; ?>
                  <?php endif; ?>
               </tbody>
            </table>
         </div>
      </div>

      <div class="space-y-8">
         <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-200 space-y-6">
            <h4 class="text-lg font-black text-slate-800 tracking-tight">Aksi Cepat</h4>
            <div class="grid grid-cols-1 gap-4 text-nowrap">
               <!-- Action 1: Register (Sized Down) -->
               <a href="<?= base_url('pendaftaran_skkd') ?>" class="flex items-center justify-between p-3.5 bg-emerald-50 rounded-2xl border border-emerald-100 hover:bg-emerald-600 hover:text-white transition-all group shadow-sm">
                  <div class="flex items-center space-x-3">
                     <div class="w-8 h-8 bg-white rounded-xl flex items-center justify-center text-emerald-600 group-hover:text-emerald-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                     </div>
                     <span class="text-[11px] font-black uppercase tracking-wider">Daftar Pasien</span>
                  </div>
                  <svg class="w-3.5 h-3.5 opacity-0 group-hover:opacity-100 transition-all transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
               </a>
               <!-- Action 2: Check Status (Sized Down) -->
               <a href="<?= base_url('riwayat_skkd') ?>" class="flex items-center justify-between p-3.5 bg-slate-50 rounded-2xl border border-slate-200 hover:bg-emerald-950 hover:text-white transition-all group shadow-sm">
                  <div class="flex items-center space-x-3">
                     <div class="w-8 h-8 bg-white rounded-xl flex items-center justify-center text-emerald-900 group-hover:text-emerald-950">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                     </div>
                     <span class="text-[11px] font-black uppercase tracking-wider">Cek Status SKKD</span>
                  </div>
                  <svg class="w-3.5 h-3.5 opacity-0 group-hover:opacity-100 transition-all transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
               </a>
            </div>
         </div>

         <div class="p-8 bg-emerald-50 rounded-[2.5rem] border border-emerald-100">
            <div class="flex items-center space-x-3 text-emerald-800 mb-2">
               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
               </svg>
               <span class="text-xs font-black uppercase tracking-widest">Panduan Sistem</span>
            </div>
            <p class="text-[10px] text-emerald-600 leading-relaxed italic">Gunakan fitur 'Daftar Pasien' untuk registrasi baru atau 'Input Pemeriksaan' untuk melanjutkan proses antrean ke ruang periksa.</p>
         </div>
      </div>

   </div>
<?php
}
?>

<?= $this->endSection(); ?>