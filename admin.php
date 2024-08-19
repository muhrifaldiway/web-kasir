<?php

require 'login/function.php';

session_start();
 
if (!isset($_SESSION['login'])|| $_SESSION['role_id'] !== 2) {
  header("Location: login.php");
  exit;
}

$admin = query("SELECT COUNT(*) as total_admin FROM user WHERE role_id = 2");
$petugas = query("SELECT COUNT(*) as total_petugas FROM user WHERE role_id = 1");
$penjualan = query("SELECT COUNT(*) as total_penjualan FROM penjualan");
$produk = query("SELECT COUNT(*) as total_produk FROM produk");
$bayar = query("SELECT COUNT(*) as total_bayar FROM detail_penjualan");

include 'templates/auth/header.php' ;
include 'templates/auth/navbar2.php' ;

;?>
  <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="container">
            <div class="row">
              <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body bg-primary text-white">
                    <p class="card-title text-md-center text-xl-left text-white">Admin</p>
                    <div class="text-center">
                      <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?php echo $admin[0]['total_admin']; ?></h3>
                      <br>
                      <i class="fa-solid fa-user-secret" style="font-size: 30px;"></i>
                    </div>  
                  </div>
                </div>
              </div>
              <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body bg-info text-white">
                    <p class="card-title text-md-center text-xl-left text-white">Petugas</p>
                    <div class="text-center">
                      <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?php echo $petugas[0]['total_petugas']; ?></h3>
                      <br>
                      <i class="fa-solid fa-user" style="font-size: 30px;"></i>
                    </div>  
                  </div>
                </div>
              </div>
              <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body bg-warning text-white">
                    <p class="card-title text-md-center text-xl-left text-white">Produk</p>
                    <div class="text-center">
                      <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?php echo $produk[0]['total_produk']; ?></h3>
                      <br>
                      <i class="fa-solid fa-cube" style="font-size: 30px;"></i>
                    </div>  
                  </div>
                </div>
              </div>
              <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body bg-danger text-white">
                    <p class="card-title text-md-center text-xl-left text-white">Penjualan</p>
                    <div class="text-center">
                      <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?php echo $penjualan[0]['total_penjualan']; ?></h3>
                      <br>
                      <i class="fa-solid fa-sitemap" style="font-size: 30px;"></i>
                    </div>  
                  </div>
                </div>
              </div>
              <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body bg-success text-white">
                    <p class="card-title text-md-center text-xl-left text-white">Pembayaran</p>
                    <div class="text-center">
                      <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?php echo $bayar[0]['total_bayar']; ?></h3>
                      <br>
                      <i class="fa-solid fa-box-archive" style="font-size: 30px;"></i>
                    </div>  
                  </div>
                </div>
              </div>
            </div>
          
          </div>
        </div>
        </div>
        <br>


<?php include 'templates/auth/footer2.php' ;?>