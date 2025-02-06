<?php
include "../config.php";

if (isset($_POST['tugas']) && isset($_POST['jangkawaktu']) && isset($_POST['keterangan'])) {
    $tugas = mysqli_real_escape_string($mysqli, $_POST['tugas']);
    $jangka_waktu = mysqli_real_escape_string($mysqli, $_POST['jangkawaktu']);
    $keterangan = mysqli_real_escape_string($mysqli, $_POST['keterangan']);

    $sql = "INSERT INTO tbtodo (tugas, jangkawaktu, keterangan) VALUES ('$tugas', '$jangka_waktu', '$keterangan')";

    if (mysqli_query($mysqli, $sql)) {
        $r = mysqli_affected_rows($mysqli);
        if ($r > 0) {
            header("Location: ../index.php?halaman=todo&pesan_tambah=berhasil");
        } else {
            header("Location: ../index.php?halaman=todo&pesan_tambah=gagal");
        }
        exit();
    } else {

        header("Location: ../index.php?halaman=todo&status=gagal");
        exit();
    }
} else {

    header("Location: ../index.php?halaman=todo&status=kosong");
    exit();
}
