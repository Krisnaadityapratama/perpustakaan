<?php
include 'koneksi.php';

if (isset($_POST['submit_pengunjung'])) {
    $nama = $_POST['nama_pengunjung'];
    $fakultas = $_POST['fakultas_pengunjung'];
    $prodi = $_POST['prodi_pengunjung'];
    $tanggal = date('Y-m-d');

    $sql = "INSERT INTO pengunjung (nama, fakultas, prodi, tanggal_kunjungan) VALUES ('$nama', '$fakultas', '$prodi', '$tanggal')";
    if ($conn->query($sql)) {
        echo "<script>alert('Data pengunjung berhasil disimpan.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan: " . $conn->error . "'); window.location.href='index.php';</script>";
    }
}

if (isset($_POST['submit_peminjaman'])) {
    $nama = $_POST['nama_peminjam'];
    $fakultas = $_POST['fakultas_peminjam'];
    $prodi = $_POST['prodi_peminjam'];
    $buku = $_POST['buku'];
    $tanggal = date('Y-m-d');

    $sql = "INSERT INTO peminjaman (nama, fakultas, prodi, buku, tanggal_peminjaman) VALUES ('$nama', '$fakultas', '$prodi', '$buku', '$tanggal')";
    if ($conn->query($sql)) {
        echo "<script>alert('Data peminjaman berhasil disimpan.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan: " . $conn->error . "'); window.location.href='index.php';</script>";
    }
}

?>
