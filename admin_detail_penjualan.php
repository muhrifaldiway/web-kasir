<?php

require 'detail_penjualan/function.php';

session_start();
if (!isset($_SESSION['login']) || $_SESSION['role_id'] !== 1) {
    header("Location: login.php");
    exit;
}

$user = query("SELECT * FROM user WHERE role_id = 1");
$penjualan = query("SELECT * FROM penjualan");
$detail_penjualan = query("SELECT * FROM detail_penjualan");

function getTotalHargaByUserIdAndTanggal($userId, $tanggal) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=web-kasir", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT SUM(total_harga) as total_harga FROM penjualan WHERE user_id = :userId AND tanggal = :tanggal";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":userId", $userId, PDO::PARAM_INT);
        $statement->bindParam(":tanggal", $tanggal);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result['total_harga'];
    } catch (PDOException $e) {
        die("Koneksi ke database gagal: " . $e->getMessage());
    }
}

function getUniqueDatesByUserId($userId) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=web-kasir", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT DISTINCT tanggal FROM penjualan WHERE user_id = :userId";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":userId", $userId, PDO::PARAM_INT);
        $statement->execute();

        $dates = $statement->fetchAll(PDO::FETCH_COLUMN);

        return $dates;
    } catch (PDOException $e) {
        die("Koneksi ke database gagal: " . $e->getMessage());
    }
}

function hitungSubtotal($penjualan) {
  $subtotal = 0;

  // Loop melalui array penjualan dan tambahkan total harga setiap entri
  foreach ($penjualan as $entry) {
      $subtotal += $entry['total_harga'];
  }

  return $subtotal;
}

// Fungsi untuk mendapatkan username berdasarkan user_id
function getUsernameById($userId) {
    // Implementasikan kueri ke database atau metode lain untuk mendapatkan username
    // Misalnya, Anda dapat menggunakan PDO atau metode lain sesuai kebutuhan
    $pdo = new PDO("mysql:host=localhost;dbname=web-kasir", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT username FROM user WHERE id_user = :userId";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":userId", $userId, PDO::PARAM_INT);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result['username'];
}

$selectedTanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedUserId = $_POST['user_id'];

    // Pengecekan apakah user_id telah dipilih
    if (!empty($selectedUserId)) {
        // Mendapatkan total harga berdasarkan user_id dan tanggal
        $totalHarga = getTotalHargaByUserIdAndTanggal($selectedUserId, $selectedTanggal);

        // Mendapatkan tanggal unik berdasarkan user_id
        $uniqueDates = getUniqueDatesByUserId($selectedUserId);
    }


  // Tambahkan kondisi untuk menghitung subtotal dan menampilkan di input subtotal
  if (isset($_POST['user_id']) && !empty($penjualan)) {
      $subtotal = hitungSubtotal($penjualan);

       // Memasukkan nilai subtotal ke dalam script JavaScript
  }

  

    if (isset($_POST['bayar'])) {
        if (bayar($_POST) > 0) {
            echo "<script>
                alert('data berhasil ditambahkan!');
                document.location.href = 'detail_penjualan.php';
            </script>";
        } else {
            echo "<script>
                alert('data gagal ditambahkan!');
                document.location.href = 'detail_penjualan.php';
            </script>";
        }
    }

    
   
}

include 'templates/auth/header.php';
include 'templates/auth/navbar2.php';
?>

