<?php
session_start();
class User extends Database{
	public function __construct()
    {
        $this->conn = $this->connectMySQLi();
    }
    // Proses Login
    public function cek_login($username, $password, $sub)
    {
        $password = md5($password);
        $sql = ("SELECT * FROM tbl_user WHERE `username`='$username' AND `password`='$password'");
		$result = $this->conn->query($sql);
        $user_data = mysqli_fetch_array($result);
        $no_rows = mysqli_num_rows($result);
        if ($user_data['level'] == 1 or $user_data['sub_dept'] == $sub){
          $role = 1;
        }
        else{
          $role = 0;
        }
        if ($no_rows == 1 and $role == 1) {
            $_SESSION['loginQC'] 	  = true;
            $_SESSION['idQC'] 		  = $user_data['id'];
            $_SESSION['userQC']	    = $username;
            $_SESSION['passQC']	    = $password;
            $_SESSION['fotoQC']	    = $user_data['foto'];
            $_SESSION['jabatanQC']	= $user_data['jabatan'];
            $_SESSION['mamberQC']	  = $user_data['mamber'];
            $_SESSION['lvlQC']      = $user_data['level'];
            $_SESSION['subQC']      = $sub;
            return true;
        } else {
            return false;
        }
    }
    // Ambil Sesi
    public function get_sesi()
    {
        return $_SESSION['loginQC'];
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
        $query = $this->conn->query("SELECT * FROM tbl_user WHERE id='$id'");
        $row = mysqli_fetch_array($query);
        echo ucwords($row['username']);
    }

    // tampilkan data dari tabel users
    public function tampil_data()
    {
        $query=$this->conn->query("SELECT * FROM tbl_user");
        while ($d=mysqli_fetch_array($query)) {
            $result[]=$d;
        }
        return $result;
    }

    // proses input data user
    public function input_user($username, $pwd, $level, $status, $mamber, $jabatan,$idsub)
    {
        $sql 	= "INSERT INTO tbl_user (username,password,level,status,mamber,jabatan,foto,sub_dept)
		VALUES ('$username','$pwd','$level','$status','$mamber','$jabatan','avatar.png','$idsub')";
		$this->conn->query($sql);
    }

    // tampilkan data dari tabel users yang akan di edit
    public function edit_user($id)
    {
        $data=$this->conn->query("SELECT * FROM tbl_user WHERE id='$id'");
        while ($x=mysqli_fetch_array($data)) {
            $hasil[]=$x;
        }
        return $hasil;
    }

    // proses update data user
    public function update_user($id, $username, $pwd, $level, $status, $mamber, $jabatan,$idsub)
    {
        $this->conn->query("UPDATE tbl_user SET
		username='$username',
		password='$pwd',
		level='$level',
		status='$status',
		mamber='$mamber',
		jabatan='$jabatan',
    	sub_dept='$idsub'
		WHERE id='$id'");
    }
    // proses delete data project
    public function hapus_user($id)
    {
        $this->conn->query("DELETE FROM tbl_user where id='$id'");
    }
    // proses change password
    public function change_password($id, $pwd)
    {
        $this->conn->query("UPDATE tbl_user SET
		password='$pwd'
		WHERE id='$id'");
    }
}
