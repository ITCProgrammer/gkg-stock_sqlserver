<?php
class Barang extends Database
{

  public function __construct()
  {
    $this->conn = $this->connectMySQLi(); // koneksi sqlsrv (resource)
  }

  // cek stok Minimal
  public function cekMinimal($idsub)
  {
    $sql = "SELECT * FROM invgkg.tbl_barang
                WHERE jumlah <= jumlah_min_a AND sub_dept = ?
                ORDER BY kode ASC";
    $data = sqlsrv_query($this->conn, $sql, [$idsub]);
    if ($data === false)
      die(print_r(sqlsrv_errors(), true));

    $hasil = [];
    while ($x = sqlsrv_fetch_array($data, SQLSRV_FETCH_BOTH)) {
      $hasil[] = $x;
    }
    return $hasil;
  }

  public function jmlMinRow($idsub)
  {
    $sql = "SELECT COUNT(*) AS jml
                FROM invgkg.tbl_barang
                WHERE jumlah <= jumlah_min_a AND sub_dept = ?";
    $data = sqlsrv_query($this->conn, $sql, [$idsub]);
    if ($data === false)
      die(print_r(sqlsrv_errors(), true));

    $row = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC);
    return $row['jml'] ?? 0;
  }

  public function jmlStock($idsub)
  {
    $sql = "SELECT COUNT(*) AS jml
                FROM invgkg.tbl_barang
                WHERE sub_dept = ?";
    $data = sqlsrv_query($this->conn, $sql, [$idsub]);
    if ($data === false)
      die(print_r(sqlsrv_errors(), true));

    $row = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC);
    return $row['jml'] ?? 0;
  }

  // ambil harga
  public function ambilHarga($id)
  {
    $sql = "SELECT TOP 1 harga FROM invgkg.tbl_barang WHERE id = ?";
    $query = sqlsrv_query($this->conn, $sql, [$id]);
    if ($query === false)
      die(print_r(sqlsrv_errors(), true));

    $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    return $row['harga'] ?? null;
  }

  // proses input barang
  public function input_barang($kode, $nama, $jenis, $harga, $satuan, $minimal, $minatas, $idsub, $project, $demand, $mc, $greige_lbr, $greige_grm, $kategori_bs)
  {
    $sql = "INSERT INTO invgkg.tbl_barang
                (kode,nama,jenis,harga,satuan,jumlah_min,jumlah_min_a,tgl_buat,tgl_update,sub_dept,project,demand,mc,greige_lbr,greige_grm,kategori_bs)
                VALUES (?,?,?,?,?,?,?,GETDATE(),GETDATE(),?,?,?,?,?,?,?)";

    $params = [$kode, $nama, $jenis, $harga, $satuan, $minimal, $minatas, $idsub, $project, $demand, $mc, $greige_lbr, $greige_grm, $kategori_bs];

    $stmt = sqlsrv_query($this->conn, $sql, $params);
    if ($stmt === false)
      die(print_r(sqlsrv_errors(), true));
  }

  // tampilkan data dari tabel barang yang akan di edit
  public function edit_barang($id)
  {
    $sql = "SELECT * FROM invgkg.tbl_barang WHERE id = ?";
    $data = sqlsrv_query($this->conn, $sql, [$id]);
    if ($data === false)
      die(print_r(sqlsrv_errors(), true));

    $hasil = [];
    while ($x = sqlsrv_fetch_array($data, SQLSRV_FETCH_BOTH)) {
      $hasil[] = $x;
    }
    return $hasil;
  }

  // proses update data Barang
  public function update_barang($id, $nama, $jenis, $harga, $satuan, $minimal, $minatas, $project, $demand, $mc, $greige_lbr, $greige_grm, $kategori_bs)
  {
    $sql = "UPDATE invgkg.tbl_barang SET
                    nama = ?,
                    jenis = ?,
                    harga = ?,
                    satuan = ?,
                    jumlah_min = ?,
                    jumlah_min_a = ?,
                    tgl_update = GETDATE(),
                    project = ?,
                    demand = ?,
                    mc = ?,
                    greige_lbr = ?,
                    greige_grm = ?,
                    kategori_bs = ?
                WHERE id = ?";

    $params = [$nama, $jenis, $harga, $satuan, $minimal, $minatas, $project, $demand, $mc, $greige_lbr, $greige_grm, $kategori_bs, $id];

    $stmt = sqlsrv_query($this->conn, $sql, $params);
    if ($stmt === false)
      die(print_r(sqlsrv_errors(), true));
  }

  // proses delete data barang
  public function hapus_barang($id)
  {
    $sql = "DELETE FROM invgkg.tbl_barang WHERE id = ?";
    $stmt = sqlsrv_query($this->conn, $sql, [$id]);
    if ($stmt === false)
      die(print_r(sqlsrv_errors(), true));
  }

  // tampilkan data dari tabel barang
  public function tampil_data($idsub, $min)
  {
    $where = ($min == "minimal") ? " AND a.jumlah <= a.jumlah_min_a " : " ";

    // SQL Server tidak boleh SELECT a.* dengan GROUP BY a.id, jadi pakai OUTER APPLY ambil 1 baris b
    $sql = "SELECT a.*, b.id AS idb
                FROM invgkg.tbl_barang a
                OUTER APPLY (
                    SELECT TOP 1 id
                    FROM invgkg.tbl_barang_in
                    WHERE id_barang = a.id
                    ORDER BY id DESC
                ) b
                WHERE a.sub_dept = ? AND a.[status] = '1' $where
                ORDER BY a.kode ASC";

    $data = sqlsrv_query($this->conn, $sql, [$idsub]);
    if ($data === false)
      die(print_r(sqlsrv_errors(), true));

    $result = [];
    while ($d = sqlsrv_fetch_array($data, SQLSRV_FETCH_BOTH)) {
      $result[] = $d;
    }
    return $result;
  }

  public function tampil_satuan()
  {
    $sql = "SELECT satuan FROM invgkg.tbl_satuan";
    $query = sqlsrv_query($this->conn, $sql);
    if ($query === false)
      die(print_r(sqlsrv_errors(), true));

    $result = [];
    while ($d = sqlsrv_fetch_array($query, SQLSRV_FETCH_BOTH)) {
      $result[] = $d;
    }
    return $result;
  }

  public function tampil_databarang($idsub)
  {
    $sql = "SELECT * FROM invgkg.tbl_barang WHERE sub_dept = ?";
    $query = sqlsrv_query($this->conn, $sql, [$idsub]);
    if ($query === false)
      die(print_r(sqlsrv_errors(), true));

    $result = [];
    while ($d = sqlsrv_fetch_array($query, SQLSRV_FETCH_BOTH)) {
      $result[] = $d;
    }
    return $result;
  }
}
