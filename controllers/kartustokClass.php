<?php
class Kartustok extends Database
{
    public function __construct()
    {
        $this->conn = $this->connectMySQLi();
        if ($this->conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    private function norm_table($tabel)
    {
        // cegah injection dari nama tabel (karena nama tabel tidak bisa pakai parameter "?")
        if (!preg_match('/^[A-Za-z0-9_\.]+$/', $tabel)) {
            die("Nama tabel tidak valid");
        }

        // kalau tidak ada schema, pakai dbo.
        if (strpos($tabel, '.') === false) {
            return 'invgkg.' . $tabel;
        }
        return $tabel;
    }

    private function exec($sql, $params = [])
    {
        $stmt = sqlsrv_query($this->conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        return $stmt;
    }

    public function barang($id)
    {
        $stmt = $this->exec("SELECT TOP 1 * FROM invgkg.TBL_BARANG WHERE id = ?", [$id]);
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        return $row;
    }

    public function group_by($tabel, $id_barang, $tgl_awal, $tgl_akhir)
    {
        $tabel = $this->norm_table($tabel);

        $sql = "SELECT tanggal, SUM(jumlah) AS jumlah
                FROM $tabel
                WHERE id_barang = ?
                  AND tanggal BETWEEN ? AND ?
                GROUP BY tanggal";

        $stmt = $this->exec($sql, [$id_barang, $tgl_awal, $tgl_akhir]);

        $output = [];

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $tgl = $row['tanggal'];
            // sqlsrv sering balikin DateTime object untuk kolom date/datetime
            if ($tgl instanceof DateTime) {
                $tgl = $tgl->format('Y-m-d');
            }
            $output[$tgl] = $row['jumlah'];
        }
        return $output;
    }

    function stok_cek($tabel, $id_barang, $tgl_awal)
    {
        $tabel = $this->norm_table($tabel);

        $sql = "SELECT SUM(jumlah) AS jumlah
                FROM $tabel
                WHERE id_barang = ?
                  AND tanggal < ?";

        $stmt = $this->exec($sql, [$id_barang, $tgl_awal]);
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if ($row && $row['jumlah'] !== null) {
            return $row['jumlah'];
        }
        return 0;
    }

    function stok_awal($id_barang, $tgl_awal)
    {

        $awal_in = $this->stok_cek('invgkg.tbl_barang_in', $id_barang, $tgl_awal);
        $awal_out = $this->stok_cek('invgkg.tbl_barang_out', $id_barang, $tgl_awal);
        $awal_stok = $awal_in - $awal_out;
        return $awal_stok;
    }

    function formater($nilaiDecimal)
    {

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
        $stmt = $this->exec("SELECT * FROM invgkg.tbl_barang");

        $result = [];
        while ($d = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $result[] = $d;
        }
        return $result;
    }

    public function note($tabel, $id_barang, $tgl_awal, $tgl_akhir)
    {
        $tabel = $this->norm_table($tabel);

        // di SQL Server: "GROUP BY tanggal" tapi SELECT note => error
        // jadi ambil semua baris, lalu grouping di PHP (output tetap sama)
        $sql = "SELECT tanggal, note
                FROM $tabel
                WHERE id_barang = ?
                  AND tanggal BETWEEN ? AND ?
                ORDER BY tanggal";

        $stmt = $this->exec($sql, [$id_barang, $tgl_awal, $tgl_akhir]);

        $output = [];

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $tgl = $row['tanggal'];
            if ($tgl instanceof DateTime) {
                $tgl = $tgl->format('Y-m-d');
            }
            $output[$tgl][] = $row['note'];
        }
        return $output;
    }
}
