<?php
class BarangMasuk extends Database
{
    public function __construct()
    {
        $this->conn = $this->connectMySQLi();
    }

    public function jmlMasuk($idsub)
    {
        $sql = "SELECT count(*) as jml from invgkg.tbl_barang_in WHERE sub_dept = ?";
        $data = sqlsrv_query($this->conn, $sql, [$idsub]);
        if ($data === false)
            die(print_r(sqlsrv_errors(), true));

        $row = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC);
        return $row['jml'] ?? 0;
    }

    public function cektgl($tgl1, $tgl2, $idsub)
    {
        $sql = "SELECT a.kode,a.nama,a.jenis,a.harga,a.satuan,b.tanggal,b.jumlah,b.note,b.userid
                from invgkg.tbl_barang a
                INNER JOIN invgkg.tbl_barang_in b ON a.id=b.id_barang
                WHERE b.tanggal BETWEEN ? AND ? AND a.sub_dept = ?
                ORDER BY a.kode ASC";

        $data = sqlsrv_query($this->conn, $sql, [$tgl1, $tgl2, $idsub]);
        if ($data === false)
            die(print_r(sqlsrv_errors(), true));

        $result = [];
        while ($d = sqlsrv_fetch_array($data, SQLSRV_FETCH_BOTH)) {
            $result[] = $d;
        }
        return $result;
    }

    // tampilkan data dari tabel barang dan tabel barang-in
    public $last_error = null;

    public function tampil_data_in($idsub)
    {
        $sql = "SELECT TOP 600
                a.id as idb ,a.kode,a.nama,a.jenis,a.harga,a.satuan,
                b.id ,b.tanggal,b.jumlah,b.note,b.userid
            FROM invgkg.tbl_barang a
            INNER JOIN invgkg.tbl_barang_in b ON a.id=b.id_barang
            WHERE a.sub_dept = ?
            ORDER BY b.id DESC";

        $data = sqlsrv_query($this->conn, $sql, [$idsub]);

        if ($data === false) {
            $this->last_error = sqlsrv_errors();
            return false; // penting: jangan die
        }

        $result = [];
        while ($d = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)) {
            $result[] = $d;
        }
        return $result;
    }

    // tampilkan data dari tabel barang dan tabel barang-in berdasarkan range tgl masuk
    private function toSqlDate($s)
    {
        // kalau sudah YYYY-MM-DD, biarkan
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $s))
            return $s;

        // kalau format dd/mm/yyyy
        if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $s, $m)) {
            return $m[3] . '-' . $m[2] . '-' . $m[1];
        }
        return $s;
    }

    public function tampildatain_tgl($tgl1, $tgl2, $idsub)
    {
        $tgl1 = $this->toSqlDate($tgl1);
        $tgl2 = $this->toSqlDate($tgl2);

        $sql = "SELECT a.kode,a.nama,a.jenis,a.harga,a.satuan,b.tanggal,b.jumlah,b.note,b.userid
            FROM invgkg.tbl_barang a
            INNER JOIN invgkg.tbl_barang_in b ON a.id=b.id_barang
            WHERE b.tanggal BETWEEN ? AND ? AND a.sub_dept = ?
            ORDER BY a.kode ASC";

        $data = sqlsrv_query($this->conn, $sql, [$tgl1, $tgl2, $idsub]);
        if ($data === false)
            die(print_r(sqlsrv_errors(), true));

        $result = [];
        while ($d = sqlsrv_fetch_array($data, SQLSRV_FETCH_ASSOC)) {
            $result[] = $d;
        }
        return $result;
    }

    // proses input barang
    public function input_barang_in($id, $jumlah, $userid, $note, $idsub)
    {
        $sql1 = "INSERT INTO invgkg.tbl_barang_in(id_barang,tanggal,jumlah,userid,note,sub_dept)
                 VALUES (?,GETDATE(),?,?,?,?)";
        $stmt1 = sqlsrv_query($this->conn, $sql1, [$id, $jumlah, $userid, $note, $idsub]);
        if ($stmt1 === false)
            die(print_r(sqlsrv_errors(), true));

        $sql2 = "UPDATE invgkg.tbl_barang SET jumlah = jumlah + ? WHERE id = ?";
        $stmt2 = sqlsrv_query($this->conn, $sql2, [$jumlah, $id]);
        if ($stmt2 === false)
            die(print_r(sqlsrv_errors(), true));
    }

    // tampilkan data dari tabel barang masuk yang akan di edit
    public function edit_barang_in($id)
    {
        $sql = "SELECT * FROM invgkg.tbl_barang_in WHERE id = ?";
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
    public function update_barang_in($id, $jumlah, $note, $idb, $selisih)
    {
        $sql1 = "UPDATE invgkg.tbl_barang_in SET
                    jumlah = ?,
                    note = ?,
                    tgl_update = GETDATE()
                 WHERE id = ?";
        $stmt1 = sqlsrv_query($this->conn, $sql1, [$jumlah, $note, $id]);
        if ($stmt1 === false)
            die(print_r(sqlsrv_errors(), true));

        $sql2 = "UPDATE invgkg.tbl_barang SET jumlah = jumlah - ? WHERE id = ?";
        $stmt2 = sqlsrv_query($this->conn, $sql2, [$selisih, $idb]);
        if ($stmt2 === false)
            die(print_r(sqlsrv_errors(), true));
    }

    // proses delete data barang-in
    public function hapus_barang_in($id, $idb, $jumlah)
    {
        // bersihkan kalau ada trailing slash / karakter aneh
        $id = preg_replace('/\D+/', '', (string) $id);
        $idb = preg_replace('/\D+/', '', (string) $idb);

        // jumlah boleh decimal? kalau integer saja, pakai (int)
        $jumlah = str_replace(',', '.', (string) $jumlah); // jaga-jaga kalau input "1,5"
        if ($id === '' || $idb === '' || !is_numeric($jumlah)) {
            die("Parameter tidak valid. id={$id}, idb={$idb}, jumlah={$jumlah}");
        }

        $id = (int) $id;
        $idb = (int) $idb;
        $jumlah = (float) $jumlah; // kalau memang integer, ganti jadi (int)$jumlah

        $sql1 = "DELETE FROM invgkg.tbl_barang_in WHERE id = ?";
        $stmt1 = sqlsrv_query($this->conn, $sql1, [$id]);
        if ($stmt1 === false)
            die(print_r(sqlsrv_errors(), true));

        $sql2 = "UPDATE invgkg.tbl_barang SET jumlah = jumlah - ? WHERE id = ?";
        $stmt2 = sqlsrv_query($this->conn, $sql2, [$jumlah, $idb]);
        if ($stmt2 === false)
            die(print_r(sqlsrv_errors(), true));
    }


    public function show_data_inid($id)
    {
        $id = (int) $id;
        $sql = "SELECT TOP 1 id_barang FROM invgkg.tbl_barang_in WHERE id = ?";
        $stmt = sqlsrv_query($this->conn, $sql, [$id]);
        if ($stmt === false)
            die(print_r(sqlsrv_errors(), true));

        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        return $row ? (int) $row['id_barang'] : 0;
    }

    public function show_data_injml($id)
    {
        $id = (int) $id;
        $sql = "SELECT TOP 1 jumlah FROM invgkg.tbl_barang_in WHERE id = ?";
        $stmt = sqlsrv_query($this->conn, $sql, [$id]);
        if ($stmt === false)
            die(print_r(sqlsrv_errors(), true));

        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        return $row ? (float) $row['jumlah'] : 0;
    }
    public function show_detail_barang_masuk($id)
    {
        $dbg = isset($_GET['dbg']) && $_GET['dbg'] == '1';

        $rawId = $id;
        $id = (int) preg_replace('/\D+/', '', (string) $id);

        $sql = "SELECT a.*, b.tanggal, b.jumlah as jml, b.note, b.userid
            FROM invgkg.tbl_barang a
            INNER JOIN invgkg.tbl_barang_in b ON a.id=b.id_barang
            WHERE b.id_barang = ?
            ORDER BY a.kode ASC";

        $params = [$id];

        if ($dbg) {
            echo "<pre>";
            echo "=== DEBUG show_detail_barang_masuk ===\n";
            echo "rawId   : " . print_r($rawId, true) . "\n";
            echo "cleanId : " . $id . "\n";
            echo "SQL     : " . $sql . "\n";
            echo "params  : " . print_r($params, true) . "\n";
            echo "</pre>";
        }

        $query = sqlsrv_query($this->conn, $sql, $params);

        if ($query === false) {
            if ($dbg) {
                echo "<pre>SQLSRV ERRORS:\n" . print_r(sqlsrv_errors(), true) . "</pre>";
                return [];
            }
            die(print_r(sqlsrv_errors(), true));
        }

        $hasil = [];
        while ($x = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
            $hasil[] = $x;
        }

        if ($dbg) {
            echo "<pre>";
            echo "rows: " . count($hasil) . "\n";
            if (count($hasil) > 0) {
                echo "first row keys:\n";
                echo print_r(array_keys($hasil[0]), true);
                echo "\nfirst row sample:\n";
                echo print_r($hasil[0], true);
                echo "\n(tanggal type): " . (isset($hasil[0]['tanggal']) ? gettype($hasil[0]['tanggal']) : 'N/A') . "\n";
                if (isset($hasil[0]['tanggal']) && $hasil[0]['tanggal'] instanceof DateTime) {
                    echo "tanggal formatted: " . $hasil[0]['tanggal']->format('Y-m-d H:i:s') . "\n";
                }
            }
            echo "</pre>";
        }

        return $hasil;
    }

}
