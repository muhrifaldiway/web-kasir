<?php

require 'admin/function.php';
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role_id'] !== 2) {
    header("Location: login.php");
  exit;
} 
//cek apakah tombol simpan sudah ditekan
$user = query("SELECT * FROM user");

if (isset($_POST['simpan'])) {
  if (tambah($_POST) > 0) {
    echo "<script>
      alert('data berhasil ditambahkan!');
      document.location.href = 'user.php';
    </script>";
  }else {
    echo "<script>
      alert('data gagal ditambahkan!');
      document.location.href = 'user.php';
    </script>";
  }
}

//menambahkan data dan mengirimkan data ke function.php yang ada didalam folder pemesanan
if (isset($_POST['ubah'])) {
    if (ubah($_POST) > 0) {
      echo "<script>
        alert('data berhasil diubah!');
        document.location.href = 'user.php';
      </script>";
    }else {
      echo "<script>
        alert('data gagal diubah!');
        document.location.href = 'user.php';
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
                    <h4 class="card-title">User</h4>
                    <form action="" method="POST" class="form-sample">
                      <p class="card-description">
                        Input User
                      </p>
                      <div class="row">
                        <div class="col-md-4">
                        <input type="hidden" name="id_user" id="id_user"/>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-8">
                              <input type="text" name="username" id="username" class="form-control" required/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-8">
                              <input type="email" name="email" id="email" class="form-control" required/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-8">
                              <input type="text" name="password" id="password" class="form-control" required/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                              <input type="text" name="alamat" id="alamat" class="form-control" required/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Telepon</label>
                            <div class="col-sm-8">
                              <input type="number" name="telepon" id="telepon" class="form-control" required/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Role_id</label>
                            <div class="col-sm-4">
                              <input type="number" name="role_id" id="role_id" class="form-control" required/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="col-sm-8">
                              <button type="submit" name="simpan" id="simpan" class="btn btn-primary font-weight-medium auth-form-btn">Simpan</button>
                              <a href="user.php" class="btn btn-dark font-weight-medium auth-form-btn">Clear</a>
                        </div>
                    </div>
                        </div>
                    </div>
                    </form>
                    <!-- partial -->
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Data User</h4>
                      <div class="row">
                          <div class="col-12">
                              <div class="table-responsive">
                                  <table id="order-listing" class="table">
                              <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Role_id</th>
                                    <th>#Action</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php $no = 1; foreach ($user as $u) :?>
                                <tr class="text-center">
                                    <td><?=$no++;?></td>
                                    <td><?= $u['username'] ;?></td>
                                    <td><?= $u['email']; ?></td>
                                    <td><?= $u['password'] ;?></td>
                                    <td><?= $u['alamat'] ;?></td>
                                    <td><?= $u['telepon'] ;?></td>
                                    <td><?= $u['role_id'] ;?></td>
                                    <td>
                                      <a href="#" onclick="isiFormUbah('<?=$u['id_user'];?>', '<?=$u['username'];?>', '<?=$u['email'];?>', '<?=$u['password'];?>','<?=$u['alamat'];?>','<?=$u['telepon'];?>','<?=$u['role_id'];?>');" class="btn btn-outline-success">Ubah</a>

                                      <a href="admin/hapus_user.php?id_user=<?=$u['id_user'];?>" class="btn btn-outline-danger" onclick="return confirm('apakah anda yakin?');" name="hapus">Hapus</a>
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
  function isiFormUbah(id_user, username, email, password, alamat, telepon, role_id) {
  // Isi nilai formulir dengan data yang sesuai
  document.getElementById('id_user').value = id_user;
  document.getElementById('username').value = username;
  document.getElementById('email').value = email;
  document.getElementById('password').value = password;
  document.getElementById('alamat').value = alamat;
  document.getElementById('telepon').value = telepon;
  document.getElementById('role_id').value = role_id;

  // Ganti name pada tombol "Simpan" jika diperlukan
  document.getElementById('simpan').name = 'ubah'; // Ganti 'simpan' dengan name yang sesuai

  // Ubah warna dan nama tombol "Simpan"
  document.getElementById('simpan').classList.remove('btn-primary');
  document.getElementById('simpan').classList.add('btn-success');
  document.getElementById('simpan').innerHTML = 'Ubah'; // Ganti 'Ubah' dengan nama yang sesuai
}

</script>
<?php include 'templates/auth/footer2.php' ;?>