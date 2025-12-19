<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class User extends Database
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

    // Proses Login
    public function cek_login($username, $password, $sub)
    {
        $password = md5($password);

        $sql = "SELECT TOP 1 *
                FROM invgkg.tbl_user
                WHERE username = ? AND password = ?";

        $stmt = $this->run($sql, [$username, $password]);
        $user_data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if (!$user_data) {
            return false;
        }

        $role = (($user_data['level'] == 1) || ($user_data['sub_dept'] == $sub)) ? 1 : 0;

        if ($role == 1) {
            $_SESSION['loginQC'] = true;
            $_SESSION['idQC'] = $user_data['id'];
            $_SESSION['userQC'] = $username;
            $_SESSION['passQC'] = $password;
            $_SESSION['fotoQC'] = $user_data['foto'];
            $_SESSION['jabatanQC'] = $user_data['jabatan'];
            $_SESSION['mamberQC'] = $user_data['mamber'];
            $_SESSION['lvlQC'] = $user_data['level'];
            $_SESSION['subQC'] = $sub;
            return true;
        }

        return false;
    }

    // Ambil Sesi
    public function get_sesi()
    {
        return !empty($_SESSION['loginQC']);
    }

    // Logout
    public function user_logout()
    {
        $_SESSION['loginQC'] = false;
        session_destroy();
    }

    // ambil nama
    public function ambilNama($id)
    {
        $sql = "SELECT TOP 1 username FROM invgkg.tbl_user WHERE id = ?";
        $stmt = $this->run($sql, [$id]);
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if ($row) {
            echo ucwords($row['username']);
        }
    }

    // tampilkan data dari tabel users
    public function tampil_data()
    {
        $sql = "SELECT * FROM invgkg.tbl_user";
        $stmt = $this->run($sql);

        $result = [];
        while ($d = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $result[] = $d;
        }
        return $result;
    }

    // proses input data user
    public function input_user($username, $pwd, $level, $status, $mamber, $jabatan, $idsub)
    {
        $sql = "INSERT INTO invgkg.tbl_user
                (username, password, [level], [status], mamber, jabatan, foto, sub_dept)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $this->run($sql, [$username, $pwd, $level, $status, $mamber, $jabatan, 'avatar.png', $idsub]);
    }

    // tampilkan data dari tabel users yang akan di edit
    public function edit_user($id)
    {
        $sql = "SELECT * FROM invgkg.tbl_user WHERE id = ?";
        $stmt = $this->run($sql, [$id]);

        $hasil = [];
        while ($x = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $hasil[] = $x;
        }
        return $hasil;
    }

    // proses update data user
    public function update_user($id, $username, $pwd, $level, $status, $mamber, $jabatan, $idsub)
    {
        $sql = "UPDATE invgkg.tbl_user SET
                    username = ?,
                    password = ?,
                    [level]  = ?,
                    [status] = ?,
                    mamber   = ?,
                    jabatan  = ?,
                    sub_dept = ?
                WHERE id = ?";

        $this->run($sql, [$username, $pwd, $level, $status, $mamber, $jabatan, $idsub, $id]);
    }

    // proses delete data user
    public function hapus_user($id)
    {
        $sql = "DELETE FROM invgkg.tbl_user WHERE id = ?";
        $this->run($sql, [$id]);
    }

    // proses change password
    public function change_password($id, $pwd)
    {
        $sql = "UPDATE invgkg.tbl_user SET password = ? WHERE id = ?";
        $this->run($sql, [$pwd, $id]);
    }
}
