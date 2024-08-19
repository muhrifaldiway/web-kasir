<?php

require 'penjualan/function.php';

session_start();
if (!isset($_SESSION['login']) || $_SESSION['role_id'] !== 2) {
    header("Location: login.php");
  exit;
} 

$user = query("SELECT * FROM user WHERE role_id = 1");

$list_produk = query("SELECT * FROM produk");
$penjualan = query("SELECT * FROM penjualan");

$totalHarga = 0;
$totalBayar = 0;
//cek apakah tombol simpan sudah ditekan

$penjualanEntries = isset($_SESSION['penjualan_entries']) ? $_SESSION['penjualan_entries'] : [];

if (isset($_POST['tambah'])) {
    $user_id = $_POST['user_id'];
    $tanggal = $_POST['tanggal'];
    $produk_id_and_harga = $_POST['produk_id'];

    $exploded_values = explode(',', $produk_id_and_harga);
    $produk_id = $exploded_values[0];
    $harga = $exploded_values[1];

    $jumlah_produk = $_POST['jumlah_produk'];
    $totalHarga = $jumlah_produk * $harga;

    // Buat array untuk menyimpan data yang dimasukkan
    $penjualanData = [
        'user_id' => $user_id,
        'tanggal' => $tanggal,
        'produk_id' => $produk_id,
        'jumlah_produk' => $jumlah_produk,
        'totalHarga' => $totalHarga,
    ];

    // Tambahkan data ke dalam array untuk menyimpan multiple entries
    $penjualanEntries[] = $penjualanData;

    // Simpan array ke dalam sesi
    $_SESSION['penjualan_entries'] = $penjualanEntries;
}

if (isset($_POST['clear'])) {
    // Hapus semua data dari array
    $penjualanEntries = [];

    // Simpan array yang telah diupdate ke dalam sesi
    $_SESSION['penjualan_entries'] = $penjualanEntries;
}


if (isset($_POST['simpan'])) {
    if (tambah($_POST) > 0) {
        // Data berhasil ditambahkan ke database
        echo "<script>
            alert('data berhasil ditambahkan!');
            document.location.href = 'admin_penjualan.php';
        </script>";

        // Hapus tampilan data sementara berdasarkan produk_id
        $produk_id_to_remove = $_POST['produk_id'];
        $penjualanEntries = array_filter($penjualanEntries, function ($entry) use ($produk_id_to_remove) {
            return $entry['produk_id'] != $produk_id_to_remove;
        });

        // Simpan array yang telah diupdate ke dalam sesi
        $_SESSION['penjualan_entries'] = $penjualanEntries;
    } else {
        echo "<script>
            alert('data gagal ditambahkan!');
            document.location.href = 'admin_penjualan.php';
        </script>";
    }
}

//menambahkan data dan mengirimkan data ke function.php yang ada didalam folder pemesanan
if (isset($_POST['ubah'])) {
    if (ubah($_POST) > 0) {
      echo "<script>
        alert('data berhasil diubah!');
        document.location.href = 'admin_penjualan.php';
      </script>";
    }else {
      echo "<script>
        alert('data gagal diubah!');
        document.location.href = 'admin_penjualan.php';
      </script>";
    }
  }


 include 'templates/auth/header.php';
 include 'templates/auth/navbar2.php';
?>

<br>
<div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Input Penjualan</h4>
                    <form action="" method="POST" class="form-sample">
                     
                      <div class="row">
                        <div class="col-lg-2">
                            <input type="hidden" name="id_penjualan" id="id_penjualan"/>
                            <div class="form-group">
                              <label class="col-sm-6 col-form-label">Nama Petugas</label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <option value="">Silahkan Pilih!</option>
                                    <?php foreach ($user as $us) :?>
                                        <option value="<?= $us['id_user'] ;?>">
                                            <?= $us['username']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                          </div>
                        </div>
                        
                        <div class="col-lg-2">
                          <div class="form-group">
                            <label class="col-sm-3 col-form-label">Tanggal</label>
                              <input type="date" name="tanggal" id="tanggal" class="form-control" required/>
                          </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="col-sm-3 col-form-label">Produk</label>
                                <select name="produk_id" id="produk_id" class="form-control" onchange="updateTotalHarga()" required>
                                    <option value="">Silahkan Pilih!</option>
                                    <?php foreach ($list_produk as $list) :?>    
                                        <option value="<?= $list['id_produk'] . ',' . $list['harga']; ?>">
                                            <?= $list['nama_produk']; ?>
                                        </option>
                                    <?php endforeach ;?>
                                </select> 
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label class="col-sm-6 col-form-label">Jumlah Produk</label>
                                <input type="number" name="jumlah_produk" id="jumlah_produk" class="form-control" required>
                            </div>
                        </div>
                    </div>
                        <!-- Tambahkan field total harga yang akan diisi secara otomatis -->
                        <div class="col-lg-6">
                                      <button type="submit" name="tambah" id="tambah" class="btn btn-primary font-weight-medium auth-form-btn">Tambah</button>
                                      <a href="admin_penjualan.php" class="btn btn-dark">Clear</a>        
                                      <a href="admin_detail_penjualan.php" class="btn btn-warning font-weight-medium auth-form-btn">Detail Penjualan</a>        
                        </div>
                        
                    </form>
                </div>
                    <!-- partial -->
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Tabel Data Pembelian</h4>
                      <div class="row">
                          <div class="col-12">
                            <div class="table-responsive">
                            <table id="order-listing" class="table">
                              <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Petugas</th>
                                    <th>Tanggal Penjualan</th>
                                    <th>Produk</th>
                                    <th>Jumlah Produk</th>
                                    <th>Total Harga</th>
                                    <th>#Action</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php
                                $no = 1;
                                foreach ($penjualanEntries as $entry) :
                                ?>
                                    <tr class="text-center">
                                        <td><?= $no++; ?></td>
                                        <td><?= $entry['user_id']; ?></td>
                                        <td><?= $entry['tanggal']; ?></td>
                                        <td><?= $entry['produk_id']; ?></td>
                                        <td><?= $entry['jumlah_produk']; ?></td>
                                        <td>Rp <?= number_format($entry['totalHarga'], 0, ',', '.'); ?></td>
                                        <td>
                                        <form method="post" action="">
                                            <input type="hidden" name="user_id" value="<?= $entry['user_id']; ?>">
                                            <input type="hidden" name="tanggal" value="<?= $entry['tanggal']; ?>">
                                            <input type="hidden" name="produk_id" value="<?= $entry['produk_id']; ?>">
                                            <input type="hidden" name="jumlah_produk" value="<?= $entry['jumlah_produk']; ?>">
                                            <input type="hidden" name="total_harga" value="<?= $entry['totalHarga']; ?>">
                                            <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                                        </form>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                                ?>
                                </tbody>
                            </table>
                            
                        </div>
                        </div>
                      </div>
                     
                      </div>

                      
                      
                    </div>
   
                  
                <br>          
                <br>          




<?php include 'templates/auth/footer2.php' ;?>