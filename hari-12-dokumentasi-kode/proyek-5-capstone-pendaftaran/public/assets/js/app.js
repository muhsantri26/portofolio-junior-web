/**
 * @file Script utama antarmuka pengguna (UI).
 * Menangani notifikasi SweetAlert2 dan inisialisasi DataTables.
 * Dijalankan setelah seluruh struktur DOM selesai dimuat.
 */

document.addEventListener("DOMContentLoaded", () => {
  // ---------------------------------------------------------
  // 1. Notifikasi Flash (Toast)
  // ---------------------------------------------------------

  /**
   * Elemen HTML untuk notifikasi flash.
   * @global
   * @type {HTMLElement | null}
   */
  const flash = document.getElementById("flash");
  if (flash && window.Swal) {
    /**
     * Konfigurasi notifikasi toast SweetAlert2.
     * @global
     * @type {Object}
     */
    Swal.fire({
      toast: true,
      position: "top-end",
      icon: "success",
      title: flash.dataset.pesan,
      showConfirmButton: false,
      timer: 3000,
    });
  }
  // ---------------------------------------------------------
  // 2. Konfirmasi Hapus Data
  // ---------------------------------------------------------

  /**
   * Daftar formulir yang membutuhkan konfirmasi sebelum dihapus.
   * @global
   * @type {NodeListOf<HTMLFormElement>}
   */
  document.querySelectorAll(".form-hapus").forEach((form) => {
    /**
     * menghentikan submit bawaan dari menampilkan konfirmasi
     * @param {Event} event - objek event dari aksi submit
     */
    form.addEventListener("submit", (event) => {
      event.preventDefault(); //mencegah form langsung tersubmit
      if (!window.Swal) {
        if (window.confirm(`Hapus ${form.dataset.nama}?`)) form.submit();
        return;
      }
      Swal.fire({
        title: "Hapus data?",
        text: `Data ${form.dataset.nama} akan dihapus permanen.`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Batal",
      }).then((hasil) => {
        if (hasil.isConfirmed) form.submit();
      });
    });
  });
  // ---------------------------------------------------------
  // 3. Inisialisasi DataTables (Lab 4)
  // ---------------------------------------------------------

  /**
   * Elemen tabel yang akan diubah menjadi DataTables.
   * @global
   * @type {HTMLElement | null}
   */
  const tabel = document.getElementById("tabelPendaftar");
  if (tabel && window.jQuery) {
    /**
     * Konfigurasi DataTables bahasa Indonesia.
     * @global
     * @type {Object}
     */
    const dataTable = window.jQuery(tabel).DataTable({
      pageLength: 10,
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json",
      },
      columnDefs: [{ orderable: false, targets: -1 }],
    });
    const filterKelas = document.getElementById("filterKelas");
    if (filterKelas) {
      filterKelas.addEventListener("change", () => {
        const nilai = window.jQuery.fn.dataTable.util.escapeRegex(filterKelas.value);
        dataTable.column(3).search(nilai ? `^${nilai}$` : "", true, false).draw();
      });
    }
  }
});
