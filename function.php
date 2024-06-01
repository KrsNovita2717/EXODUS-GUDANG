<?php
session_start();

// FUNCTION MEMBUAT KONEKSI KE DATABASE
function getConnection()
{
    if (!isset($_SESSION['db_user']) || !isset($_SESSION['db_pass'])) {
        $koneksi = mysqli_connect('localhost', 'root', '', 'exodus_gd');
    } else {
        $username = $_SESSION['db_user'];
        $password = $_SESSION['db_pass'];
        $koneksi = mysqli_connect('localhost', $username, $password, 'exodus_gd');
    }

    if ($koneksi->connect_error) {
        throw new Exception("Database connection failed: " . $koneksi->connect_error);
    }

    return $koneksi;
}

$koneksi = getConnection();

// FUNCTION UNTUK MENDAPATKAN KONTEN UTAMA
function getPageContent()
{
    $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
    switch ($page) {
        case 'distributor':
            return './pages/distributor.php';
        case 'jenis':
            return './pages/jenis.php';
        case 'masuk':
            return './pages/masuk.php';
        case 'keluar':
            return './pages/keluar.php';
        case 'laporan_transaksi':
            return './pages/laporan_transaksi.php';
        case 'pekerja':
            return './pages/pekerja.php';
        default:
            return './pages/dashboard.php';
    }
}

// UNTUK MELAKUKAN LOGIN
if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $password = $_POST['pass'];

    $cekdb = mysqli_query($koneksi, "SELECT * FROM login JOIN pekerja ON login.id_pekerja = pekerja.id_pekerja WHERE username='$user' AND pass_admin='$password'");
    $data = mysqli_fetch_array($cekdb);

    // PEMBERIAN HAK AKSES
    if ($data) {
        $_SESSION['log_in'] = true;
        $_SESSION['nama_pekerja'] = $data['nama_pekerja'];
        $_SESSION['id_pekerja'] = $data['id_pekerja'];
        $_SESSION['jabatan'] = $data['jabatan'];

        if ($_SESSION['jabatan'] == 'Kepala') {
            $_SESSION['db_user'] = 'kepala_gudang';
            $_SESSION['db_pass'] = 'ex0dushead';
        } else {
            $_SESSION['db_user'] = 'staff_gudang';
            $_SESSION['db_pass'] = 'ex0dusstaff';
        }

        $koneksi = getConnection();
        header('location:index.php');
    } else {
        header('location:login.php');
    }
}

// UNTUK MELAKUKAN REGISTER
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['pass'];
    $phone_number = $_POST['phone_number'];

    $cekdb = "SELECT * FROM pekerja WHERE no_telp = '$phone_number'";
    $data = mysqli_query($koneksi, $cekdb);

    if ($data && mysqli_num_rows($data) > 0) {
        $pekerja = mysqli_fetch_assoc($data);
        $id_pekerja = $pekerja['id_pekerja'];

        $register_query = "CALL Insert_Login('$username', '$password', '$id_pekerja')";
        $register_result = mysqli_query($koneksi, $register_query);

        if ($register_result) {
            echo "<script>alert('Registrasi Berhasil');</script>";
        } else {
            echo "<script>alert('Registrasi Gagal');</script>";
        }
    } else {
        echo "<script>alert('Nomor telepon tidak terdaftar');</script>";
    }
}

