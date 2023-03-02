<?php
session_start();
require 'function.php';

if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// cari tanggal
if(isset($_POST['filter_tgl'])){
    $stockBarang = cariTanggalPinjam($_POST);
}

// tambah data peminjam
if(isset($_POST['tambahPeminjam'])){
    tambahPeminjam($_POST);
}

// barang kembali
if(isset($_POST['barangkembali'])){
    selesaiPinjam($_POST);
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
        <title>Pinjam Barang</title>
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
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fa-sharp fa-solid fa-inbox"></i></div>
                                Barang Masuk 
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-industry"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link active" href="pinjam.php">
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
                        <h1 class="mt-4">Peminjaman Barang</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <i class="fa-solid fa-circle-plus"></i> Tambah Data
                                </button>
                                <a href="export_pinjam.php" class="btn btn-success"><i class="fa-solid fa-print"></i> Cetak Data</a>
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
                                                <th>Gambar</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Kepada</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php $getDataPeminjam = mysqli_query($conn, "SELECT * FROM peminjaman"); ?>
                                            <?php $i=1;?>
                                            <?php
                                                while($dataPeminjam = mysqli_fetch_array($getDataPeminjam)) {
                                                    $idBarang = $dataPeminjam['idbarang'];
                                                    $idpinjam = $dataPeminjam['idpeminjaman'];
    
                                                    $getDataStock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idBarang'");
                                                    $dataStock = mysqli_fetch_assoc($getDataStock);
                                            ?>

                                            <tr>
                                                <td><?= $i;?></td>
                                                <td><?= $dataPeminjam['tanggalpinjam']; ?></td>
                                                <td><img src="image/<?= $dataStock['image']; ?>" alt="gambar barang" width="100"></td>
                                                <td><?= $dataStock['namabarang']; ?></td>
                                                <td><?= $dataPeminjam['qty']; ?></td>
                                                <td><?= $dataPeminjam['peminjam']; ?></td>
                                                <td><?= $dataPeminjam['status']; ?></td>
                                                <td>
                                                    <?php
                                                        if($dataPeminjam['status'] == 'Dipinjam'){
                                                            echo '
                                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit'.$idpinjam.'">
                                                                    Selesai
                                                                </button>
                                                            ';
                                                        } else {
                                                            echo '
                                                                <button type="button" class="btn btn-primary disabled" data-bs-toggle="modal" data-bs-target="#edit'.$idpinjam.'">
                                                                    Ok
                                                                </button>
                                                            ';
                                                        }
                                                    ?>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit Barang-->
                                            <div class="modal fade" id="edit<?= $dataPeminjam['idpeminjaman'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Selesaikan</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="" method="post">
                                                            <div class="modal-body">
                                                                <p>Apakah barang ini sudah selesai dipinjam?</p>
                                                                <input type="hidden" name="idpeminjaman" value="<?= $dataPeminjam['idpeminjaman']; ?>">
                                                                <input type="hidden" name="idbarang" value="<?= $dataPeminjam['idbarang']; ?>">
                                                                <input type="hidden" name="qty" value="<?= $dataPeminjam['qty']; ?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                                                                <button type="submit" class="btn btn-primary" name="barangkembali">Iya</button>
                                                            </div>
                                                        </form>
                                                        </div>
                                                    </div>
                                                    </div>

                                            <?php $i++;?>
                                            <?php
                                                }
                                            ?>

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
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Peminjam</h1>
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
                    <label for="nama" class="form-label">Kepada</label>
                    <input type="text" class="form-control" name="peminjam" id="peminjam" placeholder="masukkan nama peminjam" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                <button type="submit" class="btn btn-primary" name="tambahPeminjam">Simpan</button>
            </div>
        </form>
        </div>
    </div>
    </div>
</html>
