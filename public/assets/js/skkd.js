/* ==========================================================================
   GLOBAL STATE SKKD
   (Variabel ini menyimpan status halaman saat ini)
   ========================================================================== */
let currentPage = 1;
let currentLimit = 10;
let currentSearch = "";
let selectedId = null; // Menyimpan ID SKKD saat Hapus/Cetak

/* ==========================================================================
   1. INIT & EVENT LISTENER
   (Kode ini berjalan otomatis saat halaman selesai dimuat)
   ========================================================================== */
document.addEventListener("DOMContentLoaded", () => {
  // Load data pertama kali
  loadSKKD();

  // ----------------------------------------------------------------------
  // A. HANDLE SEARCH (PENCARIAN)
  // ----------------------------------------------------------------------
  const searchInput = document.querySelector("#searchSKKD");
  if (searchInput) {
    searchInput.addEventListener(
      "keyup",
      debounce((e) => {
        currentSearch = e.target.value;
        currentPage = 1;
        loadSKKD();
      }, 400),
    );
  }

  // ----------------------------------------------------------------------
  // B. HANDLE LIMIT (JUMLAH BARIS)
  // ----------------------------------------------------------------------
  const limitSelect = document.querySelector("#limitSKKD"); // Disamakan dengan pasien.js
  if (limitSelect) {
    limitSelect.addEventListener("change", (e) => {
      currentLimit = e.target.value;
      currentPage = 1;
      loadSKKD();
    });
  }
});

// --- MODAL HANDLER  ---
function toggleModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) {
    console.error(`Modal dengan ID '${modalId}' tidak ditemukan.`);
    return;
  }

  if (modal.classList.contains("hidden")) {
    modal.classList.remove("hidden");
    modal.classList.add("flex"); // Centered layout
  } else {
    modal.classList.add("hidden");
    modal.classList.remove("flex");
  }
}

// --- LOAD DATA SKKD (AJAX) ---
function loadSKKD() {
  fetch(
    `/skkd/ajaxList?page=${currentPage}&limit=${currentLimit}&search=${encodeURIComponent(
      currentSearch,
    )}`,
  )
    .then((res) => res.json())
    .then((res) => {
      renderTable(res.data, res.pagination);
      renderPagination(res.pagination);
    })
    .catch((err) => console.error("Error loadSKKD:", err));
}

// --- RENDER TABEL SKKD ---
function renderTable(data, pagination) {
  const tbody = document.querySelector("#tbodySKKD");
  tbody.innerHTML = "";

  if (!data || data.length === 0) {
    tbody.innerHTML = `
            <tr>
                <td colspan="6" class="py-10 text-center text-slate-400 italic">
                    Belum ada data SKKD terbit
                </td>
            </tr>
        `;
    return;
  }

  data.forEach((row, index) => {
    // Logika warna status
    let statusClass = "bg-slate-100 text-slate-600 border-slate-200";

    tbody.innerHTML += `
        <tr class="hover:bg-emerald-50/30 transition-colors border-b border-slate-50 last:border-0">
            <td class="px-8 py-5 text-emerald-700 font-bold text-xs font-mono whitespace-nowrap">
            ${row.nomor_surat}
            </td>
            
            <td class="px-8 py-5">
                <div class="text-sm font-black text-slate-800 uppercase tracking-tight whitespace-nowrap">${row.nama_pasien}</div>
                <div class="text-[10px] text-slate-400 font-mono italic">NIK: ${row.nik}</div>
            </td>
            
            <td class="px-8 py-5 text-slate-600 text-xs font-medium">
                ${row.nama_dokter}
            </td>
            
            <td class="px-8 py-5 text-slate-500 text-xs font-bold whitespace-nowrap">
                ${formatDate(row.created_at)}
            </td>
            
            <td class="px-6 py-4">
                <span class="inline-flex px-2 py-1 ${row.status === "Menunggu" ? "bg-yellow-50 text-yellow-600" : row.status === "Terverifikasi" ? "bg-blue-50 text-blue-600" : row.status === "Selesai" ? "bg-green-50 text-green-600" : "bg-slate-50 text-slate-600"} text-xs rounded border ${row.status === "Menunggu" ? "border-yellow-100" : row.status === "Terverifikasi" ? "border-blue-100" : row.status === "Selesai" ? "border-green-100" : "border-slate-100"} font-medium capitalize">
                 ${row.status}
                </span>
            </td>
            
            <td class="px-8 py-5 text-right whitespace-nowrap">
                <div class="flex justify-end space-x-2">
                    <button onclick="detailSKKD(${row.id_skkd})" 
                        class="p-2 text-blue-500 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-lg transition-all" title="Detail / Preview">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                    <button onclick="cetakSKKD(${row.id_skkd})" 
                        class="p-2 text-indigo-600 bg-indigo-50 hover:bg-indigo-600 hover:text-white rounded-lg transition-all" title="Cetak & Selesaikan">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    </button>
                    <button onclick="hapusSKKD(${row.id_skkd})" 
                        class="p-2 text-red-500 bg-red-50 hover:bg-red-600 hover:text-white rounded-lg transition-all" title="Hapus (Rollback)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </td>
        </tr>
        `;
  });
}

