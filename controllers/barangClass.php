<?php
class Barang extends Database{
	public function __construct()
    {
        $this->conn = $this->connectMySQLi();
    }
    //cek stok Minimal
    public function cekMinimal($idsub){
     $data=$this->conn->query("SELECT * from tbl_barang WHERE jumlah<=jumlah_min_a and sub_dept='$idsub' ORDER BY kode ASC");
      while ($x=mysqli_fetch_array($data)) {
          $hasil[]=$x;
      }
      return $hasil;
    }
    public function jmlMinRow($idsub){
      $data=$this->conn->query("SELECT count(*) as jml from tbl_barang WHERE jumlah<=jumlah_min_a and sub_dept='$idsub' ORDER BY kode ASC");
      $row = mysqli_fetch_array($data);
      return $row['jml'];
    }
    public function jmlStock($idsub){
      $data=$this->conn->query("SELECT count(*) as jml from tbl_barang WHERE sub_dept='$idsub' ");
      $row = mysqli_fetch_array($data);
      return $row['jml'];
    }
    // ambil harga
    public function ambilHarga($id)
    {
        $query = $this->conn->query("SELECT * FROM tbl_barang WHERE id='$id'");
        $row = mysqli_fetch_array($query);
        return $row['harga'];
    }

    // proses input barang
    public function input_barang($kode, $nama, $jenis, $harga, $satuan, $minimal,$minatas,$idsub,$project,$demand,$mc,$greige_lbr,$greige_grm,$kategori_bs)
    {
        $sql="INSERT INTO tbl_barang(kode,nama,jenis,harga,satuan,jumlah_min,jumlah_min_a,tgl_buat,tgl_update,sub_dept,project,demand,mc,greige_lbr,greige_grm,kategori_bs)
		VALUES ('$kode','$nama','$jenis','$harga','$satuan','$minimal','$minatas',now(),now(),'$idsub','$project','$demand','$mc','$greige_lbr','$greige_grm','$kategori_bs')";
		$this->conn->query($sql);
    }

    // tampilkan data dari tabel barang yang akan di edit
    public function edit_barang($id)
    {
        $data=$this->conn->query("SELECT * FROM tbl_barang WHERE id='$id'");
        while ($x=mysqli_fetch_array($data)) {
            $hasil[]=$x;
        }
        return $hasil;
    }

    // proses update data Barang
    public function update_barang($id, $nama, $jenis, $harga, $satuan, $minimal,$minatas,$project,$demand,$mc,$greige_lbr,$greige_grm,$kategori_bs)
    {
        $this->conn->query("UPDATE tbl_barang SET
		nama='$nama',
		jenis='$jenis',
		harga='$harga',
		satuan='$satuan',
    	jumlah_min='$minimal',
    	jumlah_min_a='$minatas',
		tgl_update=now(),
		project='$project',
		demand='$demand',
		mc='$mc',
		greige_lbr='$greige_lbr',
		greige_grm='$greige_grm',
		kategori_bs='$kategori_bs'
		WHERE id='$id'");
    }
    // proses delete data barang
    public function hapus_barang($id)
    {
        $this->conn->query("DELETE FROM tbl_barang where id='$id'");
    }

    // tampilkan data dari tabel barang
    public function tampil_data($idsub,$min)
    {
      if($min=="minimal"){
        $where =" AND a.jumlah <= a.jumlah_min_a ";
      }else{
		$where =" ";  
	  }
        $data=$this->conn->query("SELECT
			a.*,b.id as idb
				FROM
			tbl_barang a
				LEFT JOIN tbl_barang_in b ON a.id=b.id_barang WHERE a.sub_dept='$idsub' and `status`='1' $where
				GROUP BY a.id
				ORDER BY
			kode ASC");
        while ($d=mysqli_fetch_array($data)) {
            $result[]=$d;
        }
        return $result;
    }
	public function tampil_satuan()
  {
      $query=$this->conn->query("SELECT satuan FROM tbl_satuan");
      while ($d=mysqli_fetch_array($query)) {
          $result[]=$d;
      }
      return $result;
  }
	public function tampil_databarang($idsub)
  {
      $query=$this->conn->query("SELECT * FROM tbl_barang WHERE sub_dept='$idsub'");
      while ($d=mysqli_fetch_array($query)) {
          $result[]=$d;
      }
      return $result;
  }
	
}
