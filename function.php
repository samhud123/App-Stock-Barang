<?php
// membuat koneksi database
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "stockbarang";
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// registrasi user
function registrasi($data) {
    global $conn;
    $email = strtolower(stripcslashes($data['email']));
    $password = mysqli_real_escape_string($conn, $data['password']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);

    // cek ketersediaan username
    $result = mysqli_query($conn, "SELECT * FROM login WHERE email = '$email'");

    if (mysqli_fetch_assoc($result)) {
        echo "
                <script>
                    alert('username sudah terdaftar!');
                </script>
            ";
        return false;
    }

    // cek konfirmasi password
    if($password !== $password2) {
        echo "
                <script>
                    alert('Konfirmasi password tidak sesuai!');
                </script>
            ";
        return false;
    } 

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO login VALUES ('', '$email', '$password')");

    return mysqli_affected_rows($conn);
}

// update user
function updateUser($data) {
    global $conn;

    $iduser = $data['iduser'];
    $email = strtolower($data['email']);
    $password = mysqli_real_escape_string($conn, $data['ubahpassword']);

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // update user
    $hasil = mysqli_query($conn, "UPDATE login SET email='$email', password='$password' WHERE iduser='$iduser'");
    
    if($hasil) {
        echo "
            <script>
                alert('Data berhasil diubah!');   
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal di ubah!');
                window.location.href='admin.php';    
            </script>
        ";
    }
}

//hapus user
function deleteUser($data) {
    global $conn;

    $iduser = $data['iduser'];
    $hasil = mysqli_query($conn, "DELETE FROM login WHERE iduser='$iduser'");
    if($hasil){
        echo "
            <script>
                alert('Data berhasil dihapus!');   
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal dihapus!');
                window.location.href='admin.php';    
            </script>
        ";
    }
}

// tambah data barang
function tambah($data) {
    global $conn;

    // ambil data dari tiap-tiap elemen
    $namaBarang = htmlspecialchars($data['namabarang']);
    $deskripsi = htmlspecialchars($data['deskripsi']);
    $stock = $data['stock'];
    $gambar = uploadGambar();

    if(!$gambar) {
        echo "
            <script>
                alert('Pilih gambar terlebih d  ahulu!');
            </script>
        ";
        return false;
    }

    // query insert data
    $query = "INSERT INTO stock VALUES ('', '$namaBarang', '$deskripsi', '$stock', '$gambar')";

    $tambahBarang = mysqli_query($conn, $query);
    if($tambahBarang) {
        header('Location: index.php');
    } else {
        echo 'Gagal';
        header('Location: index.php');
    }
}

