<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $result = mysqli_query($koneksi, "SELECT * FROM jadwal WHERE id = $edit_id");
    $edit_data = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $lab_id = $_POST['lab_id'];
    $waktu_id = $_POST['waktu_id'];
    $matkul = $_POST['matkul'];
    $jurusan = $_POST['jurusan'];

    $query = "UPDATE jadwal SET lab_id = '$lab_id', waktu_id = '$waktu_id', mk = '$matkul', jurusan = '$jurusan' WHERE id = $edit_id";
    mysqli_query($koneksi, $query);
    header("Location: jadwal.php");
    exit();
}

$lab_list = mysqli_query($koneksi, "SELECT * FROM lab");
$waktu_list = mysqli_query($koneksi, "SELECT * FROM waktu");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Praktikum IF | 123230018</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="lab.php">Lab</a></li>
                <li class="nav-item"><a class="nav-link" href="waktu.php">Waktu</a></li>
                <li class="nav-item"><a class="nav-link active" href="jadwal.php">Jadwal</a></li>
            </ul>
            <span class="navbar-text"><a href="logout.php">Logout</a></span>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Ubah Jadwal Praktikum</h2>
                </div>
                <div class="card-body">
                    <p class="text-center">Buat jadwal praktikum sesuai dengan yang diinginkan</p>
                <br>
                    <form method="POST" action="edit_jadwal.php">
                        <input type="hidden" name="edit_id" value="<?= $edit_data['id'] ?>">
                        <div class="mb-3 d-flex align-items-center">
                                    <input type="text" class="form-control me-3" placeholder="Mata Kuliah" name="matkul" value="<?= $edit_data['mk'] ?>" required>
                                    <div class="d-flex align-items-center">
                                        <input type="radio" name="jurusan" value="IF" required class="me-1" <?= $edit_data['jurusan'] == 'IF' ? 'checked' : '' ?>> IF
                                        <input type="radio" name="jurusan" value="SI" required class="ms-2 me-1" value="SI" class="ms-3" <?= $edit_data['jurusan'] == 'SI' ? 'checked' : '' ?>> SI
                                    </div>
                        </div>
                        <div class="mb-3">
                            <select name="lab_id" class="form-control" required>
                                <?php while ($lab = mysqli_fetch_assoc($lab_list)) { ?>
                                    <option value="<?= $lab['id'] ?>" <?= $edit_data['lab_id'] == $lab['id'] ? 'selected' : '' ?>>
                                        <?= $lab['nama_lab'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <select name="waktu_id" class="form-control" required>
                                <?php while ($waktu = mysqli_fetch_assoc($waktu_list)) { ?>
                                    <option value="<?= $waktu['id'] ?>" <?= $edit_data['waktu_id'] == $waktu['id'] ? 'selected' : '' ?>>
                                        <?= $waktu['waktu_awal'] ?> - <?= $waktu['waktu_akhir'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update Jadwal</button>
                        <a href="jadwal.php" class="btn btn-secondary w-100 mt-2">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
