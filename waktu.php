<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $waktu_awal = $_POST['waktu_awal'];
    $waktu_akhir = $_POST['waktu_akhir'];
    $query = "INSERT INTO waktu (waktu_awal, waktu_akhir) VALUES ('$waktu_awal', '$waktu_akhir')";
    mysqli_query($koneksi, $query);
}

$waktu_list = mysqli_query($koneksi, "SELECT * FROM waktu");

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($koneksi, "DELETE FROM waktu WHERE id=$id");
    header("Location: waktu.php");
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Waktu Lab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage == 'lab.php' ? 'active' : ''; ?>" href="lab.php">Lab</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage == 'waktu.php' ? 'active' : ''; ?>" href="waktu.php">Waktu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage == 'jadwal.php' ? 'active' : ''; ?>" href="jadwal.php">Jadwal</a>
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
                        <div class="text-center">
                            <h3>Menampilkan Waktu</h3>
                        </div>
                        <table class="table table-info table-striped">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Waktu</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($waktu_list && mysqli_num_rows($waktu_list) > 0) {
                                    $no = 1;
                                    while ($waktu = mysqli_fetch_assoc($waktu_list)) {
                                        echo "<tr class='text-center align-middle'>"; 
                                        echo "<td>" . $no++ . "</td>";
                                        echo "<td>" . $waktu['waktu_awal'] . " - " . $waktu['waktu_akhir']. "</td>";
                                        echo "<td><a href='waktu.php?delete=" . $waktu['id'] . "' class='btn btn-danger btn-sm'>Hapus</a></td>";
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
                            <h2 class="card-title">Input Waktu Praktikum</h2>
                        </div>
                        <p>Masukkan Waktu Pelaksanaan yang Tersedia</p>
                        <form method="POST">
                            <div class="row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="card-text">Waktu Awal</p>
                                            <input type="time" name="waktu_awal" placeholder="Input waktu awal" class="form-control mb-2 text-center" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="card-text">Waktu Akhir</p>
                                            <input type="time" name="waktu_akhir" placeholder="Input waktu akhir" class="form-control mb-2 text-center" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button type="submit" class="btn btn-primary">Tambah waktu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
