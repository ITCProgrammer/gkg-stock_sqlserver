<?php
class Permohonan extends Database{
	public function __construct()
    {
        $this->conn = $this->connectMySQLi();
    }   
    // proses input permohonan
    public function input_permohonan($documentno, $tgl, $dept, $note, $idsub)
    {
        $this->conn->query("INSERT INTO tbl_permohonan(documentno,tgl_mohon,dept,note,tgl_buat,tgl_update,sub_dept)
		VALUES ('$documentno','$tgl','$dept','$note',now(),now(),'$idsub')");
    }
	// proses input detail permohonan
    public function add_detail_permohonan($id, $kode, $jumlah)
    {
        $this->conn->query("INSERT INTO tbl_permohonan_detail(id_mohon,id_kode,jumlah,tgl_update)
		VALUES ('$id','$kode','$jumlah',now())");
    }
    // tampilkan data dari tabel permohonan yang akan di edit
    public function edit_permohonan($id)
    {
        $data=$this->conn->query("SELECT * FROM tbl_permohonan WHERE id='$id'");
        while ($x=mysqli_fetch_array($data)) {
            $hasil[]=$x;
        }
        return $hasil;
    }

    // proses update data permohonan
    public function update_permohonan($id,$tgl,$note)
    {
        $this->conn->query("UPDATE tbl_permohonan SET
		note='$note',
		tgl_mohon='$tgl',
		tgl_update=now()
		WHERE id='$id'");
    }
    // proses delete data permohonan
    public function hapus_permohonan($id)
    {
        $this->conn->query("DELETE FROM tbl_permohonan where id='$id'");
    }

    // tampilkan data dari tabel permohonan
    public function tampil_data($idsub)
    {      
        $data=$this->conn->query("SELECT
	a.*,count(id_kode) as jml,b.id as idb
FROM
	tbl_permohonan a
LEFT JOIN tbl_permohonan_detail b ON a.id=b.id_mohon WHERE a.sub_dept='$idsub' GROUP BY a.id
ORDER BY
	documentno ASC");
        while ($d=mysqli_fetch_array($data)) {
            $result[]=$d;
        }
        return $result;
    }
	// tampilkan data dari tabel permohonan detail
	public function show_detail($id)
    {
        $query = $this->conn->query("SELECT b.jumlah as jml_mohon,c.* from tbl_permohonan a
  INNER JOIN tbl_permohonan_detail b ON a.id=b.id_mohon
	INNER JOIN tbl_barang c ON c.id=b.id_kode
  WHERE a.id='$id' ORDER BY b.id ASC");
  while ($x=mysqli_fetch_array($query)) {
      $hasil[]=$x;
  }
  return $hasil;
    }
	public function tampil_permohonan($id)
  {
      $query=$this->conn->query("SELECT *, date_format(tgl_mohon, '%d %M %Y') as tglmohon FROM tbl_permohonan WHERE id='$id'");
      while ($d=mysqli_fetch_array($query)) {
          $result[]=$d;
      }
      return $result;
  }
	public function tampil_permohonan_detail($id)
  {
      $query=$this->conn->query("SELECT
	a.*,
	b.kode,
	b.nama,
	b.satuan,
	b.jumlah as stok	 
FROM
	tbl_permohonan_detail a
	INNER JOIN tbl_barang b ON a.id_kode = b.id 
WHERE
	a.id_mohon = '$id'");
      while ($d=mysqli_fetch_array($query)) {
          $result[]=$d;
      }
      return $result;
  }
}
