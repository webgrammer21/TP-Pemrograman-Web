<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Tambah Lab
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_lab'])) {
    $nama_lab = $_POST['nama_lab'];
    $query = "INSERT INTO lab (nama_lab) VALUES ('$nama_lab')";
    mysqli_query($koneksi, $query);
}

// Tampil dan Hapus Lab
$lab_list = mysqli_query($koneksi, "SELECT * FROM lab");

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($koneksi, "DELETE FROM lab WHERE id=$id");
    header("Location: lab.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu Lab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" href="lab.php">Lab</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="waktu.php">Waktu</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="jadwal.php">Jadwal</a>
                </li>
            </ul>
            <span class="navbar-text">
            <a href="logout.php">Logout</a>
            </span>
            </div>
        </div>
    </nav>
    <br>
    <div class="row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <div class="card">
                <div class="card-body">
                    <!-- Membuat Nama -->
                    <div class="text-center">
                        <h3>Menampilkan Data</h3>
                    </div>
                    <!-- Membuat Tabel Data -->
                    <table class="table table-info table-striped">
                        <thead class="table-primary text-center">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Lab</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($lab_list && mysqli_num_rows($lab_list) > 0) {
                                // Inisialisasi nomor urut
                                $no = 1;
                                while ($lab = mysqli_fetch_assoc($lab_list)) {
                                    echo "<tr class='text-center align-middle'>"; 
                                    echo "<td>" . $no++ . "</td>"; // Menampilkan nomor urut
                                    echo "<td>" . $lab['nama_lab'] . "</td>"; // Menampilkan nama lab
                                    echo "<td><a href='lab.php?delete=" . $lab['id'] . "' class='btn btn-danger btn-sm'>Hapus</a></td>"; // Action untuk hapus
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body text-center">
                    <div class="card-header">
                        <h2 class="card-title">Input Data Lab</h2>
                    </div>
                    <p>Masukkan Ruangan Lab yang Tersedia</p>
                    <form method="POST">
                        <input type="text" name="nama_lab" placeholder="Input Nama Lab" class="form-control mb-2 text-center" required>
                        <button type="submit" class="btn btn-primary">Tambah Lab</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
