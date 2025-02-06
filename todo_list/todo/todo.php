<?php
include "config.php";

$limit = 5;
$start = isset($_GET['start']) ? (int)$_GET['start'] : 0;

$sql = "SELECT * FROM tbtodo";


if (isset($_POST['cari']) && !empty(trim($_POST['cari']))) {
    $cari = mysqli_real_escape_string($mysqli, trim($_POST['cari']));
    $sql = "SELECT * FROM tbtodo WHERE tugas LIKE '%$cari%'";
} else {

    $sql .= " LIMIT $start, $limit";
}

$hasil = mysqli_query($mysqli, $sql);
if (!$hasil) {
    die("Error dalam query: " . mysqli_error($mysqli));
}


if (!isset($_POST['cari']) || empty(trim($_POST['cari']))) {
    $sql2 = "SELECT COUNT(*) as total FROM tbtodo";
    $hasil2 = mysqli_query($mysqli, $sql2);
    $row = mysqli_fetch_assoc($hasil2);
    $jlhdata = $row['total'];
} else {
    $jlhdata = mysqli_num_rows($hasil);
}

$perulangan = ceil($jlhdata / $limit);
?>

<?php
if (isset($_GET['pesan_tambah'])) {
?>
    <div class="alert alert-<?php echo $_GET['pesan_tambah'] == 'berhasil' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
        <strong><?php echo $_GET['pesan_tambah'] == 'berhasil' ? 'Berhasil' : 'Gagal'; ?> ditambah!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
if (isset($_GET['pesan_edit'])) {
?>
    <div class="alert alert-<?php echo $_GET['pesan_edit'] == 'berhasil' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
        <strong><?php echo $_GET['pesan_edit'] == 'berhasil' ? 'Berhasil' : 'Gagal'; ?> diedit!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
if (isset($_GET['pesan_hapus'])) {
?>
    <div class="alert alert-<?php echo $_GET['pesan_hapus'] == 'berhasil' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
        <strong><?php echo $_GET['pesan_hapus'] == 'berhasil' ? 'Berhasil' : 'Gagal'; ?> dihapus!</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>



<br>
<br>
<h2>My To-Do List</h2>

<!-- Button trigger modal -->
<button style="float: right;" type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
    <i class="fa fa-plus">Tambah</i>
</button>
<br>

<form action="index.php?halaman=todo" method="POST">
    <div class="row d-flex justify-content-end mb-2">
        <div class="col-2">
            <input type="text" name="cari" class="col-12 form-control">
        </div>
        <div class="col-1">
            <button type="submit" class="col-10 form-control">
                cari

            </button>
        </div>
    </div>
</form>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-body" id="exampleModalLabel">Tambah Tugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="todo/aksi_tambah_todo.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-body">Tugas</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="tugas" name="tugas">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-body">Jangka Waktu</label>
                        <input type="date" class="form-control" id="exampleFormControlInput1" placeholder="jangka waktu" name="jangkawaktu">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-body">Keterangan</label>
                        <select class="form-control" name="keterangan">
                            <option>Belum Selesai</option>
                            <option>Selesai</option>

                        </select>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<div class="d-flex justify-content-center">
    <table border="1" class="table table-bordered teks-putih">
        <thead>

            <tr>
                <td>No</td>
                <td>Tugas</td>
                <td>Jangka Waktu</td>
                <td>Keterangan</td>
                <td>Aksi</td>
            </tr>
        </thead>
        <tbody>

            <?php
            $no = 1;
            while ($row = mysqli_fetch_array($hasil)) {
                echo "<tr>
 <td>$no</td><td>$row[tugas]</td><td>$row[jangkawaktu]</td><td>$row[keterangan]</td>
 <td>
 <a class='btn btn-warning fa fa-pencil' href='index.php?halaman=edit_todo&id=$row[id]'> Edit</a>" ?>
                <a class='btn btn-danger fa fa-trash' href='todo/aksi_hapus_todo.php?id=<?= $row['id'] ?>'
                    onclick='return confirm("are you sure?")'> Hapus</a>
                </td>

            <?php
                echo
                "</tr>";
                $no++;
            }
            ?>

        </tbody>
    </table>



</div>
<?php if (isset($_POST['cari']) && !empty(trim($_POST['cari']))) { ?>
    <div class="d-flex justify-content-right mb-2">
        <a href="index.php?halaman=todo" class="btn btn-primary border-light text-light px-3">
            <i class="fa fa-arrow-left"></i> Kembali ke Daftar Tugas
        </a>
    </div>
<?php } ?>


<div class="d-flex justify-content-end">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?= $start == 0 ? 'disabled' : '' ?>">
                <a class="page-link" href="index.php?halaman=todo&start=<?= max(0, $start - $limit) ?>">Previous</a>
            </li>
            <?php
            for ($i = 0, $page = 0; $i < ceil($jlhdata / $limit); $i++, $page += $limit) {
            ?>
                <li class="page-item <?= ($start == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="index.php?halaman=todo&start=<?= $page ?>"><?= $i + 1 ?></a>
                </li>
            <?php
            }
            ?>
            <li class="page-item <?= $start + $limit >= $jlhdata ? 'disabled' : '' ?>">
                <a class="page-link" href="index.php?halaman=todo&start=<?= min($start + $limit, $jlhdata - $limit) ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>