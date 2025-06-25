-- 1. Buat database
CREATE DATABASE IF NOT EXISTS db_mcu_klinik;
USE db_mcu_klinik;

-- 2. Tabel perusahaan (untuk master data)
CREATE TABLE perusahaan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_perusahaan VARCHAR(100) NOT NULL,
    alamat TEXT
);

-- 3. Tabel pasien
CREATE TABLE pasien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_rm VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100),
    tgl_lahir DATE,
    jenis_kelamin ENUM('L', 'P'),
    perusahaan_id INT,
    jabatan VARCHAR(100),
    foto VARCHAR(255),
    tgl_mcu DATE,
    FOREIGN KEY (perusahaan_id) REFERENCES perusahaan(id)
);

-- 4. Tabel dokter/petugas
CREATE TABLE petugas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    jabatan VARCHAR(100),
    sip VARCHAR(50)
);

-- 5. Pemeriksaan fisik
CREATE TABLE pemeriksaan_fisik (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pasien_id INT,
    tinggi_cm INT,
    berat_kg INT,
    tekanan_darah VARCHAR(10),
    nadi INT,
    suhu DECIMAL(4,2),
    status_gizi VARCHAR(50),
    hasil TEXT,
    kesimpulan TEXT,
    FOREIGN KEY (pasien_id) REFERENCES pasien(id)
);

-- 6. Pemeriksaan laboratorium
CREATE TABLE pemeriksaan_lab (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pasien_id INT,
    hb DECIMAL(4,2),
    leukosit DECIMAL(5,2),
    trombosit DECIMAL(5,2),
    gula_pu DECIMAL(5,2),
    gula_pp DECIMAL(5,2),
    kolesterol_total DECIMAL(5,2),
    asam_urat DECIMAL(5,2),
    sgpt DECIMAL(5,2),
    sgot DECIMAL(5,2),
    ureum DECIMAL(5,2),
    kreatinin DECIMAL(5,2),
    urine_ph DECIMAL(3,1),
    kesimpulan TEXT,
    FOREIGN KEY (pasien_id) REFERENCES pasien(id)
);

-- 7. Pemeriksaan ECG
CREATE TABLE pemeriksaan_ecg (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pasien_id INT,
    file_ecg VARCHAR(255),
    kesimpulan TEXT,
    FOREIGN KEY (pasien_id) REFERENCES pasien(id)
);

-- 8. Pemeriksaan treadmill
CREATE TABLE pemeriksaan_treadmill (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pasien_id INT,
    file_treadmill VARCHAR(255),
    kesimpulan TEXT,
    FOREIGN KEY (pasien_id) REFERENCES pasien(id)
);

-- 9. Pemeriksaan radiologi
CREATE TABLE pemeriksaan_radiologi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pasien_id INT,
    file_rontgen VARCHAR(255),
    kesimpulan TEXT,
    FOREIGN KEY (pasien_id) REFERENCES pasien(id)
);

-- 10. Pemeriksaan audiometri & spirometri
CREATE TABLE pemeriksaan_audio_spiro (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pasien_id INT,
    file_audio_spiro VARCHAR(255),
    hasil TEXT,
    kesimpulan TEXT,
    FOREIGN KEY (pasien_id) REFERENCES pasien(id)
);

-- 11. Tabel login admin
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    nama VARCHAR(100)
);

-- 12. Tabel pengaturan klinik
CREATE TABLE pengaturan_klinik (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_klinik VARCHAR(100),
    alamat TEXT,
    logo VARCHAR(255),
    wallpaper VARCHAR(255)
);

-- 13. Tabel riwayat MCU (log semua kunjungan)
CREATE TABLE riwayat_mcu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pasien_id INT,
    tanggal_mcu DATE,
    catatan TEXT,
    FOREIGN KEY (pasien_id) REFERENCES pasien(id)
);
