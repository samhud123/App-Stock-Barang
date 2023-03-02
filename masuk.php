<?php
session_start();
require 'function.php';

if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// jika barang masuk di klik
if (isset($_POST['barangmasuk'])) {
    barangMasuk($_POST);
}

// jika update barang masuk di klik
if(isset($_POST['updatebarangmasuk'])){
    updateBarangMasuk($_POST);
}

// jika hapus barang masuk di klik
if(isset($_POST['hapusbarangmasuk'])){
    hapusBarangMasuk($_POST);
}

$stockBarang = mysqli_query($conn, "SELECT * FROM masuk");

// cari tanggal
if(isset($_POST['filter_tgl'])){
    $stockBarang = cariTanggalMasuk($_POST);
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang Masuk</title>
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
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link active" href="masuk.php" >
                                <div class="sb-nav-link-icon"><i class="fa-sharp fa-solid fa-inbox"></i></div>
                                Barang Masuk 
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-industry"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="pinjam.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-handshake"></i></i></div>
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
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Barang Masuk</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <i class="fa-solid fa-circle-plus"></i> Tambah Data
                                </button>
                                <a href="export_masuk.php" class="btn btn-success"><i class="fa-solid fa-print"></i> Cetak Data</a>
                                <br>
                                <div class="row mt-3 mb-2">
                                    <div class="col">
                                        <form method="post">
                                            <table>
                                                <tr>
                                                    <td><input type="date" name="tgl_mulai" class="form-control"></td>
                                                    <td><input type="date" name="tgl_selesai" class="form-control" style="margin-left: 5px;"></td>
                                                    <td><button type="submit" name="filter_tgl" class="btn btn-info" style="margin-left: 10px;">Filter</button></td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatablesSimple" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;?>
                                            <?php foreach($stockBarang as $row) : ?>
                                            <tr>
                                                <td><?= $i;?></td>
                                                <td><?= $row['tanggal']; ?></td>
                                                <td><?= $row['namabarang']; ?></td>
                                                <td><?= $row['qty']; ?></td>
                                                <td><?= $row['keterangan']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $row['idmasuk']; ?>">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <input type="hidden" name="idmasuk" value="<?= $row['idmasuk']; ?>">
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['idmasuk']; ?>">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit Barang-->
                                            <div class="modal fade" id="edit<?= $row['idmasuk'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Barang</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="" method="post">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="nim" class="form-label">Nama Barang</label>
                                                                <input type="text" class="form-control" name="namabarang" id="namabarang" value="<?= $row['namabarang']; ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nim" class="form-label">Keterangan</label>
                                                                <input type="text" class="form-control" name="keterangan" id="keterangan" value="<?= $row['keterangan']; ?>" required>
                                                            </div>
                                                            <input type="hidden" name="idmasuk" value="<?= $row['idmasuk']; ?>">
                                                            <input type="hidden" name="idbarang" value="<?= $row['idbarang']; ?>">
                                                            <div class="mb-3">
                                                                <label for="nama" class="form-label">Quantity</label>
                                                                <input type="number" class="form-control" name="qty" id="qty" value="<?= $row['qty']; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                                                            <button type="submit" class="btn btn-primary" name="updatebarangmasuk">Upate</button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                </div>
                                                </div>

                                                <!-- Modal Hapus Barang-->
                                            <div class="modal fade" id="hapus<?= $row['idmasuk'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Barang</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="post">
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus <?= $row['namabarang']; ?>
                                                        <input type="hidden" name="idm" value="<?= $row['idmasuk']; ?>">
                                                        <input type="hidden" name="idb" value="<?= $row['idbarang']; ?>">
                                                        <input type="hidden" name="qty" value="<?= $row['qty']; ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tidak</button>
                                                        <button type="submit" class="btn btn-danger" name="hapusbarangmasuk">Hapus</button>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                            </div>

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
        <form action="" method="post">
            <div class="modal-body">
                <div class="mb-3">
                    <label for="prodi" class="form-label">Nama Barang</label>
                    <select class="form-select" name="stockbarang" id="select" required>
                        <?php 
                            $allData = mysqli_query($conn, "SELECT * FROM stock");
                            while($fetchArray = mysqli_fetch_array($allData)) {
                                $namaBarang = $fetchArray['namabarang'];
                                $idBarang = $fetchArray['idbarang'];
                        ?>

                        <option value="<?= $idBarang; ?>"><?= $namaBarang; ?></option>

                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Quantity</label>
                    <input type="number" class="form-control" name="qty" id="qty" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Penerima</label>
                    <input type="text" class="form-control" name="penerima" id="penerima" placeholder="masukkan penerima barang" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                <button type="submit" class="btn btn-primary" name="barangmasuk">Simpan</button>
            </div>
        </form>
        </div>
    </div>
    </div>
</html>
