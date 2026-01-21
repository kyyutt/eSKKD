/* ==========================================================================
   GLOBAL STATE
   (Variabel ini menyimpan status halaman saat ini)
   ========================================================================== */
let currentPage = 1;
let currentLimit = 10;
let currentSearch = "";
let selectedId = null; // Menyimpan ID saat Edit/Hapus

/* ==========================================================================
   1. INIT & EVENT LISTENER
   (Kode ini berjalan otomatis saat halaman selesai dimuat)
   ========================================================================== */
document.addEventListener("DOMContentLoaded", () => {
  // Load data pertama kali
  loadDokter();

  // ----------------------------------------------------------------------
  // A. HANDLE SEARCH (PENCARIAN)
  // ----------------------------------------------------------------------
  const searchInput = document.querySelector("#searchDokter"); // Sesuai ID di HTML
  if (searchInput) {
    searchInput.addEventListener(
      "keyup",
      debounce((e) => {
        currentSearch = e.target.value;
        currentPage = 1;
        loadDokter();
      }, 400),
    );
  }

  // ----------------------------------------------------------------------
  // B. HANDLE LIMIT (JUMLAH BARIS)
  // ----------------------------------------------------------------------
  const limitSelect = document.querySelector("#limitDokter"); // Sesuai ID di HTML
  if (limitSelect) {
    limitSelect.addEventListener("change", (e) => {
      currentLimit = e.target.value;
      currentPage = 1;
      loadDokter();
    });
  }

  // ----------------------------------------------------------------------
  // C. HANDLE FORM SUBMIT (TAMBAH DATA)
  // ----------------------------------------------------------------------
  const formTambah = document.querySelector("#formTambahDokter");
  if (formTambah) {
    formTambah.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch("/dokter/store", {
        method: "POST",
        body: formData,
        headers: { "X-Requested-With": "XMLHttpRequest" },
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.status) {
            toggleModal("modalDokter"); // Tutup modal
            this.reset(); // Kosongkan form
            currentPage = 1; // Kembali ke halaman 1
            loadDokter(); // Refresh tabel
            alert("Data berhasil disimpan!");
          } else {
            alert("Gagal menyimpan data. Periksa inputan Anda.");
          }
        })
        .catch((err) => console.error("Error store:", err));
    });
  }

  // ----------------------------------------------------------------------
  // D. HANDLE FORM SUBMIT (EDIT DATA)
  // ----------------------------------------------------------------------
  const formEdit = document.querySelector("#formEditDokter");
  if (formEdit) {
    formEdit.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch(`/dokter/update/${selectedId}`, {
        method: "POST",
        body: formData,
        headers: { "X-Requested-With": "XMLHttpRequest" },
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.status) {
            toggleModal("modalEditDokter"); // Tutup modal
            loadDokter(); // Refresh tabel
            alert("Data berhasil diperbarui!");
          } else {
            alert("Gagal mengupdate data.");
          }
        })
        .catch((err) => console.error("Error update:", err));
    });
  }
});

/* ==========================================================================
   2. GLOBAL FUNCTIONS
   (Fungsi ini ditaruh di luar agar bisa dipanggil HTML onclick="")
   ========================================================================== */

// --- MODAL HANDLER (PENTING: Handle class Hidden/Flex) ---
function toggleModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) {
    console.error(`Modal dengan ID '${modalId}' tidak ditemukan.`);
    return;
  }

  if (modal.classList.contains("hidden")) {
    modal.classList.remove("hidden");
    modal.classList.add("flex"); // Pakai flex agar centered
  } else {
    modal.classList.add("hidden");
    modal.classList.remove("flex");
  }
}

// --- LOAD DATA (AJAX) ---
function loadDokter() {
  fetch(
    `/dokter/ajaxList?page=${currentPage}&limit=${currentLimit}&search=${encodeURIComponent(
      currentSearch,
    )}`,
  )
    .then((res) => res.json())
    .then((res) => {
      renderTable(res.data, res.pagination);
      renderPagination(res.pagination);
    })
    .catch((err) => console.error("Error loadDokter:", err));
}

// --- RENDER TABEL ---
function renderTable(data, pagination) {
  const tbody = document.querySelector("#tbodyDokter"); // Pastikan ID tbody sesuai
  tbody.innerHTML = "";

  if (!data || data.length === 0) {
    tbody.innerHTML = `
            <tr>
                <td colspan="7" class="py-5 text-center text-slate-400 italic">
                    Data Dokter tidak ditemukan
                </td>
            </tr>
        `;
    return;
  }

  data.forEach((row, index) => {
    const no = pagination.from + index;
    tbody.innerHTML += `
        <tr class="hover:bg-emerald-50/40 transition-colors group border-b border-slate-50 last:border-0">
            <td class="px-6 py-4 text-center text-slate-500 font-medium text-xs">
                ${no}
            </td>
            
            <td class="px-6 py-4">
                <div class="inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-100/50">
                    <span class="text-xs font-mono font-medium text-emerald-700 tracking-wide">${
                      row.nomor_identitas
                    }</span>
                </div>
            </td>
            
            <td class="px-6 py-4">
                <div class="text-sm font-semibold text-slate-700 capitalize tracking-tight">
                    ${row.nama_dokter.toLowerCase()}
                </div>
            </td>

            <td class="px-8 py-6 text-right whitespace-nowrap">
                <div class="flex justify-end space-x-2">
                    <button onclick="editDokter(${row.id_dokter})" 
                        class="p-2 text-emerald-600 bg-emerald-50 hover:bg-emerald-600 hover:text-white rounded-lg transition-all" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button onclick="hapusDokter(${row.id_dokter})" 
                        class="p-2 text-red-500 bg-red-50 hover:bg-red-600 hover:text-white rounded-lg transition-all" title="Hapus">
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
  loadDokter();
}

// --- FITUR: EDIT DOKTER  ---
function editDokter(id) {
  fetch(`/dokter/${id}`)
    .then((res) => res.json())
    .then((data) => {
      selectedId = id;
      const form = document.querySelector("#formEditDokter");
      if (form) {
        // Auto-fill input berdasarkan name attribute
        form.elements["nomor_identitas"].value = data.nomor_identitas;
        form.elements["nama_dokter"].value = data.nama_dokter;
      }
      toggleModal("modalEditDokter");
    })
    .catch((err) => console.error("Error edit:", err));
}

// --- FITUR: HAPUS DOKTER ---
function hapusDokter(id) {
  selectedId = id;
  toggleModal("modalHapusDokter");
}

// Panggil fungsi ini dari tombol "Ya, Hapus" di Modal Hapus
function confirmDelete() {
  fetch(`/dokter/delete/${selectedId}`, {
    method: "DELETE",
    headers: { "X-Requested-With": "XMLHttpRequest" },
  })
    .then((res) => res.json())
    .then(() => {
      toggleModal("modalHapusDokter");
      loadDokter();
      alert("Data berhasil dihapus");
    })
    .catch((err) => console.error("Error delete:", err));
}

// --- UTILITIES ---
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
