<?php 


class Bs extends Database{
	public function __construct()
    {
        $this->conn = $this->connectMySQLi();
    }
	public function barang_array(){
		$query = $this->conn->query("SELECT * from tbl_barang_bs order by nama, jenis_kain");
		while ($d=mysqli_fetch_array($query)) {
		  if ($d['jenis_kain']) {
			   $result[$d['id']]= $d['nama'].' /'.$d['jenis_kain'];
		  } else {
			   $result[$d['id']]= $d['nama'];
		  }
         
      }
      return $result;
    }
	public function bs_suratjalan() {
		$query = $this->conn->query("select a.* , sum(b.qty_masuk) as qty_masuk	
				from tbl_surat_jalan a
				join tbl_surat_jalan_detail b on (a.id = b.surat_jalan_id)
				group by a.id
				order by a.id desc");
		$result = [];
		while ($d=mysqli_fetch_array($query)) {
          $result[]=$d;
      }
      return $result;
	}
	
	public function bs_suratjalan_array($status) {
		if ($status=='out') {
			$query = $this->conn->query("select b.surat_jalan_id, sum(a.qty_keluar_detail) as qty
					from tbl_sj_out_detail a
					join tbl_surat_jalan_detail b on (a.detail_id_surat_jalan = b.id)
					group by b.surat_jalan_id");
		} 
		$result = [];
		while ($d=mysqli_fetch_array($query)) {
		$result[$d['surat_jalan_id']]=$d['qty'];
		}
		return $result ;
	}
	
		public function bs_suratjalan_out() {
			
		$query = $this->conn->query("select a.* , sum(b.qty_keluar_detail) as qty_keluar_detail
		from tbl_sj_out a
		join tbl_sj_out_detail b on (a.id = b.sj_out_id)
		join tbl_surat_jalan_detail c on (b.detail_id_surat_jalan = c.id)
		group by a.id
		order by id desc");
		while ($d=mysqli_fetch_array($query)) {
          $result[]=$d;
      }
      return $result;
	}
	
	public function bs_input_sj($tanggal)
    {
        $sql="INSERT INTO tbl_surat_jalan(tanggal)
			  VALUES ('$tanggal')";
		$this->conn->query($sql);
		return mysqli_insert_id($this->conn);
    }
	
	 public function bs_input_sj_detail($surat_jalan_id,$barang_bs_id,$qty_masuk,$lokasi_masuk,$project,$demand,$mc,$lbr,$grm)
    {
        $sql="INSERT INTO tbl_surat_jalan_detail(surat_jalan_id,barang_bs_id,qty_masuk, lokasi_masuk,project,demand,mc,lbr,grm)
		VALUES ('$surat_jalan_id','$barang_bs_id','$qty_masuk','$lokasi_masuk','$project','$demand','$mc','$lbr','$grm')";
		$this->conn->query($sql);
    }
	
	public function bs_out() {
		$query = $this->conn->query("select a.* , b.tanggal, c.nama, a.qty_masuk - COALESCE(SUM(d.qty_keluar_detail), 0) as qty_sisa, c.jenis_kain
				from tbl_surat_jalan_detail a
				join tbl_surat_jalan b on (a.surat_jalan_id = b.id)
				join tbl_barang_bs c on (a.barang_bs_id = c.id) 
				left join tbl_sj_out_detail d on (a.id = d.detail_id_surat_jalan)
				group by a.id
				order by a.id");
		while ($d=mysqli_fetch_array($query)) {
          $result[]=$d;
      }
      return $result;
	}
	
	public function bs_out_preview($id_surat_jalan) {
	

		// Generate a comma-separated string from the array values
		$id_surat_jalan_str = implode(',', $id_surat_jalan);

		$query = $this->conn->query("select a.* , b.tanggal, c.nama,a.qty_masuk - COALESCE(SUM(d.qty_keluar_detail), 0) as qty_sisa, c.jenis_kain
				from tbl_surat_jalan_detail a
				join tbl_surat_jalan b on (a.surat_jalan_id = b.id)
				join tbl_barang_bs c on (a.barang_bs_id = c.id) 
				left join tbl_sj_out_detail d on (a.id = d.detail_id_surat_jalan)
				where a.id in ($id_surat_jalan_str)
				group by a.id
				")
				
				;
		while ($d=mysqli_fetch_array($query)) {
          $result[]=$d;
      }
      return $result;
	}
	
	public function bs_update_detail($id,$sisa,$value,$qty_keluar_sebelumya)
    {	$qty_sisa = $sisa  - $value ; 
		//get nilai qty_keluar_sebelumnya 
		$qty_keluar = $qty_keluar_sebelumya+$value;
        $sql="update tbl_surat_jalan_detail set qty_keluar = '$qty_keluar', qty_sisa = '$qty_sisa' where id = '$id' ";
		$this->conn->query($sql);
    }
	
	public function bs_input_sj_out()
    {	
		$tanggal = date("Y-m-d h:i");
        $sql="INSERT INTO tbl_sj_out(tanggal)
			  VALUES ('$tanggal')";
		$this->conn->query($sql);
		return mysqli_insert_id($this->conn);
    }
	
	public function bs_update_detail_out($sj_out_id,$detail_id_surat_jalan,$qty_keluar_detail)
    {	$qty_sisa = $sisa  - $value ; 
         $sql="INSERT INTO tbl_sj_out_detail(sj_out_id,detail_id_surat_jalan,qty_keluar_detail)
		 VALUES ('$sj_out_id','$detail_id_surat_jalan','$qty_keluar_detail')";
		$this->conn->query($sql);
    }
	
	public function bs_out_last_detail() {
		$query = $this->conn->query("select a.* , b.qty_sisa, c.nama, c.jenis_kain
					from tbl_sj_out_detail a
					join tbl_surat_jalan_detail b on (a.detail_id_surat_jalan = b.id )
					join  tbl_barang_bs c on (b.barang_bs_id = c.id)
					where a.sj_out_id = (select max(sj_out_id) from  tbl_sj_out_detail)
					");
		while ($d=mysqli_fetch_array($query)) {
          $result[]=$d;
      }
      return $result;
	}
	
	public function bs_in_detail($id) {
		$query = $this->conn->query("select a.*, c.nama, c.jenis_kain, b.tanggal, 
					COALESCE(SUM(d.qty_keluar_detail), 0) AS qty_keluar,
					a.qty_masuk - COALESCE(SUM(d.qty_keluar_detail), 0) AS qty_sisa
					from tbl_surat_jalan_detail a
					join tbl_surat_jalan b on (a.surat_jalan_id = b.id)
					join   tbl_barang_bs c on (a.barang_bs_id = c.id)
					left join tbl_sj_out_detail d on (a.id = d.detail_id_surat_jalan)
					
					where b.id = '$id'
					group by a.id
					");
		while ($d=mysqli_fetch_array($query)) {
          $result[]=$d;
      }
      return $result;
	}
	
	public function bs_detail($id) {
			$query = $this->conn->query("select a.* , b.tanggal, c.nama, a.qty_masuk - COALESCE(SUM(d.qty_keluar_detail), 0) as qty_sisa, c.jenis_kain
				from tbl_surat_jalan_detail a
				join tbl_surat_jalan b on (a.surat_jalan_id = b.id)
				join tbl_barang_bs c on (a.barang_bs_id = c.id) 
				left join tbl_sj_out_detail d on (a.id = d.detail_id_surat_jalan)
				where c.id = '$id'
				group by a.id
				order by a.id");
		while ($d=mysqli_fetch_array($query)) {
          $result[]=$d;
      }
      return $result;
	}
	
	public function bs_in_detail_out($id) {
		$query = $this->conn->query("select a.* , b.id as idout_detail, b.qty_keluar_detail, c.lokasi_masuk, d.nama, d.jenis_kain
from tbl_sj_out a
join tbl_sj_out_detail b on (a.id = b.sj_out_id)
join tbl_surat_jalan_detail c on (b.detail_id_surat_jalan = c.id)
join tbl_barang_bs d on (c.barang_bs_id   = d.id)
where a.id = '$id'
order by id desc");
		while ($d=mysqli_fetch_array($query)) {
          $result[]=$d;
      }
      return $result;
	}
	
	public function bs_barang() {
		$query = $this->conn->query("SELECT
    a.*,
    COALESCE(SUM(b.qty_masuk), 0) AS qty_masuk
FROM
    tbl_barang_bs a
LEFT JOIN tbl_surat_jalan_detail b ON (a.id = b.barang_bs_id)
GROUP BY
    a.id
ORDER BY
    a.nama, a.jenis_kain
");
		while ($d=mysqli_fetch_array($query)) {
          $result[]=$d;
      }
      return $result;
	}
	
public function lokasi_list() {
$codes = [
'A07BP1A',
'A07BP1B',
'A07BP1T',
'A07BP2A',
'A07BP2B',
'A07BP2T',
'A07BP3A',
'A07BP3B',
'A07BP3T',
'A07BP4A',
'A07BP4B',
'A07BP4T',
'A07BP5A',
'A07BP5B',
'A07BP5T',
'A07BP6A',
'A07BP6B',
'A07BP6T',
'A07BP7A',
'A07BP7B',
'A07BP7T',
'A08BP1A',
'A08BP1B',
'A08BP1T',
'A08BP2A',
'A08BP2B',
'A08BP2T',
'A08BP3A',
'A08BP3B',
'A08BP3T',
];

// Menampilkan isi array
return $codes;



	}
	 
public function bs_barang_in_out($status) {
		if ($status=='in') {
			$query = $this->conn->query("select barang_bs_id, sum(qty_masuk) as qty
									from tbl_surat_jalan_detail
									group by barang_bs_id");
		} else {
			$query = $this->conn->query("select b.barang_bs_id, sum(a.qty_keluar_detail) as qty
					from tbl_sj_out_detail a
					join tbl_surat_jalan_detail b on (a.detail_id_surat_jalan = b.id)
					group by b.barang_bs_id");
		}
		$result=[];
		while ($d=mysqli_fetch_array($query)) {
		$result[$d['barang_bs_id']]=$d['qty'];
		}
		return $result ; 
}

public function roll_masuk($group) {

		$query = $this->conn->query("select barang_bs_id, count(*) as c
					from tbl_surat_jalan_detail
			group by barang_bs_id");
		$result=[];
		while ($d=mysqli_fetch_array($query)) {
			$result[$d['barang_bs_id']]=$d['c'];
		}
		return $result ; 
}

public function roll_keluar($group) {

		$query = $this->conn->query("select a.barang_bs_id, count(*) as c
				from tbl_surat_jalan_detail a
				left join tbl_sj_out_detail b on (a.id = b.detail_id_surat_jalan)
				where b.qty_keluar_detail is not null 
				group by a.barang_bs_id");
		$result=[];
		while ($d=mysqli_fetch_array($query)) {
		$result[$d['barang_bs_id']]=$d['c'];
		}
		return $result ; 
}

public function roll_sisa($group) {

		$query = $this->conn->query("select a.barang_bs_id,a.surat_jalan_id,  sum(a.qty_masuk) as qty_masuk , a.lokasi_masuk, COALESCE(SUM(b.qty_keluar_detail), 0) AS qty_keluar
									from tbl_surat_jalan_detail a
									left join tbl_sj_out_detail b on (a.id = b.detail_id_surat_jalan)
									group by a.$group , a.lokasi_masuk");
		$result=[];
		while ($d=mysqli_fetch_array($query)) {
		$qty_masuk  = $d['qty_masuk'];
		$qty_keluar = $d['qty_keluar']; 
		if ($qty_keluar  < $qty_masuk ) {
			$result[$d[$group]][]=$d['lokasi_masuk'];
		} 
		
		}
		return $result ; 
}



/////////////////////////////////////////////////////////////////


public function sj_roll_masuk() {

		$query = $this->conn->query("select a.surat_jalan_id, count(*) as c
			from tbl_surat_jalan_detail a
			left join tbl_sj_out_detail b on (a.id= b.detail_id_surat_jalan)
			group by a.surat_jalan_id");
		$result=[];
		while ($d=mysqli_fetch_array($query)) {
			$result[$d['surat_jalan_id']]=$d['c'];
		}
		return $result ; 
}


public function sj_roll_keluar() {

		$query = $this->conn->query("select a.surat_jalan_id, count(*) as c
			from tbl_surat_jalan_detail a
			join tbl_sj_out_detail b on (a.id= b.detail_id_surat_jalan)
			group by a.surat_jalan_id");
		$result=[];
		while ($d=mysqli_fetch_array($query)) {
			$result[$d['surat_jalan_id']]=$d['c'];
		}
		return $result ; 
}

	public function bs_update_in($id,$value)
    {	
        $sql="update tbl_surat_jalan_detail set qty_masuk = '$value'  where id = '$id' ";
		$this->conn->query($sql);
    }
	
	public function bs_delete_in($id)
    {	
        $sql="delete from tbl_surat_jalan_detail where id = '$id' ";
		$this->conn->query($sql);
    }
	
	public function bs_delete_out($id)
    {	
        $sql="delete from tbl_sj_out_detail where id = '$id' ";
		$this->conn->query($sql);
    }
	
	
	











	
	
	
	

  
}


?>