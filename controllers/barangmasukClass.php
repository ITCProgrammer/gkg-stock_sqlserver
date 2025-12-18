<?php
class BarangMasuk extends Database{
	public function __construct()
    {
        $this->conn = $this->connectMySQLi();
    }
  public function jmlMasuk($idsub){
    $data=$this->conn->query("SELECT count(*) as jml from tbl_barang_in WHERE sub_dept='$idsub' ");
    $row = mysqli_fetch_array($data);
    return $row['jml'];
  }
  public function cektgl($tgl1,$tgl2,$idsub){
    $data=$this->conn->query("SELECT a.kode,a.nama,a.jenis,a.harga,a.satuan,b.tanggal,b.jumlah,b.note,b.userid from tbl_barang a
INNER JOIN tbl_barang_in b ON a.id=b.id_barang
WHERE b.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.sub_dept='$idsub'
ORDER BY a.kode ASC");
     while ($d=mysqli_fetch_array($data)) {
        $result[]=$d;
    }
    return $result;
  }
    // tampilkan data dari tabel barang dan tabel barang-in
    public function tampil_data_in($idsub)
    {
        $data=$this->conn->query("SELECT a.id as idb,a.kode,a.nama,a.jenis,a.harga,a.satuan,b.id,b.tanggal,b.jumlah,b.note,b.userid from tbl_barang a
  INNER JOIN tbl_barang_in b ON a.id=b.id_barang  WHERE a.sub_dept='$idsub'
  ORDER BY b.id DESC Limit 600");
        while ($d=mysqli_fetch_array($data)) {
            $result[]=$d;
        }
        return $result;
    }
    // tampilkan data dari tabel barang dan tabel barang-in berdasarkan range tgl masuk
    public function tampildatain_tgl($tgl1,$tgl2,$idsub)
    {
        $data=$this->conn->query("SELECT a.kode,a.nama,a.jenis,a.harga,a.satuan,b.tanggal,b.jumlah,b.note,b.userid from tbl_barang a
  INNER JOIN tbl_barang_in b ON a.id=b.id_barang
  WHERE b.tanggal BETWEEN '$tgl1' AND '$tgl2' AND a.sub_dept='$idsub'
  ORDER BY a.kode ASC");
        while ($d=mysqli_fetch_array($data)) {
            $result[]=$d;
        }
        return $result;
    }
    // proses input barang
    public function input_barang_in($id, $jumlah, $userid, $note, $idsub)
    {
        $sql="INSERT INTO tbl_barang_in(id_barang,tanggal,jumlah,userid,note,sub_dept)
  				VALUES ('$id',now(),'$jumlah','$userid','$note','$idsub')";
		$this->conn->query($sql);
        $this->conn->query("UPDATE tbl_barang SET
        jumlah=jumlah+'$jumlah'
        WHERE id='$id'");
    }
    // tampilkan data dari tabel barang yang akan di edit
    public function edit_barang_in($id)
    {
        $data=$this->conn->query("SELECT * FROM tbl_barang_in WHERE id='$id'");
        while ($x=mysqli_fetch_array($data)) {
            $hasil[]=$x;
        }
        return $hasil;
    }

    // proses update data Barang
    public function update_barang_in($id, $jumlah, $note, $idb, $selisih)
    {
        $this->conn->query("UPDATE tbl_barang_in SET
  jumlah='$jumlah',
  note='$note',
  tgl_update=now()
  WHERE id='$id'");
        $this->conn->query("UPDATE tbl_barang SET
  jumlah=jumlah-'$selisih'
  WHERE id='$idb'");
    }
    // proses delete data barang-in
    public function hapus_barang_in($id, $idb, $jumlah)
    {
        $this->conn->query("DELETE FROM tbl_barang_in where id='$id'");
        $this->conn->query("UPDATE tbl_barang SET
        jumlah=jumlah-'$jumlah'
        WHERE id='$idb'");
    }
    public function show_data_inid($id)
    {
        $query = $this->conn->query("SELECT a.id,b.jumlah from tbl_barang a
  INNER JOIN tbl_barang_in b ON a.id=b.id_barang
  WHERE b.id='$id' ORDER BY a.kode ASC");
        $d=mysqli_fetch_array($query);
        return $d['id'];
    }
    public function show_data_injml($id)
    {
        $query = $this->conn->query("SELECT a.id,b.jumlah from tbl_barang a
  INNER JOIN tbl_barang_in b ON a.id=b.id_barang
  WHERE b.id='$id' ORDER BY a.kode ASC");
        $d=mysqli_fetch_array($query);
        return $d['jumlah'];
    }
    public function show_detail($id)
    {
        $query = $this->conn->query("SELECT a.*,b.tanggal,b.jumlah as jml,b.note,b.userid from tbl_barang a
  INNER JOIN tbl_barang_in b ON a.id=b.id_barang
  WHERE b.id_barang='$id' ORDER BY a.kode ASC");
  while ($x=mysqli_fetch_array($query)) {
      $hasil[]=$x;
  }
  return $hasil;
    }
	}
