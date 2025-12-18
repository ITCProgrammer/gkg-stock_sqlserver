<?php
class Kartustok extends Database{
	public function __construct()
    {
        $this->conn = $this->connectMySQLi();
    }
	
	public function barang($id) {
		$query = $this->conn->query("select * from TBL_BARANG where id = $id");
		$row = mysqli_fetch_array($query);
		return $row;
	}
	
	public function group_by($tabel,$id_barang,$tgl_awal,$tgl_akhir) 
{
   
    $query = "SELECT tanggal, sum(jumlah) as jumlah from $tabel  where id_barang  = '$id_barang' and  tanggal between '$tgl_awal' and '$tgl_akhir' group by tanggal";
    //$query = $this->conn->query($query);
	$result = $this->conn->query($query);

    $output = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output[$row['tanggal']] = $row['jumlah'];
        }
    }
    return $output;
}


function stok_cek($tabel,$id_barang,$tgl_awal){
  
    $query = "SELECT sum(jumlah) as jumlah from $tabel  where id_barang  = '$id_barang' and  tanggal  < '$tgl_awal' ";
    // $query = $this->conn->query($query);
	$result = $this->conn->query( $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['jumlah'];
    } else {
        return 0 ;
    }
}

function stok_awal($id_barang,$tgl_awal) {

    $awal_in = $this->stok_cek('tbl_barang_in',$id_barang,$tgl_awal);
    $awal_out = $this->stok_cek('tbl_barang_out',$id_barang,$tgl_awal);
    $awal_stok = $awal_in - $awal_out;
    return $awal_stok;
}

function formater($nilaiDecimal) {
   
    $nilaiDecimal = floatval($nilaiDecimal);

// Konversi nilai desimal menjadi string
$nilaiString = strval($nilaiDecimal);

// Memeriksa apakah string mengandung koma
if (strpos($nilaiString, '.') !== false) {
    // Jika ya (nilai desimal), tampilkan string aslinya
    return $nilaiString;
} else {
    // Jika tidak (nilai bulat), tampilkan nilai bulat
    return round($nilaiDecimal);
}

}

public function tampil_databarang()
 {
      $query=$this->conn->query("SELECT * FROM tbl_barang ");
      while ($d=mysqli_fetch_array($query)) {
          $result[]=$d;
      }
      return $result;
 }
 
public function note($tabel,$id_barang,$tgl_awal,$tgl_akhir) 
{
   
    $query = "SELECT tanggal, note  from $tabel  where id_barang  = '$id_barang' and  tanggal between '$tgl_awal' and '$tgl_akhir' group by tanggal";
	$result = $this->conn->query($query);

    $output = [];

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output[$row['tanggal']][] = $row['note'];
        }
    }
    return $output;
}
 
 

}