// ============ TABLE BARANG ===========
// tanmbah barang
if (isset($_POST['submit'])) {
    $namabarang = $_POST['namabarang'];
    $jenis = $_POST['listdesc'];
    $stok = $_POST['stok'];
    $distrib = $_POST['distributor'];
    $pekerja = $_SESSION['id_pekerja'];

    try {
        $addbarang = mysqli_query($koneksi, "CALL manage_brg('insert', 'null', '$namabarang', '$stok', '$jenis', '$distrib', '$pekerja')");
        if ($addbarang) {
            echo "
                    <script>
                        alert('Data Berhasil Ditambahkan!');    
                    </script>
                ";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header('location:index.php');
        exit;
    }
}

// edit barang
if (isset($_POST['updatebarang'])) {
    $idb = $_POST['idb'];
    $nama = $_POST['namabarang'];
    $deskripsi = $_POST['listdesc'];
    $pekerja = $_SESSION['id_pekerja'];
    $updatebarang = mysqli_query($koneksi, "CALL manage_brg('update', '$idb', '$nama', 'null', '$deskripsi', 'null', '$pekerja')");

    if ($updatebarang) {
        echo "
                <script>
                    alert('Data Berhasil Diperbarui!');    
                </script>
            ";
    }
}

//hapus barang
if (isset($_POST['hapusbarang'])) {
    $idb = $_POST['idb'];
    $hapusbarang = mysqli_query($koneksi, "CALL manage_brg('delete', '$idb', 'null', 'null', 'null', 'null', 'null')");

    if ($hapusbarang) {
        echo "
                <script>
                    alert('Data Berhasil Dihapus!');    
                </script>
            ";
    }
}


// ====================== TABLE TRANSAKSI ============================
// tambah barang masuk
if (isset($_POST['barangmasuk'])) {
    $id_barang = $_POST['listbarang'];
    $jumlah_masuk = $_POST['jumlah'];
    $id_pekerja = $_SESSION['id_pekerja'];
    $addbarangmasuk = mysqli_query($koneksi, "CALL manage_transaksi ('insert', NULL, '$jumlah_masuk', NULL, 'in', '$id_barang', '$id_pekerja')");

    if ($addbarangmasuk) {
        echo "
                <script>
                    alert('Data Berhasil Ditambahkan!');    
                </script>
            ";
    }
}

// tambah barang keluar
if (isset($_POST['barangkeluar'])) {
    $id_barang = $_POST['listbarang'];
    $jumlah_keluar = $_POST['jumlah'];
    $id_pekerja = $_SESSION['id_pekerja'];

    try {
        $addbarangkeluar = mysqli_query($koneksi, "CALL manage_transaksi ('insert', NULL, '$jumlah_keluar', NULL, 'out', '$id_barang', '$id_pekerja')");
        if ($addbarangkeluar) {
            echo "
                    <script>
                        alert('Data Berhasil Ditambahkan!');    
                    </script>
                ";
        }
    } catch (Exception $e) {
        echo "
            <script>
                alert('Gagal menambahkan data: " . $e->getMessage() . "');    
            </script>
        ";
    }
}

// edit transaski
if (isset($_POST['updateTransaksi'])) {
    $id_transaksi = $_POST['idt'];
    $jumlah = $_POST['jumlah'];

    try {
        $editTransaksi = mysqli_query($koneksi, "CALL `manage_transaksi`('update', $id_transaksi, $jumlah, NULL, NULL, NULL, NULL)");
        if ($editTransaksi) {
            echo "
                <script>
                    alert('Data Berhasil Dirubah!');    
                </script>
            ";
        }
    } catch (Exception $e) {
        echo "
            <script>
                alert('Gagal menambahkan data: " . $e->getMessage() . "');    
            </script>
        ";
    }
}


// hapus transaksi
if (isset($_POST['hapusTransaksi'])) {
    $id_transaksi = $_POST['idt'];
    $hapusTransaksi = mysqli_query($koneksi, "CALL manage_transaksi ('delete', '$id_transaksi', NULL, NULL, NULL, NULL, NULL)");

    if ($hapusTransaksi) {
        echo "
            <script>
                alert('Data Berhasil Dihapus!');    
            </script>
        ";
    }
}

// ====================== TABLE JENIS ============================
// tambah jenis
if (isset($_POST['submitjenis'])) {
    $jenis = $_POST['jenis'];
    try {
        $addjenis = mysqli_query($koneksi, "CALL manage_jenis ('insert', 'null', '$jenis')");
        if ($addjenis) {
            echo "
                    <script>
                        alert('Data Berhasil Ditambahkan!');    
                    </script>
                ";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header('location:jenis.php');
        exit;
    }
}

// edit jenis
if (isset($_POST['updatejenis'])) {
    $jenis = $_POST['jenis'];
    $id = $_POST['idj'];
    try {
        $addjenis = mysqli_query($koneksi, "CALL manage_jenis ('update', $id, '$jenis')");
        if ($addjenis) {
            echo "
                    <script>
                        alert('Data Berhasil Dirubah!');    
                    </script>
                ";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header('location:jenis.php');
        exit;
    }
}

// hapus jenis
if (isset($_POST['hapusjenis'])) {
    $id = $_POST['idj'];
    $deletedeskripsi = mysqli_query($koneksi, "CALL manage_jenis('delete', '$id', 'null')");
    if ($deletedeskripsi) {
        echo "
                <script>
                    alert('Data Berhasil Dihapus!');    
                </script>
            ";
    }
}

// ====================== TABLE DISTRIBUTOR ============================
// tambah distributor
if (isset($_POST['submitdistrib'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no = $_POST['no_telp'];
    try {
        $adddistrib = mysqli_query($koneksi, "CALL manage_distributor ('insert', 'null', '$nama', '$alamat', '$no')");
        if ($adddistrib) {
            echo "
                    <script>
                        alert('Data Berhasil Ditambahkan!');    
                    </script>
                ";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header('location:distributor.php');
        exit;
    }
}

// edit distributor
if (isset($_POST['updatedistrib'])) {
    $id = $_POST['iddis'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no = $_POST['no_telp'];
    $editdistrib = mysqli_query($koneksi, "CALL manage_distributor ('update', '$id', '$nama', '$alamat', '$no')");
    if ($editdistrib) {
        echo "
                <script>
                    alert('Data Berhasil Dirubah!');    
                </script>
            ";
    }
}

// hapus distributor
if (isset($_POST['hapusdistrib'])) {
    $id = $_POST['iddis'];
    $hapusdistrib = mysqli_query($koneksi, "CALL manage_distributor ('delete', '$id', 'null', 'null', 'null')");

    if ($hapusdistrib) {
        echo "
                <script>
                    alert('Data Berhasil Dihapus!');    
                </script>
            ";
    }
}

// ====================== TABLE PEKERJA ============================
// tambah pekerja
if (isset($_POST['submitpekerja'])) {
    global $koneksi;
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no = $_POST['no_telp'];
    $posisi = $_POST['jabatan'];

    try {
        $addpekerja = mysqli_query($koneksi, "CALL manage_pekerja ('insert', 'null', '$nama', '$no', '$alamat', '$posisi')");
        if ($addpekerja) {

            echo "
                    <script>
                        alert('Data Berhasil Ditambahkan!');    
                    </script>
                ";
        }
    } catch (Exception $e) {
        echo "
                <script>
                alert('Error: " . addslashes($e->getMessage()) . "');      
                </script>
            ";
        exit;
    }
}


// edit pekerja
if (isset($_POST['updatepekerja'])) {
    $id = $_POST['idpk'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no = $_POST['no_telp'];
    $posisi = $_POST['jabatan'];
    $editpekerja = mysqli_query($koneksi, "CALL manage_pekerja ('update', '$id', '$nama', '$no', '$alamat', '$posisi')");
    if ($editpekerja) {
        echo "
                <script>
                    alert('Data Berhasil Dirubah!');    
                </script>
            ";
    }
}

// hapus pekerja
if (isset($_POST['hapuspekerja'])) {
    $id = $_POST['idpk'];
    $hapuspekerja = mysqli_query($koneksi, "CALL manage_pekerja ('delete', '$id', 'null', 'null', 'null', 'null')");

    if ($hapuspekerja) {
        echo "
                <script>
                    alert('Data Berhasil Dihapus!');    
                </script>
            ";
    }
}

// logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('location:login.php');
    exit;
}
