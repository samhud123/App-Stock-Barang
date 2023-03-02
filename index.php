<?php
session_start();
require 'function.php';

// session login
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// jika tombol tambah barang di klik
if(isset($_POST['addnewbarang'])) {
    tambah($_POST);
}

// edit barang
if (isset($_POST['updatebarang'])){
    editBarang($_POST);
}

// hapus barang
if(isset($_POST['hapusbarang'])) {
    hapusBarang($_POST);
}

// ambil jumlah data stock barang
$stockBarang = mysqli_query($conn, "SELECT * FROM stock");
$count1 = mysqli_num_rows($stockBarang);

// ambil jumlah data masuk
$get2 = mysqli_query($conn, "SELECT * FROM masuk");
$count2 = mysqli_num_rows($get2);

// ambil jumlah data keluar
$get3 = mysqli_query($conn, "SELECT * FROM keluar");
$count3 = mysqli_num_rows($get3);

// ambil jumlah data pinjam
$get4 = mysqli_query($conn, "SELECT * FROM peminjaman");
$count4 = mysqli_num_rows($get4);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Stock Barang</title>
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
                        <h1 class="mt-4">Stock Barang</h1>

                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body"><h5>Total Stock : <?= $count1;?></h5></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="index.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body"><h5>Barang Masuk : <?= $count2;?></h5></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="masuk.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body"><h5>Barang Keluar : <?= $count3;?></h5></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="keluar.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body"><h5>Barang Dipinjam : <?= $count4;?></h5></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="pinjam.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <i class="fa-solid fa-circle-plus"></i> Tambah Data
                                </button>
                                <a href="export.php" class="btn btn-success"><i class="fa-solid fa-print"></i> Cetak Data</a>
                            </div>
                            <div class="card-body">

                                <?php $ambilDataStock = mysqli_query($conn, "SELECT * FROM stock WHERE stock < 1");?>
                                <?php while($fetch = mysqli_fetch_array($ambilDataStock)) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show" id="liveAlertPlaceholder" role="alert">
                                        <strong>Perhatian!</strong> Stock barang <?= $fetch['namabarang'];?> telah habis
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                <?php endwhile; ?>
                                
                                <div class="table-responsive">
                                    <table id="datatablesSimple" class="table table-striped table-hover" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Gambar</th>
                                                <th>Nama Barang</th>
                                                <th>Deskripsi</th>
                                                <th>Stock</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;?>
                                            <?php foreach($stockBarang as $row) : ?>
                                            <tr>
                                                <td><?= $i;?></td>
                                                <td><img src="image/<?= $row['image'] ?>" alt="" width="100"></td>
                                                <td><?= $row['namabarang']; ?></td>
                                                <td><?= $row['deskripsi']; ?></td>
                                                <td><?= $row['stock']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $row['idbarang']; ?>">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <input type="hidden" name="idbarang" value="<?= $row['idbarang']; ?>">
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $row['idbarang']; ?>">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                    <a href="detail.php?id=<?= $row['idbarang'] ?>" class="btn btn-primary">
                                                    <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit Barang-->
                                            <div class="modal fade" id="edit<?= $row['idbarang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Barang</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form enctype="multipart/form-data" method="post">
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="nim" class="form-label">Nama Barang</label>
                                                            <input type="text" class="form-control" name="namabarang" id="namabarang" value="<?= $row['namabarang']; ?>" required>
                                                        </div>
                                                        <input type="hidden" name="idb" value="<?= $row['idbarang']; ?>">
                                                        <div class="mb-3">
                                                            <label for="nama" class="form-label">Deskripsi</label>
                                                            <input type="text" class="form-control" name="deskripsi" id="deskripsi" value="<?= $row['deskripsi']; ?>" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="gambar" class="form-label">Gambar</label>
                                                            <input type="file" class="form-control" name="gambar" id="gambar">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                                                        <button type="submit" class="btn btn-primary" name="updatebarang">Upate</button>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                            </div>

                                            <!-- Modal Hapus Barang-->
                                            <div class="modal fade" id="hapus<?= $row['idbarang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Barang</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="post">
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus <?= $row['namabarang']; ?>
                                                        <input type="hidden" name="idb" value="<?= $row['idbarang']; ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tidak</button>
                                                        <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
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
