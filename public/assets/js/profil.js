function openMyProfile() {
  fetch("/user/my_profile")
    .then((res) => res.json())
    .then((data) => {
      // Gunakan konstanta agar lebih rapi
      const elNama = document.getElementById("prof_nama");
      const elUser = document.getElementById("prof_username");
      const elRole = document.getElementById("prof_role");
      const elPassLama = document.getElementById("prof_pass_lama");
      const elPassBaru = document.getElementById("prof_pass_baru");

      // Cek satu per satu, jika elemen ada (not null), baru isi value-nya
      if (elNama) elNama.value = data.nama_lengkap || "";
      if (elUser) elUser.value = data.username || "";
      if (elRole) elRole.value = data.role || "";

      // Selalu kosongkan field password
      if (elPassLama) elPassLama.value = "";
      if (elPassBaru) elPassBaru.value = "";

      toggleModal("modalEditProfil");
    })
    .catch((err) => {
      console.error("Gagal memuat profil:", err);
    });
}
document.addEventListener("DOMContentLoaded", function () {
  /// Submit Update Profil
  const formProf = document.getElementById("formEditProfil");

  // Pastikan form ditemukan sebelum memasang listener
  if (formProf) {
    formProf.addEventListener("submit", function (e) {
      // Mencegah reload halaman secara otomatis
      e.preventDefault();

      // 1. Ambil value untuk validasi client-side
      const passBaru = document.getElementById("prof_pass_baru").value;
      const passLama = document.getElementById("prof_pass_lama").value;

      // 2. Validasi Password (hanya jika password baru diisi)
      if (passBaru.length > 0) {
        if (passBaru.length < 6) {
          alert("Password baru minimal 6 karakter!");
          document.getElementById("prof_pass_baru").focus();
          return;
        }
        if (passLama === "") {
          alert("Masukkan password lama untuk mengonfirmasi perubahan password.");
          document.getElementById("prof_pass_lama").focus();
          return;
        }
      }

      // 3. Persiapan kirim data
      const formData = new FormData(this);
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;

      // Beri efek loading sederhana pada tombol
      submitBtn.innerHTML = "Menyimpan...";
      submitBtn.disabled = true;

      // 4. Proses Fetch ke Controller
      // Pastikan path "/user/update_my_profile" sudah sesuai dengan route CodeIgniter Anda
      fetch("/user/update_my_profile", {
        method: "POST",
        body: formData,
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
      })
        .then((res) => {
          if (!res.ok) throw new Error("Terjadi kesalahan pada server (Status: " + res.status + ")");
          return res.json();
        })
        .then((res) => {
          if (res.status) {
            // Berhasil!
            alert("Berhasil memperbarui profil!");

            // Tutup modal dan refresh halaman agar nama di Header terupdate
            if (typeof toggleModal === "function") {
              toggleModal("modalEditProfil");
            }
            location.reload();
          } else {
            // Gagal (Misal: Password lama salah atau validasi backend gagal)
            alert(res.message || "Gagal memperbarui profil.");
          }
        })
        .catch((err) => {
          console.error("Error update profil:", err);
          alert("Terjadi kesalahan koneksi atau server.");
        })
        .finally(() => {
          // Kembalikan tombol ke keadaan semula
          submitBtn.innerHTML = originalText;
          submitBtn.disabled = false;
        });
    });
  } 
});
