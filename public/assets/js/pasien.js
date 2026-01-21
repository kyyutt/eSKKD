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
  loadPasien();

  // ----------------------------------------------------------------------
  // A. HANDLE SEARCH (PENCARIAN)
  // ----------------------------------------------------------------------
  const searchInput = document.querySelector("#searchPasien"); // Sesuai ID di HTML
  if (searchInput) {
    searchInput.addEventListener(
      "keyup",
      debounce((e) => {
        currentSearch = e.target.value;
        currentPage = 1;
        loadPasien();
      }, 400),
    );
  }

  // ----------------------------------------------------------------------
  // B. HANDLE LIMIT (JUMLAH BARIS)
  // ----------------------------------------------------------------------
  const limitSelect = document.querySelector("#limitPasien"); // Sesuai ID di HTML
  if (limitSelect) {
    limitSelect.addEventListener("change", (e) => {
      currentLimit = e.target.value;
      currentPage = 1;
      loadPasien();
    });
  }

  // ----------------------------------------------------------------------
  // C. HANDLE FORM SUBMIT (TAMBAH DATA)
  // ----------------------------------------------------------------------
  const formTambah = document.querySelector("#formTambahPasien");
  if (formTambah) {
    formTambah.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch("/pasien/store", {
        method: "POST",
        body: formData,
        headers: { "X-Requested-With": "XMLHttpRequest" },
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.status) {
            toggleModal("modalPasien"); // Tutup modal
            this.reset(); // Kosongkan form
            currentPage = 1; // Kembali ke halaman 1
            loadPasien(); // Refresh tabel
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
  const formEdit = document.querySelector("#formEditPasien");
  if (formEdit) {
    formEdit.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch(`/pasien/update/${selectedId}`, {
        method: "POST",
        body: formData,
        headers: { "X-Requested-With": "XMLHttpRequest" },
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.status) {
            toggleModal("modalEditPasien"); // Tutup modal
            loadPasien(); // Refresh tabel
            alert("Data berhasil diperbarui!");
          } else {
            alert("Gagal mengupdate data.");
          }
        })
        .catch((err) => console.error("Error update:", err));
    });
  }
  // Validasi Tanggal Lahir: Set MAX date ke HARI INI
  const tglInput = document.getElementById("tglLahirInput");
  if (tglInput) {
    const today = new Date().toISOString().split("T")[0];
    tglInput.setAttribute("max", today);
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
function loadPasien() {
  fetch(
    `/pasien/ajaxList?page=${currentPage}&limit=${currentLimit}&search=${encodeURIComponent(
      currentSearch,
    )}`,
  )
    .then((res) => res.json())
    .then((res) => {
      renderTable(res.data, res.pagination);
      renderPagination(res.pagination);
    })
    .catch((err) => console.error("Error loadPasien:", err));
}

// --- RENDER TABEL ---
function renderTable(data, pagination) {
  const tbody = document.querySelector("#tbodyPasien"); // Pastikan ID tbody sesuai
  tbody.innerHTML = "";

  if (!data || data.length === 0) {
    tbody.innerHTML = `
            <tr>
                <td colspan="7" class="py-5 text-center text-slate-400 italic">
                    Data pasien tidak ditemukan
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
                      row.nik
                    }</span>
                </div>
            </td>
            
            <td class="px-6 py-4">
                <div class="text-sm font-semibold text-slate-700 capitalize tracking-tight">
                    ${row.nama_lengkap.toLowerCase()}
                </div>
            </td>
            
            <td class="px-6 py-4">
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-slate-700 capitalize">${row.tempat_lahir.toLowerCase()}</span>
                    <span class="text-xs text-slate-400 font-medium">${formatDate(
                      row.tanggal_lahir,
                    )}</span>
                </div>
            </td>
            
            <td class="px-6 py-4 text-center">
                <div class="flex justify-center">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold border ${
                      row.jenis_kelamin == "L"
                        ? "bg-blue-50 text-blue-600 border-blue-100"
                        : "bg-pink-50 text-pink-600 border-pink-100"
                    }">
                        ${row.jenis_kelamin}
                    </span>
                </div>
            </td>
            
            <td class="px-6 py-4">
                <div class="text-sm text-slate-600 font-medium capitalize">
                    ${row.pekerjaan ? row.pekerjaan.toLowerCase() : "-"}
                </div>
            </td>
            <td class="px-8 py-6 text-right whitespace-nowrap">
                <div class="flex justify-end space-x-2">
                    <button onclick="detailPasien(${row.id_pasien})" 
                        class="p-2 text-blue-500 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-lg transition-all" title="Detail">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                    <button onclick="editPasien(${row.id_pasien})" 
                        class="p-2 text-emerald-600 bg-emerald-50 hover:bg-emerald-600 hover:text-white rounded-lg transition-all" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button onclick="hapusPasien(${row.id_pasien})" 
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
  loadPasien();
}

// --- FITUR: DETAIL PASIEN ---
function detailPasien(id) {
  // 1. Ambil data dari server
  fetch(`/pasien/${id}`)
    .then((res) => res.json())
    .then((data) => {
      selectedId = id; // Simpan ID (siapa tau butuh)

      // 2. Masukkan data ke elemen HTML berdasarkan ID
      const elNik = document.getElementById("detail_nik");
      const elNama = document.getElementById("detail_nama");
      const elJk = document.getElementById("detail_jk");
      const elTtl = document.getElementById("detail_ttl");
      const elPekerjaan = document.getElementById("detail_pekerjaan");
      const elAlamat = document.getElementById("detail_alamat");
      const elCreatedBy = document.getElementById("detail_created_by");
      const elUpdatedBy = document.getElementById("detail_updated_by");

      // Cek biar gak error kalau elemen null
      if (elNik) elNik.innerText = data.nik || "-";
      if (elNama) elNama.innerText = data.nama_lengkap || "-";

      // Logika ubah L/P jadi teks panjang biar bagus
      if (elJk) {
        const jkText = data.jenis_kelamin === "L" ? "LAKI-LAKI" : "PEREMPUAN";
        elJk.innerText = jkText;
      }

      // Gabung Tempat + Tanggal Lahir
      if (elTtl) {
        const tgl = formatDate(data.tanggal_lahir); // Panggil helper format tanggal
        elTtl.innerText = `${data.tempat_lahir || ""}, ${tgl}`;
      }

      if (elPekerjaan) elPekerjaan.innerText = data.pekerjaan || "-";
      if (elAlamat) elAlamat.innerText = data.alamat || "-";

      if (elCreatedBy)
        elCreatedBy.innerText = data.created_by_name
          ? `${data.created_by_name} (${formatDate(data.created_at)})`
          : "-";
      if (elUpdatedBy)
        elUpdatedBy.innerText = data.updated_by_name
          ? `${data.updated_by_name} (${formatDate(data.updated_at)})`
          : "-";

      // 3. Tampilkan Modal
      toggleModal("modalDetailPasien");
    })
    .catch((err) => console.error("Error detail:", err));
}

// --- FITUR: EDIT PASIEN ---
function editPasien(id) {
  fetch(`/pasien/${id}`)
    .then((res) => res.json())
    .then((data) => {
      selectedId = id;
      const form = document.querySelector("#formEditPasien");

      if (form) {
        // Auto-fill input berdasarkan name attribute
        form.elements["nik"].value = data.nik;
        form.elements["nama_lengkap"].value = data.nama_lengkap;
        form.elements["tempat_lahir"].value = data.tempat_lahir;
        form.elements["tanggal_lahir"].value = data.tanggal_lahir;
        form.elements["pekerjaan"].value = data.pekerjaan;
        form.elements["alamat"].value = data.alamat;

        // Handle Radio Button Jenis Kelamin
        if (data.jenis_kelamin) {
          const radios = form.elements["jenis_kelamin"];
          for (let i = 0; i < radios.length; i++) {
            if (radios[i].value === data.jenis_kelamin) {
              radios[i].checked = true;
            }
          }
        }
      }
      toggleModal("modalEditPasien");
    })
    .catch((err) => console.error("Error edit:", err));
}

// --- FITUR: HAPUS PASIEN ---
function hapusPasien(id) {
  selectedId = id;
  toggleModal("modalHapusPasien");
}

// Panggil fungsi ini dari tombol "Ya, Hapus" di Modal Hapus
function confirmDelete() {
  fetch(`/pasien/delete/${selectedId}`, {
    method: "DELETE",
    headers: { "X-Requested-With": "XMLHttpRequest" },
  })
    .then((res) => res.json())
    .then(() => {
      toggleModal("modalHapusPasien");
      loadPasien();
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
