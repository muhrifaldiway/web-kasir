<?php
require 'registrasi/function.php';

if (isset($_POST['registrasi'])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
                alert('user baru berhasil ditambahkan. silahkan login !');
                document.location.href = 'login.php';
              </script>";
    } else {
        echo "user gagal ditambahkan !";
    }
}

include 'templates/auth/header.php';
?>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                <div class="row flex-grow">
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="auth-form-transparent text-left p-3">
                            <div class="brand-logo">
                                <img src="assets/images/auth/logo-b.png" alt="logo">
                            </div>
                            <h6 class="font-weight-light">Silahkan registrasi terlebih dahulu! Masukkan dengan data diri anda yang sebenarnya</h6>

                            <form action="" method="POST" class="pt-6">
                                <div class="form-group mb-3">
                                    <label>Username</label>
                                    <input type="text" class="form-control" placeholder="Username" name="username" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Email</label>
                                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" placeholder="Alamat" name="alamat" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Telepon</label>
                                    <input type="number" class="form-control" placeholder="Telepon" name="telepon" required>
                                </div>
                                <div class="form-group mt-3">
                                    <button type="submit" name="registrasi" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">REGISTRASI</button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Anda sudah memiliki akun ? Silahkan! <a href="login.php" class="text-primary">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php include 'templates/auth/footer3.php'; ?>
                </div>
            </div>
        </div>
    </div>

</body>
