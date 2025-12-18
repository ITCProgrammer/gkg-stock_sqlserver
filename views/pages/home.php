<?php
session_start();

$user= new User();
$barang= new Barang();
$barangin= new BarangMasuk();
$barangout=new BarangKeluar();

$iduser=$_SESSION['idQC'];
$minStock=$barang->jmlMinRow($idsub);
$totItem=$barang->jmlStock($idsub);
$transIN=$barangin->jmlMasuk($idsub);
$transOUT=$barangout->jmlKeluar($idsub);
?>

<!DOCTYPE html>
<html dir="ltr" lang="en-US"><head><!-- Created by Artisteer v4.3.0.60745 -->
    <meta charset="utf-8">
    <title>Home</title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
<body>
      <blockquote style="margin: 0px"><h1>Welcome <?php echo $user->ambilNama($iduser); ?> at Indo Taichen Textile Industry</h1> </blockquote>
       <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $totItem;?></h3>

              <p>Total Items</p>
            </div>
            <div class="icon">
              <i class="fa fa-puzzle-piece"></i>
            </div>
            <a href="Barang" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $transIN;?></h3>

              <p>Transactions In</p>
            </div>
            <div class="icon">
              <i class="fa fa-hourglass-half"></i>
            </div>
            <a href="stok-in" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $transOUT;?></h3>

              <p>Transactions Out</p>
            </div>
            <div class="icon">
              <i class="fa fa-cubes"></i>
            </div>
            <a href="stok-out" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php  echo $minStock;?></h3>

              <p>Item Minimal</p>
            </div>
            <div class="icon">
              <i class="fa fa-check-square-o"></i>
            </div>
            <a href="Barang_minimal" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

        <p>   </p>

</body>
</html>
