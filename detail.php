<?php
session_start();
require 'function.php';

// ambil data di URL
$idbarang = $_GET['id'];

// get informasi berdasarkan database
$get = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idbarang'");
$fetch = mysqli_fetch_assoc($get);
// set variable
$namaBarang = $fetch['namabarang'];
$deskripsi = $fetch['deskripsi'];
$stock = $fetch['stock'];
$img = $fetch['image'];

// session login
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$dataMasuk = mysqli_query($conn, "SELECT * FROM masuk WHERE idbarang='$idbarang'");
$dataKeluar = mysqli_query($conn, "SELECT * FROM keluar WHERE idbarang='$idbarang'");

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Stock - Detail Barang</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-secondary">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Hei.Hud</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="profil.php">My Profile</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                        <div class="sb-sidenav-menu-heading">Main</div>
                            <a class="nav-link active" href="index.php">
                                <div class="sb-nav-link-icon "><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fa-sharp fa-solid fa-inbox"></i></div>
                                Barang Masuk 
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-industry"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="pinjam.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-handshake"></i></div>
                                Pinjam Barang
                            </a>
                            <div class="sb-sidenav-menu-heading">User Profile</div>
                            <a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                                Kelola Admin
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                                Account
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="profil.php">My Profile</a>
                                    <a class="nav-link" href="logout.php">Logout</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <h6><?= $_SESSION['login']; ?></h6>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                <div class="container mt-5" style="width: 95%;">
                    <div class="card">
                        <div class="card-header bg-dark text-white fs-5 fw-semibold text-center">
                            Detail Barang
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3 text-center">
                                <img src="image/<?= $img;?>" alt="foto Barang" style="width: 300px;">
                            </div>
                            <table style="margin: 0 auto;">
                                <tr>
                                    <td>
                                        <div class="mb-3 d-flex">
                                        <label for="nim" class="form-label fs-5 fw-semibold ubah-label">Nama Barang </label>
                                        </div>
                                    </td>
                                    <td> 
                                        <input type="text" class="form-control  align-items-center" name="namabarang" id="namabarang" value="<?= $namaBarang; ?>" disabled style="margin-left: 20px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <div class="mb-3 d-flex">
                                        <label for="nama" class="form-label fs-5 fw-semibold ubah-label">Deskripsi </label>
                                    </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control align-items-center" name="deskripsi" id="deskripsi" value="<?= $deskripsi; ?>" disabled style="margin-left: 20px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    <div class="mb-3 d-flex">
                                        <label for="email" class="form-label fs-5 fw-semibold ubah-label">Stock Barang </label>
                                    </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control align-items-center" name="stock" id="stock" value="<?= $stock; ?>" disabled style="margin-left: 20px;">
                                    </td>
                                </tr>
                            </table>
                            <div class="mt-3">
                                <a href="index.php" type="button" class="btn btn-primary"">Kembali</a>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="table-responsive">
                                <h3>Barang Masuk</h3>
                                <table class="table table-striped table-hover" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;?>
                                        <?php foreach( $dataMasuk as $masuk ) : ?>
                                        <tr>
                                            <td><?= $i;?></td>
                                            <td><?= $masuk['tanggal']; ?></td>
                                            <td><?= $masuk['keterangan']; ?></td>
                                            <td><?= $masuk['qty']; ?></td>
                                        </tr>
                                        <?php $i++;?>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>

                                <h3>Barang Keluar</h3>
                                <table class="table table-striped table-hover" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Penerima</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;?>
                                        <?php foreach( $dataKeluar as $keluar ) : ?>
                                        <tr>
                                            <td><?= $i;?></td>
                                            <td><?= $keluar['tanggal']; ?></td>
                                            <td><?= $keluar['penerima']; ?></td>
                                            <td><?= $keluar['qty']; ?></td>
                                        </tr>
                                        <?php $i++;?>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Barang</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form enctype="multipart/form-data" method="post">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nim" class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" name="namabarang" id="namabarang" placeholder="masukkan nama barang" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Deskripsi</label>
                    <input type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="masukkan deskripsi barang" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Stock</label>
                    <input type="number" class="form-control" name="stock" id="stock" required>
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar</label>
                    <input type="file" class="form-control" name="gambar" id="gambar" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                <button type="submit" class="btn btn-primary" name="addnewbarang">Simpan</button>
            </div>
        </form>
        </div>
    </div>
    </div>
</html>
