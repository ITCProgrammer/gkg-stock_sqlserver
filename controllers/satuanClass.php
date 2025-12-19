<?php
class Satuan extends Database
{
    protected $conn;

    public function __construct()
    {
        // Pastikan Database kamu punya method connectSQLSRV() (sqlsrv_connect)
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

    // tampilkan data dari tabel satuan
    public function tampil_data()
    {
        $sql = "SELECT * FROM invgkg.tbl_satuan";
        $stmt = $this->run($sql);

        $result = [];
        while ($d = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $result[] = $d;
        }
        return $result;
    }

    // proses input data satuan
    public function input_satuan($satu, $ket)
    {
        $sql = "INSERT INTO invgkg.tbl_satuan (satuan, ket)
                VALUES (?, ?)";
        $this->run($sql, [$satu, $ket]);
    }

    // tampilkan data dari tabel satuan yang akan di edit
    public function edit_satuan($id)
    {
        $sql = "SELECT * FROM invgkg.tbl_satuan WHERE id = ?";
        $stmt = $this->run($sql, [$id]);

        $hasil = [];
        while ($x = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $hasil[] = $x;
        }
        return $hasil;
    }

    // proses update data satuan
    public function update_satuan($id, $satu, $ket)
    {
        $sql = "UPDATE invgkg.tbl_satuan
                SET satuan = ?, ket = ?
                WHERE id = ?";
        $this->run($sql, [$satu, $ket, $id]);
    }

    // proses delete data satuan
    public function hapus_satuan($id)
    {
        $sql = "DELETE FROM invgkg.tbl_satuan WHERE id = ?";
        $this->run($sql, [$id]);
    }
}
