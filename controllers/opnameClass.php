<?php
class Opname extends Database
{
  public function __construct()
  {
    $this->conn = $this->connectMySQLi(); // koneksi sqlsrv (resource)
  }

  // ===== helper error handling =====
  private function fail($title = 'SQL Server Error')
  {
    $errors = sqlsrv_errors(SQLSRV_ERR_ALL);
    $msg = $title . "\n";

    if ($errors) {
      foreach ($errors as $e) {
        $msg .= "SQLSTATE: {$e['SQLSTATE']} | Code: {$e['code']} | Message: {$e['message']}\n";
      }
    } else {
      $msg .= "No sqlsrv_errors() returned.\n";
    }

    die($msg);
  }

  private function must($ok, $title)
  {
    if ($ok === false || $ok === null) {
      $this->fail($title);
    }
    return $ok;
  }
  // ===== end helper =====

  public function input_opname($idsub, $awal, $akhir, $note, $userid)
  {
    // insert header opname
    $sqlIns = "INSERT INTO invgkg.tbl_opname(tgl_awal,tgl_akhir,note,userid,tgl_buat,tgl_update,sub_dept)
               VALUES(?,?,?,?,GETDATE(),GETDATE(),?)";
    $this->must(
      sqlsrv_query($this->conn, $sqlIns, [$awal, $akhir, $note, $userid, $idsub]),
      "Gagal INSERT invgkg.tbl_opname"
    );

    // ambil id opname yang barusan
    $sqlGet = "SELECT TOP 1 * FROM invgkg.tbl_opname
               WHERE tgl_awal = ? AND tgl_akhir = ? AND sub_dept = ?
               ORDER BY id DESC";
    $stmtGet = $this->must(
      sqlsrv_query($this->conn, $sqlGet, [$awal, $akhir, $idsub]),
      "Gagal SELECT invgkg.tbl_opname (ambil id terbaru)"
    );

    $dt = sqlsrv_fetch_array($stmtGet, SQLSRV_FETCH_ASSOC);
    if (!$dt) {
      $this->fail("Data opname tidak ditemukan setelah INSERT (cek SELECT TOP 1)");
    }

    // data detail opname
    $sqlData = "SELECT
                    a.id,a.kode,a.nama,a.jenis,
                    ISNULL(d.stokawal,0) as stokawal,
                    CASE WHEN b.stok_in  > 0 THEN b.stok_in  ELSE 0 END as stokin,
                    CASE WHEN c.stok_out > 0 THEN c.stok_out ELSE 0 END as stokout,
                    (
                        (CASE WHEN b.stok_in  > 0 THEN b.stok_in  ELSE 0 END)
                        - (CASE WHEN c.stok_out > 0 THEN c.stok_out ELSE 0 END)
                        + ISNULL(d.stokawal,0)
                    ) as stok_akhir,
                    a.sub_dept
                FROM invgkg.tbl_barang a
                LEFT JOIN (
                    SELECT SUM(jumlah) AS stok_in, id_barang
                    FROM invgkg.tbl_barang_in
                    WHERE tanggal BETWEEN ? AND ?
                    GROUP BY id_barang
                ) b ON a.id = b.id_barang
                LEFT JOIN (
                    SELECT SUM(jumlah) AS stok_out, id_barang
                    FROM invgkg.tbl_barang_out
                    WHERE tanggal BETWEEN ? AND ?
                    GROUP BY id_barang
                ) c ON a.id = c.id_barang
                LEFT JOIN (
                    SELECT a2.sub_dept, b2.stok_akhir as stokawal, b2.idb
                    FROM invgkg.tbl_opname a2
                    INNER JOIN invgkg.tbl_opname_detail b2 ON a2.id=b2.id_opname
                    WHERE a2.sub_dept = ?
                      AND DATEADD(DAY, 1, a2.tgl_akhir) = ?
                ) d ON a.id = d.idb
                WHERE a.sub_dept = ?
                  AND a.status = '1'";

    $paramsData = [$awal, $akhir, $awal, $akhir, $idsub, $awal, $idsub];
    $data = $this->must(
      sqlsrv_query($this->conn, $sqlData, $paramsData),
      "Gagal SELECT data detail opname"
    );

    while ($d = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)) {
      $sqlDet = "INSERT INTO invgkg.tbl_opname_detail(id_opname,idb,kode,nama,jenis,stok_awal,stok_in,stok_out,stok_akhir)
                 VALUES (?,?,?,?,?,?,?,?,?)";

      $paramsDet = [
        $dt['id'],
        $d['id'],
        $d['kode'],
        $d['nama'],
        $d['jenis'],
        $d['stokawal'],
        $d['stokin'],
        $d['stokout'],
        $d['stok_akhir']
      ];

      $this->must(
        sqlsrv_query($this->conn, $sqlDet, $paramsDet),
        "Gagal INSERT invgkg.tbl_opname_detail"
      );
    }
  }

  public function ambilTgl($idsub)
  {
    $sql = "SELECT TOP 1 tgl_akhir FROM invgkg.tbl_opname WHERE sub_dept = ? ORDER BY id DESC";
    $query = $this->must(
      sqlsrv_query($this->conn, $sql, [$idsub]),
      "Gagal SELECT ambilTgl()"
    );

    $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
    return $row['tgl_akhir'] ?? null;
  }
  public function tampildata($idsub)
  {
    $sql = "SELECT
              a.id, a.tgl_awal, a.tgl_akhir,
              ISNULL(SUM(b.stok_awal),0)  AS stokawal,
              ISNULL(SUM(b.stok_in),0)    AS stokin,
              ISNULL(SUM(b.stok_out),0)   AS stokout,
              ISNULL(SUM(b.stok_akhir),0) AS stokakhir,
              a.note, a.userid
          FROM invgkg.tbl_opname a
          INNER JOIN invgkg.tbl_opname_detail b ON a.id=b.id_opname
          WHERE a.sub_dept = ?
          GROUP BY a.id,a.tgl_awal,a.tgl_akhir,a.note,a.userid
          ORDER BY a.id DESC";

    $query = $this->must(
      sqlsrv_query($this->conn, $sql, [$idsub]),
      "Gagal SELECT tampildata()"
    );

    $result = [];
    while ($d = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
      $result[] = $d;
    }
    return $result;
  }


  // proses delete data opname
  public function hapus_opname($id)
  {
    $this->must(
      sqlsrv_query($this->conn, "DELETE FROM invgkg.tbl_opname WHERE id = ?", [$id]),
      "Gagal DELETE invgkg.tbl_opname"
    );

    $this->must(
      sqlsrv_query($this->conn, "DELETE FROM invgkg.tbl_opname_detail WHERE id_opname = ?", [$id]),
      "Gagal DELETE invgkg.tbl_opname_detail"
    );
  }

  public function tampilreport($idsub, $awal, $akhir)
  {
    $sql = "SELECT
                b.nama,
                b.jenis,
                b.stok_awal,
                b.stok_in,
                b.stok_out,
                b.stok_akhir,
                c.jumlah AS aktual
            FROM invgkg.tbl_opname a
            INNER JOIN invgkg.tbl_opname_detail b ON a.id = b.id_opname
            LEFT JOIN (
                SELECT id, jumlah
                FROM invgkg.tbl_barang
                WHERE sub_dept = ?
                  AND status = '1'
            ) c ON b.idb = c.id
            WHERE a.tgl_awal = ?
              AND a.tgl_akhir = ?
              AND a.sub_dept = ?
            ORDER BY b.id ASC";

    $query = $this->must(
      sqlsrv_query($this->conn, $sql, [$idsub, $awal, $akhir, $idsub]),
      "Gagal SELECT tampilreport()"
    );

    $result = [];
    while ($d = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
      $result[] = $d;
    }
    return $result;
  }
}
