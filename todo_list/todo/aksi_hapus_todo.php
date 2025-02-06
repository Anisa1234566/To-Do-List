<?php
include "../config.php";
$sql = "DELETE FROM tbtodo WHERE  id = '$_GET[id]'";
//echo sql
mysqli_query($mysqli, $sql);
$r = mysqli_affected_rows($mysqli);
if ($r > 0) {
    header("Location: ../index.php?halaman=todo&pesan_hapus=berhasil");
} else {
    header("Location: ../index.php?halaman=todo&pesan_hapus=gagal");
}
