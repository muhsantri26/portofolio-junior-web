const readline = require('readline/promises');
const { stdin: input, stdout: output } = require('process');

const NILAI_MIN = 0;
const NILAI_MAKS = 100;
const BATAS_LULUS = 70;
const BATAS_GRADE_A = 85;
const BATAS_GRADE_B = 70;
const BATAS_GRADE_C = 55;
const JUMLAH_ANGKA_DESIMAL = 2;

async function main() {
  const rl = readline.createInterface({ input, output });
  const daftarNama = [];
  const daftarNilai = [];
  let jalan = true;

  try {
    while (jalan) {
      console.log('\n===== PENGOLAH NILAI =====');
      console.log('1. Input nilai siswa');
      console.log('2. Tampilkan rata-rata, nilai tertinggi, dan terendah');
      console.log('3. Tampilkan predikat lulus/tidak lulus per siswa');
      console.log('4. Keluar');

      const pilihan = (await rl.question('Pilih menu (1-4): ')).trim();

      switch (pilihan) {
        case '1': {
          const nama = (await rl.question('Nama siswa: ')).trim();
          if (nama === '') {
            console.log('Nama tidak boleh kosong.');
            break;
          }

          const inputNilai = (await rl.question('Nilai (0-100): ')).trim();
          const nilai = Number(inputNilai);
          if (
            inputNilai === '' ||
            Number.isNaN(nilai) ||
            nilai < NILAI_MIN ||
            nilai > NILAI_MAKS
          ) {
            console.log('Nilai harus berupa angka dari 0 sampai 100.');
            break;
          }

          daftarNama.push(nama);
          daftarNilai.push(nilai);
          console.log(`Nilai ${nama} berhasil disimpan.`);
          break;
        }
        case '2': {
          if (daftarNilai.length === 0) {
            console.log('Belum ada data nilai siswa.');
            break;
          }

          let totalNilai = 0;
          let nilaiTertinggi = daftarNilai[0];
          let nilaiTerendah = daftarNilai[0];
          let jumlahLulus = 0;
          let jumlahTidakLulus = 0;

          for (const nilai of daftarNilai) {
            totalNilai += nilai;
            if (nilai > nilaiTertinggi) {
              nilaiTertinggi = nilai;
            }
            if (nilai < nilaiTerendah) {
              nilaiTerendah = nilai;
            }
            if (nilai >= BATAS_LULUS) {
              jumlahLulus++;
            } else {
              jumlahTidakLulus++;
            }
          }

          const rataRata = totalNilai / daftarNilai.length;
          console.log(`Rata-rata: ${rataRata.toFixed(JUMLAH_ANGKA_DESIMAL)}`);
          console.log(`Nilai tertinggi: ${nilaiTertinggi}`);
          console.log(`Nilai terendah: ${nilaiTerendah}`);
          console.log(`Jumlah siswa lulus: ${jumlahLulus}`);
          console.log(`Jumlah siswa tidak lulus: ${jumlahTidakLulus}`);
          break;
        }
        case '3': {
          if (daftarNilai.length === 0) {
            console.log('Belum ada data nilai siswa.');
            break;
          }

          for (let indeks = 0; indeks < daftarNilai.length; indeks++) {
            const nilai = daftarNilai[indeks];
            let grade;

            if (nilai >= BATAS_GRADE_A) {
              grade = 'A';
            } else if (nilai >= BATAS_GRADE_B) {
              grade = 'B';
            } else if (nilai >= BATAS_GRADE_C) {
              grade = 'C';
            } else {
              grade = 'D';
            }

            const status = nilai >= BATAS_LULUS ? 'Lulus' : 'Tidak lulus';
            console.log(
              `${daftarNama[indeks]}: nilai ${nilai}, grade ${grade}, ${status}`
            );
          }
          break;
        }
        case '4':
          jalan = false;
          console.log('Terima kasih.');
          break;
        default:
          console.log('Pilihan tidak valid. Masukkan angka 1-4.');
      }
    }
  } finally {
    rl.close();
  }
}

main().catch((error) => {
  console.error('Terjadi kesalahan saat menjalankan program:', error);
  process.exitCode = 1;
});
