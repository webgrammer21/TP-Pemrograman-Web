<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Mendapatkan data lab dan waktu
$lab_list = mysqli_query($koneksi, "SELECT * FROM lab");
$waktu_list = mysqli_query($koneksi, "SELECT * FROM waktu");

// Menangani Tambah Jadwal Baru
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['edit_id'])) {
    $lab_id = $_POST['lab_id'];
    $waktu_id = $_POST['waktu_id'];
    $matkul = $_POST['matkul'];
    $jurusan = $_POST['jurusan'];

    $query = "INSERT INTO jadwal (lab_id, waktu_id, mk, jurusan) VALUES ('$lab_id', '$waktu_id', '$matkul', '$jurusan')";
    mysqli_query($koneksi, $query);
    header("Location: jadwal.php");
    exit();
}

// Mendapatkan data jadwal untuk ditampilkan
$jadwal_list = mysqli_query($koneksi, "
    SELECT mk, jurusan, jadwal.id, lab.nama_lab, waktu.waktu_awal, waktu.waktu_akhir 
    FROM jadwal 
    JOIN lab ON jadwal.lab_id = lab.id 
    JOIN waktu ON jadwal.waktu_id = waktu.id
");

// Menangani Hapus Jadwal
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($koneksi, "DELETE FROM jadwal WHERE id = $id");
    header("Location: jadwal.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal Lab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Prakktikum IF | 123230018</a>
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
    <br>
        <div class="row">
            <!-- Menampilkan Daftar Jadwal -->
            <div class="col-sm-6 mb-3 mb-sm-0">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h3>Daftar Jadwal</h3>
                        </div>
                        <br>
                        <table class="table table-info table-striped">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>No</th>
                                    <th>MK Praktikum</th>
                                    <th>Jurusan</th>
                                    <th>Lab</th>
                                    <th>Waktu</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; while ($row = mysqli_fetch_assoc($jadwal_list)) { ?>
                                <tr class="text-center align-middle"> <!-- Tambahkan kelas text-center dan align-middle -->
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['mk'] ?></td>
                                    <td><?= $row['jurusan'] ?></td>
                                    <td><?= $row['nama_lab'] ?></td>
                                    <td><?= $row['waktu_awal'] ?> - <?= $row['waktu_akhir'] ?></td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="edit_jadwal.php?edit=<?= $row['id'] ?>">Edit</a>
                                        <a class="btn btn-danger btn-sm" href="jadwal.php?delete=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus jadwal ini?')">Hapus</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Form Tambah Jadwal -->
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="card-header">
                            <h2 class="card-title">Input Waktu Praktikum</h2>
                        </div>
                        <p>Buat jadwal praktikum sesuai dengan yang diinginkan</p>
                        <br>
                        <form method="POST">
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <input type="text" class="form-control me-3" placeholder="Mata Kuliah" name="matkul" required>
                                    <div class="d-flex align-items-center">
                                        <input type="radio" name="jurusan" value="IF" required class="me-1"> IF
                                        <input type="radio" name="jurusan" value="SI" required class="ms-2 me-1"> SI
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <select name="lab_id" class="form-control" required>
                                    <?php while ($lab = mysqli_fetch_assoc($lab_list)) { ?>
                                        <option value="<?= $lab['id'] ?>"><?= $lab['nama_lab'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="waktu_id" class="form-control" required>
                                    <?php while ($waktu = mysqli_fetch_assoc($waktu_list)) { ?>
                                        <option value="<?= $waktu['id'] ?>"><?= $waktu['waktu_awal'] ?> - <?= $waktu['waktu_akhir'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah Jadwal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
