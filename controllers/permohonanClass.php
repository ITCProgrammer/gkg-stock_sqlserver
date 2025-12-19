<?php
class Permohonan extends Database
{
    protected $conn;

    public function __construct()
    {
        $this->conn = $this->connectMySQLi();
        if ($this->conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    private function run($sql, $params = [], $options = [])
    {
        $stmt = sqlsrv_query($this->conn, $sql, $params, $options);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        return $stmt;
    }

    // proses input permohonan
    public function input_permohonan($documentno, $tgl, $dept, $note, $idsub)
    {
        $sql = "INSERT INTO invgkg.tbl_permohonan
                    (documentno, tgl_mohon, dept, note, tgl_buat, tgl_update, sub_dept)
                VALUES
                    (?, ?, ?, ?, GETDATE(), GETDATE(), ?)";
        $this->run($sql, [$documentno, $tgl, $dept, $note, $idsub]);
    }

    // proses input detail permohonan
    public function add_detail_permohonan($id, $kode, $jumlah)
    {
        $sql = "INSERT INTO invgkg.tbl_permohonan_detail
                    (id_mohon, id_kode, jumlah, tgl_update)
                VALUES
                    (?, ?, ?, GETDATE())";
        $this->run($sql, [$id, $kode, $jumlah]);
    }

    // tampilkan data dari tabel permohonan yang akan di edit
    public function edit_permohonan($id)
    {
        $sql = "SELECT * FROM invgkg.tbl_permohonan WHERE id = ?";
        $stmt = $this->run($sql, [$id]);

        $hasil = [];
        while ($x = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $hasil[] = $x;
        }
        return $hasil;
    }

    // proses update data permohonan
    public function update_permohonan($id, $tgl, $note)
    {
        $sql = "UPDATE invgkg.tbl_permohonan
                SET note = ?,
                    tgl_mohon = ?,
                    tgl_update = GETDATE()
                WHERE id = ?";
        $this->run($sql, [$note, $tgl, $id]);
    }

    // proses delete data permohonan
    public function hapus_permohonan($id)
    {
        $sql = "DELETE FROM invgkg.tbl_permohonan WHERE id = ?";
        $this->run($sql, [$id]);
    }

    // tampilkan data dari tabel permohonan
    public function tampil_data($idsub)
    {
        $sql = "SELECT
                    a.*,
                    ISNULL(x.jml, 0) AS jml,
                    x.idb
                FROM invgkg.tbl_permohonan a
                OUTER APPLY (
                    SELECT COUNT(*) AS jml, MAX(b.id) AS idb
                    FROM invgkg.tbl_permohonan_detail b
                    WHERE b.id_mohon = a.id
                ) x
                WHERE a.sub_dept = ?
                ORDER BY a.documentno ASC";

        $stmt = $this->run($sql, [$idsub]);

        $result = [];
        while ($d = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $result[] = $d;
        }
        return $result;
    }

    // tampilkan data dari tabel permohonan detail
    public function show_detail($id)
    {
        $sql = "SELECT
                    b.jumlah AS jml_mohon,
                    c.*
                FROM invgkg.tbl_permohonan a
                INNER JOIN invgkg.tbl_permohonan_detail b ON a.id = b.id_mohon
                INNER JOIN invgkg.tbl_barang c ON c.id = b.id_kode
                WHERE a.id = ?
                ORDER BY b.id ASC";

        $stmt = $this->run($sql, [$id]);

        $hasil = [];
        while ($x = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $hasil[] = $x;
        }
        return $hasil;
    }

    public function tampil_permohonan($id)
    {
        $sql = "SELECT
                    *,
                    CONVERT(VARCHAR(11), tgl_mohon, 106) AS tglmohon
                FROM invgkg.tbl_permohonan
                WHERE id = ?";

        $stmt = $this->run($sql, [$id]);

        $result = [];
        while ($d = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $result[] = $d;
        }
        return $result;
    }

    public function tampil_permohonan_detail($id)
    {
        $sql = "SELECT
                    a.*,
                    b.kode,
                    b.nama,
                    b.satuan,
                    b.jumlah AS stok
                FROM invgkg.tbl_permohonan_detail a
                INNER JOIN invgkg.tbl_barang b ON a.id_kode = b.id
                WHERE a.id_mohon = ?";

        $stmt = $this->run($sql, [$id]);

        $result = [];
        while ($d = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $result[] = $d;
        }
        return $result;
    }
}
