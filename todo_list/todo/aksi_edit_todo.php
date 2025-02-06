<?php
include "../config.php";

$id = $_POST['id'];
$tugas = $_POST['tugas'];
$jangkawaktu = $_POST['jangkawaktu'];
$keterangan = $_POST['keterangan'];


if (!$mysqli) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}


$sql = "UPDATE tbtodo SET tugas = ?, jangkawaktu = ?, keterangan = ? WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sssi", $tugas, $jangkawaktu, $keterangan, $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        header("Location: ../index.php?halaman=todo&pesan_edit=berhasil");
    } else {
        header("Location: ../index.php?halaman=todo&pesan_edit=gagal");
    }
} else {
    header("Location: ../index.php?halaman=todo&pesan_edit=gagal");
}

$stmt->close();
$mysqli->close();
exit();
