<?php
class Satuan extends Database{
	public function __construct()
    {
        $this->conn = $this->connectMySQLi();
    }
  // tampilkan data dari tabel satuan
  public function tampil_data()
  {
      $query=$this->conn->query("SELECT * FROM tbl_satuan");
      while ($d=mysqli_fetch_array($query)) {
          $result[]=$d;
      }
      return $result;
  }

    // proses input data satuan
    public function input_satuan($satu, $ket)
    {
        $sql="INSERT INTO tbl_satuan(satuan,ket) VALUES ('$satu','$ket')";
		$this->conn->query($sql);
    }

    // tampilkan data dari tabel users yang akan di edit
    public function edit_satuan($id)
    {
        $data=$this->conn->query("SELECT * FROM tbl_satuan WHERE id='$id'");
        while ($x=mysqli_fetch_array($data)) {
            $hasil[]=$x;
        }
        return $hasil;
    }

    // proses update data user
    public function update_satuan($id, $satu, $ket)
    {
    	$this->conn->query("UPDATE tbl_satuan SET
  				satuan='$satu',
  				ket='$ket'
  				WHERE id='$id'");
    }
    // proses delete data project
    public function hapus_satuan($id)
    {
        $this->conn->query("DELETE FROM tbl_satuan where id='$id'");
    }
}