// upload gambar
function uploadGambar(){
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if($error === 4) {
        echo "
            <script>
                alert('Pilih gambar terlebih d  dahulu!');
            </script>
        ";
        return false;
    }

    // cek apakah yang diupload adalah gambar atau bukan
    $ekstensiGambarValid = ['jpg','jpeg','png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    
    if(!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
            <script>
                alert('Yang anda upload bukan gambar!');
            </script>
        ";
        return false;
    }

    // cek ukuran gambar
    if($ukuranFile > 1000000){
        echo "
            <script>
                alert('Ukuran gambar terlalu besar!');
            </script>
        ";
        return false;
    }

    // generate nama baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'image/'.$namaFileBaru);
    return $namaFileBaru;
}

// barang masuk
function barangMasuk($data) {
    global $conn;

    // ambil data dari tiap-tipa elemen
    $stockBarang = $data['stockbarang'];
    $penerima = htmlspecialchars($data['penerima']);
    $qty = $data['qty'];

    // stock barang
    $cekStockSekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$stockBarang'");
    $getDataBarang = mysqli_fetch_array($cekStockSekarang);

    $stockSekarang = $getDataBarang['stock'];
    $namaBarang = $getDataBarang['namabarang'];
    $totalStock = $stockSekarang + $qty;

    $updateStock = mysqli_query($conn, "UPDATE stock SET stock='$totalStock' WHERE idbarang='$stockBarang'");

    // query insert data
    $query = "INSERT INTO masuk (idbarang, namabarang, keterangan, qty) VALUES ('$stockBarang', '$namaBarang', '$penerima', '$qty')";

    $addBarangMasuk = mysqli_query($conn, $query);

    if($addBarangMasuk && $updateStock) {
        header('Location: masuk.php');
    } else {
        echo 'Gagal';
        header('Location: masuk.php');
    }
}

//barang keluar 
function barangKeluar($data) {
    global $conn;

    // ambil data dari tiap-tipa elemen
    $stockBarang = $data['stockbarang'];
    $penerima = htmlspecialchars($data['penerima']);
    $qty = $data['qty'];

    // stock barang
    $cekStockSekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$stockBarang'");
    $getDataBarang = mysqli_fetch_array($cekStockSekarang);

    $stockSekarang = $getDataBarang['stock'];
    $namaBarang = $getDataBarang['namabarang'];

    if($stockSekarang >= $qty) {
        // jika barang keluar tersedia
        $totalStock = $stockSekarang - $qty;
        $updateStock = mysqli_query($conn, "UPDATE stock SET stock='$totalStock' WHERE idbarang='$stockBarang'");

        // query insert data
        $query = "INSERT INTO keluar (idbarang, namabarang, penerima, qty) VALUES ('$stockBarang', '$namaBarang', '$penerima', '$qty')";

        $addBarangKeluar = mysqli_query($conn, $query);

        if($addBarangKeluar && $updateStock) {
            header('Location: keluar.php');
        } else {
            echo 'Gagal';
            header('Location: keluar.php');
        }
    } else {
        // jika barang keluar tidak tersedia
        echo "
            <script>
                alert('Stock saat ini tidak mencukupi');
                window.location.href='keluar.php';    
            </script>
        ";
    }
}

// update barang
function editBarang($data) {
    global $conn;

    // ambil data dari tiap tiap elemen
    $idBarang = $data['idb'];
    $namaBarang = htmlspecialchars($data['namabarang']);
    $deskripsi = htmlspecialchars($data['deskripsi']);
    $gambarLama = $data['gambar'];

    // cek apakah user pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = uploadGambar();
    }

    // query insert data
    $query = "UPDATE stock SET 
                namabarang = '$namaBarang',
                deskripsi = '$deskripsi',
                image = '$gambar'
            WHERE idbarang = $idBarang
            ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// hapus barang
function hapusBarang($data) {
    global $conn;

    $id = $data['idb'];

    $gambar = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$id'");
    $get = mysqli_fetch_array($gambar);
    $img = 'image/'.$get['image'];
    unlink($img);
    
    mysqli_query($conn, "DELETE FROM stock WHERE idbarang = $id");
    return mysqli_affected_rows($conn);
}

// update barang masuk
function updateBarangMasuk($data) {
    global $conn;

    // ambil data dari tiap-tiap elemen
    $idb = $data['idbarang'];
    $idm = $data['idmasuk'];
    $namaBarang = htmlspecialchars($data['namabarang']);
    $keterangan = htmlspecialchars($data['keterangan']);
    $qty = $data['qty'];

    $lihatStock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang = '$idb'");
    $stock = mysqli_fetch_array($lihatStock);
    $stockSekarang = $stock['stock'];

    $lihatQty = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk = '$idm'");
    $qtynya = mysqli_fetch_array($lihatQty);
    $qtyskrng = $qtynya['qty'];

    if($qty > $qtyskrng) {
        $selisih = $qty - $qtyskrng;
        $kurangin = $stockSekarang + $selisih;
        $kurangiStock = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET namabarang='$namaBarang', qty='$qty', keterangan='$keterangan' WHERE idmasuk='$idm' ");
            if($kurangiStock && $updatenya) {
                header('Location: masuk.php');
            } else {
                echo 'Gagal';
                header('Location: masuk.php');
            }
    } else {
        $selisih = $qtyskrng - $qty;
        $kurangin = $stockSekarang - $selisih;
        $kurangiStock = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE masuk SET namabarang='$namaBarang', qty='$qty', keterangan='$keterangan' WHERE idmasuk='$idm' ");
            if($kurangiStock && $updatenya) {
                header('Location: masuk.php');
            } else {
                echo 'Gagal';
                header('Location: masuk.php');
            }
    }
}

// hapus barang masuk
function hapusBarangMasuk($data){
    global $conn;

    // ambil data 
    $idm = $data['idm'];
    $idb = $data['idb'];
    $qty = $data['qty'];

    $getDataStock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $row = mysqli_fetch_array($getDataStock);
    $stock = $row['stock'];

    $selisih = $stock-$qty;

    $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
    $hapusData = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk='$idm'");
    if($update && $hapusData) {
        header('Location: masuk.php');
    } else {
        echo 'Gagal';
        header('Location: masuk.php');
    }
}

// update barang keluar
function updateBarangKeluar($data) {
    global $conn;

    // ambil data dari tiap-tiap elemen
    $idb = $data['idbarang'];
    $idk = $data['idkeluar'];
    $namaBarang = htmlspecialchars($data['namabarang']);
    $penerima = htmlspecialchars($data['penerima']);
    $qty = $data['qty'];

    $lihatStock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang = '$idb'");
    $stock = mysqli_fetch_array($lihatStock);
    $stockSekarang = $stock['stock'];

    $lihatQty = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar = '$idk'");
    $qtynya = mysqli_fetch_array($lihatQty);
    $qtyskrng = $qtynya['qty'];

    if($qty > $qtyskrng) {
        $selisih = $qty - $qtyskrng;
        $kurangin = $stockSekarang - $selisih;
        $kurangiStock = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE keluar SET namabarang='$namaBarang', qty='$qty', penerima='$penerima' WHERE idkeluar='$idk' ");
            if($kurangiStock && $updatenya) {
                header('Location: keluar.php');
            } else {
                echo 'Gagal';
                header('Location: keluar.php');
            }
    } else {
        $selisih = $qtyskrng - $qty;
        $kurangin = $stockSekarang + $selisih;
        $kurangiStock = mysqli_query($conn, "UPDATE stock SET stock='$kurangin' WHERE idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE keluar SET namabarang='$namaBarang', qty='$qty', penerima='$penerima' WHERE idkeluar='$idk' ");
            if($kurangiStock && $updatenya) {
                header('Location: keluar.php');
            } else {
                echo 'Gagal';
                header('Location: keluar.php');
            }
    }
}

// hapus barang keluar
function hapusBarangKeluar($data){
    global $conn;

    // ambil data 
    $idk = $data['idk'];
    $idb = $data['idb'];
    $qty = $data['qty'];

    $getDataStock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $row = mysqli_fetch_array($getDataStock);
    $stock = $row['stock'];

    $selisih = $stock+$qty;

    $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idb'");
    $hapusData = mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar='$idk'");
    if($update && $hapusData) {
        header('Location: keluar.php');
    } else {
        echo 'Gagal';
        header('Location: keluar.php');
    }
}

function cariTanggalMasuk($data){
    global $conn;
    $mulai = $data['tgl_mulai'];
    $selesai = $data['tgl_selesai'];

    if($mulai != null || $selesai != null) {
        $query = mysqli_query($conn, "SELECT * FROM masuk WHERE tanggal BETWEEN '$mulai' and DATE_ADD('$selesai', INTERVAL 1 DAY) ORDER BY idmasuk DESC");
    } else {
        $query = mysqli_query($conn, "SELECT * FROM masuk");
    }

    return $query;
}

function cariTanggalKeluar($data){
    global $conn;
    $mulai = $data['tgl_mulai'];
    $selesai = $data['tgl_selesai'];

    if($mulai != null || $selesai != null) {
        $query = mysqli_query($conn, "SELECT * FROM keluar WHERE tanggal BETWEEN '$mulai' and DATE_ADD('$selesai', INTERVAL 1 DAY) ORDER BY idkeluar DESC");
    } else {
        $query = mysqli_query($conn, "SELECT * FROM keluar");
    }

    return $query;
}

function cariTanggalPinjam($data){
    global $conn;
    $mulai = $data['tgl_mulai'];
    $selesai = $data['tgl_selesai'];

    if($mulai != null || $selesai != null) {
        $query = mysqli_query($conn, "SELECT * FROM peminjaman WHERE tanggalpinjam BETWEEN '$mulai' and DATE_ADD('$selesai', INTERVAL 1 DAY) ORDER BY idpeminjaman DESC");
    } else {
        $query = mysqli_query($conn, "SELECT * FROM peminjaman");
    }

    return $query;
}

// tambah data peminjam
function tambahPeminjam($data){
    global $conn;

    $idBarang = $data['stockbarang'];
    $qty = $data['qty'];
    $peminjam = $data['peminjam'];

    $getDataStock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idBarang'");
    $row = mysqli_fetch_array($getDataStock);
    $stock = $row['stock'];

    if($qty > $stock){
        echo "
            <script>
                alert('Stock Barang tidak mencukupi');
                window.location.href='pinjam.php';    
            </script>
        ";
    } else {
        $selisih = $stock - $qty;
        $updateStock = mysqli_query($conn, "UPDATE stock SET stock='$selisih' WHERE idbarang='$idBarang'");
        $insertData = mysqli_query($conn, "INSERT INTO peminjaman (idbarang, qty, peminjam) VALUES ('$idBarang','$qty','$peminjam')");

        if($updateStock && $insertData){
            header("Location:pinjam.php");
        } else {
            echo "
                <script>
                    alert('Data Gagal Ditambahkan !');
                    window.location.href='pinjam.php';    
                </script>
            ";
        }
    }
}

// selesai peminjaman
function selesaiPinjam($data){
    global $conn;

    $idPeminjam = $data['idpeminjaman'];
    $idBarang = $data['idbarang'];
    $qty = $data['qty'];
    $status = 'Kembali';

    // ambil data stock
    $getDataStock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idBarang'");
    $row = mysqli_fetch_array($getDataStock);
    $stock = $row['stock'];

    $jmlAllStock = $stock + $qty;

    $updateStatus = mysqli_query($conn, "UPDATE peminjaman SET status='$status' WHERE idpeminjaman='$idPeminjam'");
    $updateStock = mysqli_query($conn, "UPDATE stock SET stock='$jmlAllStock' WHERE idbarang='$idBarang'");
    if($updateStatus && $updateStock){
        header("Location:pinjam.php");
    } else {
        echo "
            <script>
                alert('Data Gagal Di Ubah !');
                window.location.href='pinjam.php';    
            </script>
        ";
    }
}

?>