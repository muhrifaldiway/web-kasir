<?php

require 'login/function.php';

session_start();
 
if (isset($_SESSION['login'])) {
  if ($_SESSION['role_id'] == '1') {
      header("Location: penjualan.php");
  } elseif ($_SESSION['role_id'] == '2') {
      header("Location: admin.php");
  }
  exit;
}


//ketika tombol login di tekan

if (isset($_POST['login'])){
    $login = login($_POST);
}

include 'templates/auth/header.php'

;?>


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
              <h4>Selamat Datang!</h4>
              <h6 class="font-weight-light">Silahkan Login terlebih dahulu!</h6>
              <?php if(isset($login['error'])): ?>
                    <div class="alert alert-danger alert-dismissible">
                    <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong><?= $login['pesan'] ?></strong> Silahkan Login Kembali!.
                    </div>      
              <?php endif; ?>
                  <br>  
              <form action="" method="POST" class="pt-3">
                <div class="form-group">
                  <label for="exampleInputEmail">Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="fa-solid fa-user-secret text-primary"></i>
                      </span>
                    </div>

                    <input type="email" class="form-control form-control-lg border-left-0" placeholder="Email" name="email" required>
                  
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword">Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="fa-solid fa-code text-primary"></i>
                      </span>
                    </div>
                    
                    <input type="password" class="form-control form-control-lg border-left-0" placeholder="Password" name="password" required>                        
                  
                  </div>
                </div>
                
                <div class="my-3">
                  <button type="submit" name="login" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">LOGIN</button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Belum punya akun? <a href="registrasi.php" class="text-primary">Buat</a>
                </div>
              </form>
            </div>
          </div>

          <?php include 'templates/auth/footer.php';?>