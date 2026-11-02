-- Tampilkan semua pendaftar 
SELECT * FROM pendaftar ORDER BY nama ASC;

-- Tampilkan 5 pendaftar terbaru 
-- mengurutkan berdasarkan tgl_daftar atau id dari paling besar(terbaru)
SELECT * FROM pendaftar ORDER BY tgl_daftar DESC LIMIT 5;

-- 3. cari pendaftar yang namanya mengandung 'an'
SELECT * FROM pendaftar WHERE nama LIKE '%an%';

-- 4. tampilkan nama pedaftar beserta nama kelas (JOIN)
SELECT pendaftar.nama, kelas.nama_kelas FROM pendaftar JOIN kelas ON pendaftar.kelas_id = kelas.id;

--Hitung jumlah pendaftar per kelas (GROUP BY) 
SELECT  kelas.nama_kelas, COUNT(pendaftar.id) AS total_pendaftar FROM  kelas 
LEFT JOIN  pendaftar ON kelas.id = pendaftar.kelas_id
GROUP BY kelas.id, kelas.nama_kelas;

-- 6 Tampilkan kelas yang belum memiliki pendaftar (LEFT JOIN ... IS NULL) 
SELECT kelas.nama_kelas
FROM kelas
LEFT JOIN pendaftar ON kelas.id = pendaftar.kelas_id
WHERE pendaftar.id IS NULL;

-- 7 Ubah nomor HP satu pendaftar (dengan WHERE) 
-- CONTOH : mengubah nomor hp pendaftar dengan id = 8
UPDATE pendaftar
SET no_hp ='085876232323'
WHERE id = 8;

-- 8 Hapus satu pendaftar 
-- contoh menghapus pendaftar dengan id= 5
DELETE FROM pendaftar
WHERE id = 5;

-- 9 Coba masukkan email ganda dan amati pesan error (1062 Duplicate entry) 
-- menjalankan dua perintah INSERT  berikut akan memicu error pada perintah kedua
-- karena kolom email memiliki constraint UNIQUE
INSERT INTO pendaftar (nama, email, no_hp, kelas_id)
VALUES ('hani', 'hani@gmail.com', '0909343489898');

INSERT INTO pendaftar (nama, email, no_hp, kelas_id)
VALUES ('muh nan', 'hani@gmail.com', '323');

-- 10 Coba hapus kelas yang masih memiliki pendaftar dan amati pesan error foreign key (1451) 

DELETE FROM kelas
WHERE id = 1;