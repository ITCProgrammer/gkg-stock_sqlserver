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
	
var $mysqli="";

function connectMySQLi(){
	//konek ke mysql server
	$mysqli = new mysqli("10.0.0.10","dit", "4dm1n", "invgkg");
	//mengecek jika terjadi gagal koneksi
	if(mysqli_connect_errno()) {
    	echo "Error: Could not connect to database. ";
    	exit;
 		}
	return $mysqli;
	}
}