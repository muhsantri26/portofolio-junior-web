CREATE DATABASE db_pelatihan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; 
USE db_pelatihan; 
 
CREATE TABLE kelas ( 
  id INT AUTO_INCREMENT PRIMARY KEY, 
  nama_kelas VARCHAR(100) NOT NULL, 
  kuota INT NOT NULL DEFAULT 30 
) ENGINE=InnoDB; 
 
CREATE TABLE pendaftar ( 
  id INT AUTO_INCREMENT PRIMARY KEY, 
  nama VARCHAR(100) NOT NULL, 
  email VARCHAR(120) NOT NULL UNIQUE, 
  no_hp VARCHAR(20) NOT NULL, 
  alamat TEXT NULL, 
  kelas_id INT NOT NULL, 
  tgl_daftar TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
  CONSTRAINT fk_pendaftar_kelas FOREIGN KEY (kelas_id) REFERENCES kelas(id) 
    ON DELETE RESTRICT ON UPDATE CASCADE 
) ENGINE=InnoDB; 
 
CREATE TABLE admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE INDEX idx_pendaftar_nama ON pendaftar (nama); 
DML (data): 
INSERT INTO kelas (nama_kelas, kuota) VALUES ('Web Programming', 30), ('Desain 
Grafis', 25); 
 
INSERT INTO pendaftar (nama, email, no_hp, alamat, kelas_id) 
VALUES ('Sari', 'sari@contoh.com', '081234567890', 'Surakarta', 1); 
 
SELECT id, nama, email FROM pendaftar WHERE kelas_id = 1 ORDER BY nama ASC LIMIT 10 
OFFSET 0; 
 
SELECT p.nama, k.nama_kelas 
FROM pendaftar p 
JOIN kelas k ON k.id = p.kelas_id 
WHERE p.nama LIKE '%sar%'; 
 
SELECT k.nama_kelas, COUNT(p.id) AS jumlah 
FROM kelas k LEFT JOIN pendaftar p ON p.kelas_id = k.id 
GROUP BY k.id, k.nama_kelas; 
 
UPDATE pendaftar SET no_hp = '081111111111' WHERE id = 1; 
 
DELETE FROM pendaftar WHERE id = 1;