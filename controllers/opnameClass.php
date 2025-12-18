<?php
class Opname extends Database{
	public function __construct()
    {
        $this->conn = $this->connectMySQLi();
    }
  public function input_opname($idsub,$awal,$akhir,$note,$userid)
  {
    $this->conn->query("INSERT INTO tbl_opname(tgl_awal,tgl_akhir,note,userid,tgl_buat,tgl_update,sub_dept) VALUES('$awal','$akhir','$note','$userid',now(),now(),'$idsub')");
    $sql=$this->conn->query("SELECT * FROM tbl_opname WHERE tgl_awal='$awal' and tgl_akhir='$akhir' and sub_dept='$idsub'");
    $dt=mysqli_fetch_array($sql);

$data=$this->conn->query("SELECT
  a.id,a.kode,a.nama,a.jenis,
  if(ISNULL(d.stokawal),0,d.stokawal) as stokawal,
  IF(b.stok_in>0,b.stok_in,0)as stokin,
  IF(c.stok_out>0,c.stok_out,0)as stokout,
  (((IF(b.stok_in>0,b.stok_in,0)))-(IF(c.stok_out>0,c.stok_out,0))) + if(ISNULL(d.stokawal),0,d.stokawal) as stok_akhir,
a.sub_dept FROM tbl_barang a LEFT JOIN ( SELECT sum(jumlah) AS stok_in, id_barang
FROM tbl_barang_in WHERE tanggal BETWEEN '$awal' AND '$akhir' GROUP BY id_barang ) b ON a.id = b.id_barang
LEFT JOIN (	SELECT sum(jumlah) AS stok_out, id_barang FROM tbl_barang_out WHERE tanggal BETWEEN '$awal' AND '$akhir'
GROUP BY id_barang) c ON a.id = c.id_barang
LEFT JOIN (	SELECT a.sub_dept,b.stok_akhir as stokawal,b.idb from tbl_opname a INNER JOIN tbl_opname_detail b ON a.id=b.id_opname
WHERE a.sub_dept='$idsub' AND SUBDATE(a.tgl_akhir, INTERVAL -1 DAY)='$awal') d ON a.id = d.idb
WHERE a.sub_dept='$idsub'  AND a.status='1'");
  while ($d=mysqli_fetch_array($data)) {
    $this->conn->query("INSERT INTO tbl_opname_detail(id_opname,idb,kode,nama,jenis,stok_awal,stok_in,stok_out,stok_akhir)
    VALUES ('".$dt['id']."','".$d['id']."','".$d['kode']."','".$d['nama']."','".$d['jenis']."','".$d['stokawal']."','".$d['stokin']."','".$d['stokout']."','".$d['stok_akhir']."')");
      }

  }
  public function ambilTgl($idsub){
    $query = $this->conn->query("SELECT tgl_akhir FROM tbl_opname WHERE sub_dept='$idsub' ORDER BY id DESC");
    $row = mysqli_fetch_array($query);
    $tglakhir= $row['tgl_akhir'];
    return $tglakhir;
  }
  public function tampildata($idsub){
    $query=$this->conn->query("SELECT a.id,a.tgl_awal, a.tgl_akhir,
	sum(b.stok_awal) AS stokawal,
	sum(b.stok_in) AS stokin,
	sum(b.stok_out) AS stokout,
  sum(b.stok_akhir) AS stokakhir,
  a.note,a.userid
FROM tbl_opname a
INNER JOIN tbl_opname_detail b ON a.id=b.id_opname
WHERE a.sub_dept = '$idsub' GROUP BY a.id ORDER BY a.id DESC");
    while ($d=mysqli_fetch_array($query)) {
        $result[]=$d;
    }
    return $result;
  }
  // proses delete data project
  public function hapus_opname($id)
  {
      $this->conn->query("DELETE FROM tbl_opname where id='$id'");
      $this->conn->query("DELETE FROM tbl_opname_detail where id_opname='$id'");
  }
  public function tampilreport($idsub,$awal,$akhir){
    $query=$this->conn->query("SELECT
	b.nama,
	b.jenis,
	b.stok_awal,
	b.stok_in,
	b.stok_out,
	b.stok_akhir,
	c.jumlah AS aktual
FROM
	tbl_opname a
INNER JOIN tbl_opname_detail b ON a.id = b.id_opname
LEFT JOIN (
	SELECT
		id,
		jumlah
	FROM
		tbl_barang
	WHERE
		sub_dept = '$idsub'
		and `status` = '1'
) c ON b.idb = c.id
WHERE
	a.tgl_awal = '$awal'
AND a.tgl_akhir = '$akhir'
AND a.sub_dept = '$idsub'
ORDER BY b.id ASC");
  while($d=mysqli_fetch_array($query)){
    $result[]=$d;
  }
    return $result;
  }
}
