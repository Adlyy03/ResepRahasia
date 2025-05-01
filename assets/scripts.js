const tambahBtn = document.getElementById('tambahBtn');
const formContainer = document.getElementById('formContainer');
const closeBtn = document.getElementById('closeBtn');
const submitBtn = document.getElementById('submitBtn');
const formTitle = document.getElementById('formTitle');
const namaResepInput = document.getElementById('nama_resep');
const bahanInput = document.getElementById('bahan');
const waktuPersiapkanInput = document.getElementById('waktu_persiapkan');
const kategoriInput = document.getElementById('kategori');
const editIdInput = document.getElementById('editId');

// Menampilkan form tambah resep
tambahBtn.onclick = function () {
  formTitle.textContent = 'Tambah Resep';
  submitBtn.name = 'tambah_resep';
  formContainer.style.display = 'block';
  clearForm();
};

// Menutup form
closeBtn.onclick = function () {
  formContainer.style.display = 'none';
};

// Fungsi untuk edit resep
function editResep(id) {
  // Ambil data resep melalui AJAX
  fetch('get_resep.php?id=' + id)
    .then(response => response.json())
    .then(data => {
      formTitle.textContent = 'Edit Resep';
      submitBtn.name = 'update_resep';
      namaResepInput.value = data.nama_resep;
      bahanInput.value = data.bahan;
      waktuPersiapkanInput.value = data.waktu_persiapkan;
      kategoriInput.value = data.kategori;
      editIdInput.value = data.id;
      formContainer.style.display = 'block';
    });
}

// Fungsi untuk hapus resep
function hapusResep(id) {
  if (confirm('Apakah Anda yakin ingin menghapus resep ini?')) {
    fetch('admin.php?hapus=' + id)
      .then(response => {
        document.getElementById('resep-' + id).remove();
        alert('Resep berhasil dihapus');
      });
  }
}

// Bersihkan form saat menambah resep
function clearForm() {
  namaResepInput.value = '';
  bahanInput.value = '';
  waktuPersiapkanInput.value = '';
  kategoriInput.value = '';
  editIdInput.value = '';
}
