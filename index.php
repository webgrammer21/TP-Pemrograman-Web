<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar bg-primary border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand">Praktikum IF | 123230018</a>
            <form class="d-flex" role="search">
            <span class="navbar-text">
                <a href="logout.php">Logout</a>
            </span>
            </form>
        </div>
    </nav>
    <div class="card">
        <div class="card-body text-center">
            <h5>Selamat Datang di</h5>
            <h2>Praktikum Informatika</h2>
        </div>

        <div class="row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="Lab.php" class="btn btn-primary"><button class="btn btn-primary" type="button">Lab</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="waktu.php" class="btn btn-primary"><button class="btn btn-primary" type="button">Waktu Praktikum</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-grid gap-2 col-sm-6 mx-auto">
                <a href="jadwal.php" class="btn btn-primary"><button class="btn btn-primary" type="button">Jadwal Praktikum</button></a>
            </div>
            <br>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
