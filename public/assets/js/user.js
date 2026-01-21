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
  loadUser();

  // ----------------------------------------------------------------------
  // A. HANDLE SEARCH (PENCARIAN)
  // ----------------------------------------------------------------------
  const searchInput = document.querySelector("#searchUser"); // Sesuai ID di HTML
  if (searchInput) {
    searchInput.addEventListener(
      "keyup",
      debounce((e) => {
        currentSearch = e.target.value;
        currentPage = 1;
        loadUser();
      }, 400),
    );
  }

  // ----------------------------------------------------------------------
  // B. HANDLE LIMIT (JUMLAH BARIS)
  // ----------------------------------------------------------------------
  const limitSelect = document.querySelector("#limitUser"); // Sesuai ID di HTML
  if (limitSelect) {
    limitSelect.addEventListener("change", (e) => {
      currentLimit = e.target.value;
      currentPage = 1;
      loadUser();
    });
  }

  // ----------------------------------------------------------------------
  // C. HANDLE FORM SUBMIT (TAMBAH DATA)
  // ----------------------------------------------------------------------
  const formTambah = document.querySelector("#formTambahUser");
  if (formTambah) {
    formTambah.addEventListener("submit", function (e) {
      e.preventDefault();

      // --- VALIDASI PASSWORD DIMULAI ---
      const pass = document.getElementById("passwordInput").value;
      const confirm = document.getElementById("passwordConfirmInput").value;

      if (pass !== confirm) {
        alert("Konfirmasi password tidak cocok! Silakan cek kembali.");
        // Fokuskan kembali ke input konfirmasi agar user bisa langsung perbaiki
        document.getElementById("passwordConfirmInput").focus();
        return; // Berhenti di sini, jangan lanjut ke fetch
      }
      // --- VALIDASI PASSWORD SELESAI ---

      const formData = new FormData(this);

      fetch("/user/store", {
        method: "POST",
        body: formData,
        headers: { "X-Requested-With": "XMLHttpRequest" },
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.status) {
            toggleModal("modalUser");
            this.reset();
            currentPage = 1;
            loadUser();
            alert("Data berhasil disimpan!");
          } else {
            // Jika server mengirimkan pesan error spesifik (misal: username sudah ada)
            alert(res.message || "Gagal menyimpan data. Periksa inputan Anda.");
          }
        })
        .catch((err) => {
          console.error("Error store:", err);
          alert("Terjadi kesalahan pada sistem.");
        });
    });
  }

  // ----------------------------------------------------------------------
  // D. HANDLE FORM SUBMIT (EDIT DATA)
  // ----------------------------------------------------------------------
  const formEdit = document.querySelector("#formEditUser");
  if (formEdit) {
    formEdit.addEventListener("submit", function (e) {
      e.preventDefault();

      // --- VALIDASI PASSWORD OPSIONAL ---
      const pass = document.getElementById("edit_password").value;
      const confirm = document.getElementById("edit_password_confirm").value;

      // Jika kolom password diisi (tidak kosong), maka wajib validasi kecocokan
      if (pass.length > 0) {
        if (pass !== confirm) {
          alert("Konfirmasi password baru tidak cocok!");
          document.getElementById("edit_password_confirm").focus();
          return; // Hentikan proses jika tidak cocok
        }

        if (pass.length < 6) {
          alert("Password baru minimal harus 6 karakter!");
          document.getElementById("edit_password").focus();
          return;
        }
      }
      // ----------------------------------

      const formData = new FormData(this);

      fetch(`/user/update/${selectedId}`, {
        method: "POST",
        body: formData,
        headers: { "X-Requested-With": "XMLHttpRequest" },
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.status) {
            toggleModal("modalEditUser");
            loadUser();
            alert("Data berhasil diperbarui!");
          } else {
            alert(res.message || "Gagal mengupdate data.");
          }
        })
        .catch((err) => {
          console.error("Error update:", err);
          alert("Terjadi kesalahan koneksi ke server.");
        });
    });
  }
});

/* ==========================================================================
   2. GLOBAL FUNCTIONS
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
function loadUser() {
  fetch(
    `/user/ajaxList?page=${currentPage}&limit=${currentLimit}&search=${encodeURIComponent(
      currentSearch,
    )}`,
  )
    .then((res) => res.json())
    .then((res) => {
      renderTable(res.data, res.pagination);
      renderPagination(res.pagination);
    })
    .catch((err) => console.error("Error loadUser:", err));
}

// --- RENDER TABEL ---
function renderTable(data, pagination) {
  const tbody = document.querySelector("#tbodyUser"); // Pastikan ID tbody sesuai
  tbody.innerHTML = "";

  if (!data || data.length === 0) {
    tbody.innerHTML = `
            <tr>
                <td colspan="7" class="py-5 text-center text-slate-400 italic">
                    Data User tidak ditemukan
                </td>
            </tr>
        `;
    return;
  }
  function editUser(id) {
    selectedId = id;
    // Ambil data user...
    // Lalu saat mengisi form:
    document.getElementById("edit_password").value = "";
    document.getElementById("edit_password_confirm").value = "";
    toggleModal("modalEditUser");
  }

  data.forEach((row, index) => {
    const no = pagination.from + index;
    tbody.innerHTML += `
        <tr class="hover:bg-emerald-50/40 transition-colors group border-b border-slate-50 last:border-0">
            <td class="px-6 py-4 text-center text-slate-500 font-medium text-xs">
                ${no}
            </td>
            
            <td class="px-6 py-4">
                <div class="text-sm font-semibold text-slate-700 capitalize tracking-tight">${
                  row.nama_lengkap
                }
                </div>
            </td>
            
            <td class="px-6 py-4">
                <div class="text-sm font-semibold text-slate-700 capitalize tracking-tight">
                    ${row.username}
                </div>
            </td>

            <td class="px-6 py-4">
                <div class="text-sm font-semibold text-slate-700 capitalize tracking-tight">
                    ${row.role}
                </div>
            </td>

            <td class="px-8 py-6 text-right whitespace-nowrap">
                <div class="flex justify-end space-x-2">
                    <button onclick="editUser(${row.id_user})" 
                        class="p-2 text-emerald-600 bg-emerald-50 hover:bg-emerald-600 hover:text-white rounded-lg transition-all" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button onclick="hapusUser(${row.id_user})" 
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
  loadUser();
}

// --- FITUR: EDIT USER  ---
function editUser(id) {
  fetch(`/user/${id}`)
    .then((res) => res.json())
    .then((data) => {
      selectedId = id;
      const form = document.querySelector("#formEditUser");
      if (form) {
        form.elements["nama_lengkap"].value = data.nama_lengkap;
        form.elements["username"].value = data.username;
        form.elements["role"].value = data.role;
      }
      toggleModal("modalEditUser");
    })
    .catch((err) => console.error("Error edit:", err));
}

// --- FITUR: HAPUS USER ---
function hapusUser(id) {
  selectedId = id;
  toggleModal("modalHapusUser");
}

// Panggil fungsi ini dari tombol "Ya, Hapus" di Modal Hapus
function confirmDelete() {
  fetch(`/user/delete/${selectedId}`, {
    method: "DELETE",
    headers: { "X-Requested-With": "XMLHttpRequest" },
  })
    .then((res) => res.json())
    .then(() => {
      toggleModal("modalHapusUser");
      loadUser();
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

