<div id="modalEditPendaftaran" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 transition-all duration-300">
    
    <div class="bg-white w-full max-w-3xl rounded-xl shadow-2xl overflow-hidden border border-slate-100">
        
        <div class="bg-white px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-slate-800">Edit Data Pemeriksaan</h3>
            <button onclick="toggleModal('modalEditPendaftaran')" type="button" class="text-slate-400 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
            <form id="formEditPendaftaran" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Dokter Pemeriksa</label>
                    <select name="id_dokter" 
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all appearance-none cursor-pointer">
                        <option value="">-- Pilih Dokter --</option>
                        <?php if(isset($dokter)) : ?>
                            <?php foreach($dokter as $d) : ?>
                                <option value="<?= $d['id_dokter'] ?>"><?= $d['nama_dokter'] ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tinggi Badan (cm)</label>
                    <div class="relative">
                        <input type="number" name="tinggi_badan" step="0.1"
                            class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                        <span class="absolute right-3 top-2.5 text-xs text-slate-400 font-bold">CM</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Berat Badan (kg)</label>
                    <div class="relative">
                        <input type="number" name="berat_badan" step="0.1"
                            class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                        <span class="absolute right-3 top-2.5 text-xs text-slate-400 font-bold">KG</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tekanan Darah (mmHg)</label>
                    <input type="text" name="tekanan_darah" placeholder="Contoh: 120/80"
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Golongan Darah</label>
                    <select name="golongan_darah" 
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all cursor-pointer">
                        <option value="">- Pilih -</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                        <option value="-">Tidak Tahu</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Keperluan Surat Keterangan</label>
                    <textarea name="keperluan_surat" rows="3" placeholder="Contoh: Persyaratan Melamar Pekerjaan..."
                        class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-900 font-normal focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all resize-none"></textarea>
                </div>

            </form>
        </div>

        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
            <button onclick="toggleModal('modalEditPendaftaran')" type="button" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-200 transition-all">
                Batal
            </button>
            <button type="submit" form="formEditPendaftaran" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 shadow-sm transition-all">
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>