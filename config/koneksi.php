<?php

date_default_timezone_set('Asia/Jakarta'); 
//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

/*
class Database
{
    // properti
    private $dbHost="10.0.0.10";
    private $dbUser="dit";
    private $dbPass="4dm1n";
    private $dbName="invqc";

    // method koneksi mysql
    public function connectMySQL()
    {
        mysql_connect($this->dbHost, $this->dbUser, $this->dbPass);
        mysql_select_db($this->dbName) or die("Database Tidak Ditemukan di Server");
    }
}
*/
class Database
{
	
var $sqsrvli="";

function connectMySQLi(){
    
        // $mysqli = new mysqli("10.0.0.10","dit", "4dm1n", "invgkg");
        // //mengecek jika terjadi gagal koneksi
        // if(mysqli_connect_errno()) {
        // 	echo "Error: Could not connect to database. ";
        // 	exit;
        // 	}
        // return $mysqli;

        $server = "10.0.0.221"; 
        $database = "invgkg";
        $username = "sa";
        $password = "Ind@taichen2024";

        $connectionInfo = [
            "Database" => $database,
            "UID" => $username,
            "PWD" => $password,
            "CharacterSet" => "UTF-8",
        ];

        $conn = sqlsrv_connect($server, $connectionInfo);

        if ($conn === false) {
            // tampilkan alasan gagal konek (penting buat debugging)
            die("SQL Server connection failed: " . print_r(sqlsrv_errors(), true));
        }

        return $conn;    	
	}
}