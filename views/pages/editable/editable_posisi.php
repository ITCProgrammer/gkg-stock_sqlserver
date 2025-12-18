
<?PHP
ini_set("error_reporting", 1);
$con=mysqli_connect("10.0.0.10","dit","4dm1n","invgkg");
// $con=mysqli_connect("localhost","root","","invgkg");
// echo '$_POST[value]';
// echo '$_POST[pk]';
mysqli_query($con,"UPDATE tbl_surat_jalan_detail SET `lokasi_masuk` = '$_POST[value]' where id = '$_POST[pk]'");

echo json_encode('success');
