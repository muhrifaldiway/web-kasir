<?php

require 'produk/function.php';
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role_id'] !== 2) {
    header("Location: login.php");
  exit;
} 

$produk = query("SELECT * FROM user WHERE role_id = 1");
$list_produk = query("SELECT * FROM produk");
//cek apakah tombol simpan sudah ditekan

if (isset($_POST['simpan'])) {
  if (tambah($_POST) > 0) {
    echo "<script>
      alert('data berhasil ditambahkan!');
      document.location.href = 'admin_produk.php';
    </script>";
  }else {
    echo "<script>
      alert('data gagal ditambahkan!');
      document.location.href = 'admin_produk.php';
    </script>";
  }
}

//menambahkan data dan mengirimkan data ke function.php yang ada didalam folder pemesanan
if (isset($_POST['ubah'])) {
    if (ubah($_POST) > 0) {
      echo "<script>
        alert('data berhasil diubah!');
        document.location.href = 'admin_produk.php';
      </script>";
    }else {
      echo "<script>
        alert('data gagal diubah!');
        document.location.href = 'admin_produk.php';
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
                    <h4 class="card-title">Produk</h4>
                    <form action="" method="POST" class="form-sample">
                      <p class="card-description">
                        Input Produk
                      </p>
                      <div class="row">
                        <div class="col-md-4">
                        <input type="hidden" name="id_produk" id="id_produk"/>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Produk</label>
                            <div class="col-sm-8">
                              <input type="text" name="nama_produk" id="nama_produk" class="form-control" required/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Harga Produk</label>
                            <div class="col-sm-8">
                              <input type="number" name="harga" id="harga" class="form-control" required/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Stok</label>
                            <div class="col-sm-4">
                              <input type="number" name="stok" id="stok" class="form-control" required/>
                            </div>
                            <div class="col-md-4">
                                <div class="col-sm-4">
                                      <button type="submit" name="simpan" id="simpan" class="btn btn-primary font-weight-medium auth-form-btn">Simpan</button>
                                </div>
                            </div>
                          </div>
                        </div>
                        </div>
                    </div>
                    </form>
                    <!-- partial -->
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Data Produk</h4>
                      <div class="row">
                          <div class="col-12">
                              <div class="table-responsive">
                                  <table id="order-listing" class="table">
                              <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>#Action</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php $no = 1; foreach ($list_produk as $list) :?>
                                <tr class="text-center">
                                    <td><?=$no++;?></td>
                                    <td><?= $list['nama_produk'] ;?></td>
                                    <td>Rp <?= number_format($list['harga'], 0, ',', '.'); ?></td>
                                    <td><?= $list['stok'] ;?></td>
                                    <td>
                                      <a href="#" onclick="isiFormUbah('<?=$list['id_produk'];?>', '<?=$list['nama_produk'];?>', <?=$list['harga'];?>, <?=$list['stok'];?>);" class="btn btn-outline-success">Ubah</a>
                                      <a href="admin/hapus_admin_produk.php?id_produk=<?=$list['id_produk'];?>" class="btn btn-outline-danger" onclick="return confirm('apakah anda yakin?');" name="hapus">Hapus</a>
                                    </td>
                                </tr>
                                <?php endforeach ;?>
                              </tbody>
                            </table>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
</div>
<script>
  function isiFormUbah(id_produk, nama_produk, harga, stok) {
    // Isi nilai formulir dengan data yang sesuai
    document.getElementById('id_produk').value = id_produk;
    document.getElementById('nama_produk').value = nama_produk;
    document.getElementById('harga').value = harga;
    document.getElementById('stok').value = stok;

    // Ganti name pada tombol "Simpan" jika diperlukan
    document.getElementById('simpan').name = 'ubah'; // Ganti 'simpan' dengan name yang sesuai

    // Ubah warna dan nama tombol "Simpan"
    document.getElementById('simpan').classList.remove('btn-primary');
    document.getElementById('simpan').classList.add('btn-success');
    document.getElementById('simpan').innerHTML = 'Ubah'; // Ganti 'Ubah' dengan nama yang sesuai
  }
</script>
<?php include 'templates/auth/footer2.php' ;?>