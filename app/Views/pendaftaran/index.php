<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>


<div class="bg-white rounded-xl shadow-sm border border-emerald-100 overflow-hidden">
    <div class="h-2 bg-emerald-900"></div>

    <form id="pemeriksaanForm" class="p-8 lg:p-12 space-y-10">

        <div class="space-y-6">
            <h3 class="flex items-center text-sm font-black text-emerald-900 uppercase tracking-widest">
                <span class="w-2 h-2 bg-emerald-600 rounded-full mr-3"></span>
                Pilih Entitas Terkait
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-emerald-900 ml-1">Pilih Data Pasien</label>
                    <div class="flex space-x-2">
                        <div class="relative flex-1">
                            <input type="text" id="displayPasien" placeholder="Belum ada pasien terpilih" readonly class="w-full px-4 py-3 bg-gray-50 border border-emerald-100 rounded-xl text-sm font-medium text-emerald-900 outline-none cursor-default">
                            <input type="hidden" id="selectedPasienId" name="id_pasien">
                        </div>
                        <button type="button" onclick="openSearchModal()" class="px-4 py-3 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-all shadow-md flex items-center justify-center group" title="Cari Pasien">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-emerald-900 ml-1">Dokter Pemeriksa</label>
                    <select id="inputDokter" name="id_dokter" class="w-full px-4 py-3 bg-emerald-50/50 border border-emerald-100 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition-all text-sm appearance-none cursor-pointer">
                        <option value="">-- Pilih Dokter --</option>
                        <?php if (!empty($dokters)) : ?>
                            <?php foreach ($dokters as $dokter) : ?>
                                <option value="<?= $dokter['id_dokter'] ?>">
                                    <?= $dokter['nama_dokter'] ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <option value="" disabled>Data dokter kosong</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <h3 class="flex items-center text-sm font-black text-emerald-900 uppercase tracking-widest">
                <span class="w-2 h-2 bg-emerald-600 rounded-full mr-3"></span>
                Hasil Pemeriksaan Fisik
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-emerald-900 ml-1">Tanggal Pemeriksaan</label>
                    <input type="date" id="inputTanggal" name="tanggal_periksa" class="w-full px-4 py-3 bg-emerald-50/50 border border-emerald-100 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition-all text-sm">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-emerald-900 ml-1">Golongan Darah</label>
                    <div class="grid grid-cols-4 gap-2">
                        <?php $golDarah = ['A', 'B', 'AB', 'O']; ?>
                        <?php foreach ($golDarah as $gd) : ?>
                            <label class="cursor-pointer">
                                <input type="radio" name="goldar" value="<?= $gd ?>" class="hidden peer">
                                <div class="py-2 text-center bg-emerald-50 border border-emerald-100 rounded-lg text-xs font-bold text-emerald-700 peer-checked:bg-emerald-600 peer-checked:text-white transition-all">
                                    <?= $gd ?>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-emerald-900 ml-1">Tinggi Badan (cm)</label>
                    <div class="relative">
                        <input type="number" id="inputTinggi" name="tinggi_badan" placeholder="0" class="w-full px-4 py-3 bg-emerald-50/50 border border-emerald-100 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition-all text-sm pr-12 font-bold">
                        <span class="absolute right-4 top-3.5 text-[10px] font-black text-emerald-600/50 uppercase">cm</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-emerald-900 ml-1">Berat Badan (kg)</label>
                    <div class="relative">
                        <input type="number" id="inputBerat" name="berat_badan" placeholder="0" class="w-full px-4 py-3 bg-emerald-50/50 border border-emerald-100 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition-all text-sm pr-12 font-bold">
                        <span class="absolute right-4 top-3.5 text-[10px] font-black text-emerald-600/50 uppercase">kg</span>
                    </div>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="text-xs font-bold text-emerald-900 ml-1">Tekanan Darah (mmHg)</label>
                    <div class="relative">
                        <input type="text" id="inputTensi" name="tekanan_darah" placeholder="Contoh: 120/80" class="w-full px-4 py-3 bg-emerald-50/50 border border-emerald-100 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition-all text-sm pr-16 font-mono tracking-widest">
                        <span class="absolute right-4 top-3.5 text-[10px] font-black text-emerald-600/50 uppercase">mmHg</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <label class="text-xs font-black text-emerald-900 uppercase tracking-widest ml-1">Keperluan Surat Keterangan</label>
            <textarea id="inputKeperluan" name="keperluan_surat" rows="4" placeholder="Misal: Melamar pekerjaan di BUMN, Persyaratan masuk perguruan tinggi, dll..." class="w-full px-6 py-4 bg-emerald-50/50 border border-emerald-100 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition-all text-sm leading-relaxed"></textarea>
        </div>

        <div class="flex flex-col sm:flex-row justify-end items-center space-y-4 sm:space-y-0 sm:space-x-6 pt-6 border-t border-emerald-50">
            <button type="button" class="text-emerald-800 font-bold text-sm hover:text-red-600 transition-all uppercase tracking-widest">Batal</button>
            <button type="button" onclick="openConfirmation()" class="w-full sm:w-auto px-10 py-4 bg-emerald-700 hover:bg-emerald-900 text-white font-black rounded-2xl shadow-xl shadow-emerald-700/20 transition-all active:scale-95 flex items-center justify-center space-x-3 uppercase tracking-wider text-sm">
                <span>Verifikasi & Simpan</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </form>
</div>

<script src="<?= base_url('assets/js/pendaftaran.js') ?>"></script>

<?= $this->endSection() ?>
<?= $this->section('modals') ?>
<?= view('pendaftaran/modals') ?>
<?= $this->endSection() ?>

<?php
if (session()->get('role') === 'Admin') {
    echo $this->include('riwayat_pendaftaran/index');
}
?>