<br>
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Detail Penjualan</h4>
            <br>
            <!-- Partial -->
            <form action="" method="POST" class="form-sample">
                <div class="row">
                    <div class="col-lg-3">
                        <input type="hidden" name="id_detail" id="id_detail"/>
                        <div class="form-group">
                            <label class="col-sm-6 col-form-label">Nama Petugas</label>
                            <select name="user_id" id="user_id" class="form-control" onchange="this.form.submit()">
                              <option value="">Silahkan Pilih!</option>
                              <?php foreach ($user as $us) : ?>
                                  <option value="<?= $us['id_user']; ?>" <?= isset($selectedUserId) && $selectedUserId == $us['id_user'] ? 'selected' : ''; ?>>
                                      <?= $us['username']; ?>
                                  </option>
                              <?php endforeach; ?>
                          </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="col-sm-6 col-form-label">Tanggal Penjualan</label>
                            <select name="tanggal" id="tanggal" class="form-control" onchange="this.form.submit()">
                                <option value="">Silahkan Pilih!</option>
                                <?php foreach ($uniqueDates as $date) : ?>
                                    <option value="<?= $date; ?>" <?= isset($selectedTanggal) && $selectedTanggal == $date ? 'selected' : ''; ?>>
                                        <?= $date; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="col-sm-6 col-form-label">Subtotal</label>
                            <input type="text" name="subtotal" id="subtotal" class="form-control" value="<?= isset($subtotal) ? number_format($totalHarga, 0, ',', '.') : ''; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="col-sm-6 col-form-label">Total Uang</label>
                            <input type="number" name="total_uang" id="total_uang" class="form-control" oninput="hitungSisaUang()">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="col-sm-6 col-form-label">Sisa Uang</label>
                            <input type="text" name="sisa_uang" id="sisa_uang" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <button type="submit" name="bayar" id="bayar" class="btn btn-primary font-weight-medium auth-form-btn">Bayar</button>
                    <a href="detail_penjualan.php" name="clear" id="clear" class="btn btn-dark">Clear</a>
                    <button type="button" class="btn btn-warning text-white" onclick="cetakStruk()">
                        Cetak
                    </button>
                </div>
                
            </form>
            <br><br>
            <!-- Partial -->
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
                                            <th>Subtotal</th>
                                            <th>Total Uang</th>
                                            <th>Sisa Uang</th>
                                            <th>Keterangan</th>
                                            <th>#Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($detail_penjualan as $de) :
                                        ?>
                                            <tr class="text-center">
                                                <td><?= $no++; ?></td>
                                                <td><?= getUsernameById($de['user_id']); ?></td>
                                                <td><?= date('d/m/Y', strtotime($de['tanggal'])); ?></td>
                                                <td>Rp <?= number_format($de['subtotal'], 3, ',', '.'); ?></td>
                                                <td>Rp <?= number_format($de['total_uang'], 0, ',', '.'); ?></td>
                                                <td>Rp <?= number_format($de['sisa_uang'], 3, ',', '.'); ?></td>
                                                <td class="badge bg-success"><b><?= $de['keterangan']; ?></b></td>
                                               
                                                <td>
                                                <a href="detail_penjualan/hapus.php?id_detail=<?=$de['id_detail'];?>" class="btn btn-outline-danger" onclick="return confirm('apakah anda yakin?');" name="hapus">Hapus</a>

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
            <!-- Kontainer untuk konten struk -->
            <div id="struk-content" style="display: none;">
                <div class="struk">
                    <h4>Struk Penjualan</h4>
                    <table class="table table-bordered">
                        <!-- Isi struk sesuai dengan data penjualan yang ingin dicetak -->
                        <tr>
                            <th>Nama Petugas</th>
                            <td><?= getUsernameById($de['user_id']); ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Penjualan</th>
                            <td><?= date('d/m/Y', strtotime($de['tanggal'])); ?></td>
                        </tr>
                        <tr>
                            <th>Subtotal</th>
                            <td>Rp <?= number_format($de['subtotal'], 3, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <th>Total Uang</th>
                            <td>Rp <?= number_format($de['total_uang'], 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <th>Sisa Uang</th>
                            <td>Rp <?= number_format($de['sisa_uang'], 3, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td><?= $de['keterangan']; ?></td>
                        </tr>
                        <tr>
                            <th><h5>TERIMAKASIH TELAH BERBELANJA DI TOKO KAMI!</h5></th>
                            <td><h5>SELAMAT BERBELANJA KEMBALI!</h5></td>
                        </tr>
                        
                    </table>
                </div>
            </div>

        </div>
    </div>
    <br>
    <br>
</div>

<style>
    @media print {
        /* Sembunyikan elemen-elemen yang tidak perlu dicetak */
        .card-title, .form-sample, .btn {
            display: none;
        }

        /* Atur tampilan struk cetak dengan Bootstrap 5 */
        .struk {
            width: 200px; /* Sesuaikan lebar struk sesuai kebutuhan */
            margin: 0 auto;
            text-align: center;
            font-size: 12px;
            line-height: 1.5;
        }

        .struk h4 {
            margin: 10px 0;
        }

        .struk table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .struk th, .struk td {
            border: 1px solid #000;
            padding: 5px;
        }
    }
</style>



<script>
      function hitungSisaUang() {
        var totalUang = parseFloat(document.getElementById("total_uang").value.replace(",", ".")) || 0;

        // Mendapatkan nilai subtotal dari input dengan id "subtotal" dan menghapus pemisah ribuan
        var subtotal = parseFloat(document.getElementById("subtotal").value.replace(/\./g, "").replace(",", ".")) || 0;

        // Menghitung sisa uang
        var sisaUang = totalUang - subtotal;

        // Menetapkan nilai sisa uang ke dalam input sisa uang dengan format tanpa digit ribuan
        document.getElementById("sisa_uang").value = sisaUang.toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }
    
</script>

<script>
    function cetakStruk() {
        // Sembunyikan elemen-elemen yang tidak perlu dicetak
        var elementsToHide = document.querySelectorAll('.card-title, .form-sample, .btn');
        elementsToHide.forEach(function(element) {
            element.style.display = 'none';
        });

        // Dapatkan konten struk untuk dicetak
        var strukContent = document.getElementById('struk-content').innerHTML;

        // Sembunyikan elemen lain di halaman
        document.body.innerHTML = strukContent;

        // Panggil fungsi window.print() untuk membuka dialog pencetakan
        window.print();

        // Kembalikan tampilan elemen-elemen yang disembunyikan setelah pencetakan selesai
        elementsToHide.forEach(function(element) {
            element.style.display = '';
        });

        // Muat ulang halaman untuk mengembalikan tampilan semula
        location.reload();
    }
</script>




<?php include 'templates/auth/footer2.php'; ?>