// --- PAGINATION ---
function renderPagination(p) {
  const info = document.querySelector(".pagination-info");
  const nav = document.querySelector(".pagination-nav");

  if (!info || !nav) return;

  info.innerHTML = `Menampilkan <span class="text-emerald-950 font-black">${p.from} - ${p.to}</span> dari <span class="text-emerald-950 font-black">${p.total}</span> data`;
  nav.innerHTML = "";

  if (!nav) return;
  nav.innerHTML = "";

  for (let i = 1; i <= p.total_page; i++) {
    nav.innerHTML += `
            <button onclick="goPage(${i})"
                class="w-8 h-8 rounded-lg ${
                  i === p.page
                    ? "bg-emerald-950 text-white shadow-lg shadow-emerald-900/20"
                    : "text-slate-500 hover:bg-emerald-50"
                } text-xs font-bold transition-all">
                ${i}
            </button>
        `;
  }
}

function goPage(page) {
  currentPage = page;
  loadSKKD();
}

// --- FITUR: DETAIL SKKD (Preview) ---
function detailSKKD(id) {
  fetch(`/skkd/${id}`)
    .then((res) => res.json())
    .then((data) => {
      selectedId = id;

      const elNomor = document.querySelector("#detNomorSurat");
      const elNama = document.querySelector("#detNamaPasien");
      const elNik = document.querySelector("#detNik");
      const elDokter = document.querySelector("#detDokter");
      const elTgl = document.querySelector("#detTglTerbit");

      if (elNomor) elNomor.innerText = data.nomor_surat || "-";
      if (elNama) elNama.innerText = data.nama_lengkap || "-";
      if (elNik) elNik.innerText = data.nik || "-";
      if (elDokter) elDokter.innerText = data.nama_dokter || "-";
      if (elTgl) elTgl.innerText = formatDate(data.created_at);

      toggleModal("modalDetailSKKD");
    })
    .catch((err) => console.error("Error detail:", err));
}

// --- FITUR: CETAK (Sama dengan alur aksi di pasien.js) ---
function cetakSKKD(id) {
  // LANGKAH 1: Panggil route untuk update status database
  fetch(`/skkd/cetak/${id}`)
    .then((res) => res.json())
    .then((res) => {
      if (res.status) {
        // LANGKAH 2: Jika database berhasil diupdate, buka halaman cetak
        // Ini akan memanggil function print_pdf di Controller
        window.open(`/skkd/print_pdf/${id}`, "_blank");

        // LANGKAH 3: Refresh tabel utama agar status berubah di layar
        loadSKKD();
      } else {
        alert("Gagal memperbarui status: " + res.message);
      }
    })
    .catch((err) => {
      console.error("Error cetak:", err);
      alert("Terjadi kesalahan sistem saat mencoba mencetak.");
    });
}

// --- FITUR: HAPUS SKKD ---
function hapusSKKD(id) {
  selectedId = id;
  toggleModal("modalHapusSKKD");
}

// Panggil fungsi ini dari tombol "Ya, Hapus" di Modal Hapus
function confirmDelete() {
  fetch(`/skkd/delete/${selectedId}`, {
    method: "DELETE",
    headers: { "X-Requested-With": "XMLHttpRequest" },
  })
    .then((res) => res.json())
    .then(() => {
      toggleModal("modalHapusSKKD");
      loadSKKD();
      alert("Data berhasil dihapus");
    })
    .catch((err) => console.error("Error delete:", err));
}

// --- UTILITIES (Sama persis dengan pasien.js) ---
function formatDate(dateString) {
  if (!dateString) return "-";
  const options = { day: "numeric", month: "long", year: "numeric" };
  return new Date(dateString).toLocaleDateString("id-ID", options);
}

function debounce(func, timeout = 300) {
  let timer;
  return (...args) => {
    clearTimeout(timer);
    timer = setTimeout(() => {
      func.apply(this, args);
    }, timeout);
  };
}
