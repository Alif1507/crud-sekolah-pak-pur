-- migrations.sql
DROP TABLE IF EXISTS nilai;
DROP TABLE IF EXISTS murid;


-- Tabel murid (dari LKM5 langkah 9)
CREATE TABLE murid (
id_murid INT AUTO_INCREMENT PRIMARY KEY,
nama VARCHAR(50),
nis VARCHAR(10),
jurusan VARCHAR(30),
kelas VARCHAR(10),
alamat TEXT
) ENGINE=InnoDB;


-- Tabel nilai (sesuai struktur pada PDF "Buat Tabel baru (nilai)")
CREATE TABLE nilai (
id_nilai INT PRIMARY KEY AUTO_INCREMENT,
id_murid INT NOT NULL,
agama FLOAT(5,2),
mtk FLOAT(5,2),
indo FLOAT(5,2),
ing FLOAT(5,2),
kejuruan FLOAT(5,2),
CONSTRAINT fk_nilai_murid
FOREIGN KEY (id_murid) REFERENCES murid(id_murid)
ON DELETE CASCADE
ON UPDATE CASCADE
) ENGINE=InnoDB;


-- Seed data murid (contoh dari PDF LKM5)
INSERT INTO murid (nama, nis, jurusan, kelas, alamat) VALUES
('Muhammad Alif Wahyudi', '2416124', 'SIJA', 'XI-SIJA-1', 'Jl. Jakarta No. 1'),
('Faiz Abdillah', '2416123', 'SIJA', 'XI-SIJA-1', 'Jl. Jakarta No. 2'),
('Muhammad Tegar Wibowo', '2416126', 'SIJA', 'XI-SIJA-1', 'Jl. Jakarta No. 3'),
('Irdan Putra Pratama', '2416127', 'SIJA', 'XI-SIJA-2', 'Jl. Jakarta No. 3'),
('Gabriel Ibanez Purnomo', '2416128', 'SIJA', 'XI-SIJA-2', 'Jl. Jakarta No. 5');


-- Seed nilai (nilai bebas sesuai instruksi PDF)
INSERT INTO nilai (id_murid, agama, mtk, indo, ing, kejuruan) VALUES
(1, 88.00, 90.00, 85.00, 82.00, 91.00),
(2, 80.00, 84.50, 83.25, 81.00, 86.75),
(3, 92.00, 88.50, 90.00, 87.00, 89.00),
(4, 78.00, 79.50, 80.00, 76.00, 82.50),
(5, 85.00, 87.00, 84.00, 83.00, 88.00);