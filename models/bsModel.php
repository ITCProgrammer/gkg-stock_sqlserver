<?php
class Bs extends Database
{
	public function __construct()
	{
		$this->conn = $this->connectMySQLi(); // pastikan method ini ada di Database
	}

	/* =========================
	   Helpers
	========================= */
	private function must($stmt, $context = 'SQL Error')
	{
		if ($stmt === false) {
			die($context . "<pre>" . print_r(sqlsrv_errors(), true) . "</pre>");
		}
		return $stmt;
	}

	private function fetchAll($stmt)
	{
		$rows = [];
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_BOTH)) {
			$rows[] = $row;
		}
		return $rows;
	}

	private function fetchOne($stmt)
	{
		return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	}

	private function toIntList($arr)
	{
		$out = [];
		foreach ((array) $arr as $v) {
			$n = preg_replace('/\D+/', '', (string) $v);
			if ($n !== '')
				$out[] = (int) $n;
		}
		return $out;
	}

	public function barang_array()
	{
		$sql = "SELECT * FROM invgkg.tbl_barang_bs ORDER BY nama, jenis_kain";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql), "Gagal barang_array()");
		$result = [];

		while ($d = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			if (!empty($d['jenis_kain'])) {
				$result[$d['id']] = $d['nama'] . ' /' . $d['jenis_kain'];
			} else {
				$result[$d['id']] = $d['nama'];
			}
		}
		return $result;
	}

	public function bs_suratjalan()
	{
		// SQL Server: tidak bisa SELECT a.* + SUM(...) GROUP BY a.id (kalau a.* banyak kolom)
		$sql = "
            SELECT a.*, x.qty_masuk
            FROM invgkg.tbl_surat_jalan a
            JOIN (
                SELECT surat_jalan_id, SUM(qty_masuk) AS qty_masuk
                FROM invgkg.tbl_surat_jalan_detail
                GROUP BY surat_jalan_id
            ) x ON a.id = x.surat_jalan_id
            ORDER BY a.id DESC
        ";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql), "Gagal bs_suratjalan()");
		return $this->fetchAll($stmt);
	}

	public function bs_suratjalan_array($status)
	{
		if ($status == 'out') {
			$sql = "
                SELECT b.surat_jalan_id, SUM(a.qty_keluar_detail) AS qty
                FROM invgkg.tbl_sj_out_detail a
                JOIN invgkg.tbl_surat_jalan_detail b ON a.detail_id_surat_jalan = b.id
                GROUP BY b.surat_jalan_id
            ";
			$stmt = $this->must(sqlsrv_query($this->conn, $sql), "Gagal bs_suratjalan_array(out)");
			$result = [];
			while ($d = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				$result[$d['surat_jalan_id']] = $d['qty'];
			}
			return $result;
		}

		// kalau status selain 'out' di kode asli memang tidak ada query
		return [];
	}

	public function bs_suratjalan_out()
	{
		$sql = "
            SELECT a.*, x.qty_keluar_detail
            FROM invgkg.tbl_sj_out a
            JOIN (
                SELECT sj_out_id, SUM(qty_keluar_detail) AS qty_keluar_detail
                FROM invgkg.tbl_sj_out_detail
                GROUP BY sj_out_id
            ) x ON a.id = x.sj_out_id
            ORDER BY a.id DESC
        ";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql), "Gagal bs_suratjalan_out()");
		return $this->fetchAll($stmt);
	}

	public function bs_input_sj($tanggal)
	{
		// return last insert id (SQL Server)
		$sql = "INSERT INTO invgkg.tbl_surat_jalan(tanggal) VALUES (?); SELECT SCOPE_IDENTITY()";
		$stmt = sqlsrv_query($this->conn, $sql, [$tanggal]);
		sqlsrv_next_result($stmt); 
		sqlsrv_fetch($stmt); 
		return sqlsrv_get_field($stmt, 0);
	}

	public function bs_input_sj_detail($surat_jalan_id, $barang_bs_id, $qty_masuk, $lokasi_masuk, $project, $demand, $mc, $lbr, $grm)
	{
		$sql = "
            INSERT INTO invgkg.tbl_surat_jalan_detail
                (surat_jalan_id, barang_bs_id, qty_masuk, lokasi_masuk, project, demand, mc, lbr, grm)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";
		$this->must(
			sqlsrv_query($this->conn, $sql, [$surat_jalan_id, $barang_bs_id, $qty_masuk, $lokasi_masuk, $project, $demand, $mc, $lbr, $grm]),
			"Gagal bs_input_sj_detail()"
		);
	}

	public function bs_out()
	{
		$sql = "
            SELECT
                a.*, b.tanggal, c.nama,
                a.qty_masuk - ISNULL(x.qty_keluar, 0) AS qty_sisa,
                c.jenis_kain
            FROM invgkg.tbl_surat_jalan_detail a
            JOIN invgkg.tbl_surat_jalan b ON a.surat_jalan_id = b.id
            JOIN invgkg.tbl_barang_bs c ON a.barang_bs_id = c.id
            LEFT JOIN (
                SELECT detail_id_surat_jalan, SUM(qty_keluar_detail) AS qty_keluar
                FROM invgkg.tbl_sj_out_detail
                GROUP BY detail_id_surat_jalan
            ) x ON a.id = x.detail_id_surat_jalan
            ORDER BY a.id
        ";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql), "Gagal bs_out()");
		return $this->fetchAll($stmt);
	}

	public function bs_out_preview($id_surat_jalan)
	{
		$ids = $this->toIntList($id_surat_jalan);
		if (count($ids) === 0)
			return [];

		$placeholders = implode(',', array_fill(0, count($ids), '?'));

		$sql = "
            SELECT
                a.*, b.tanggal, c.nama,
                a.qty_masuk - ISNULL(x.qty_keluar, 0) AS qty_sisa,
                c.jenis_kain
            FROM invgkg.tbl_surat_jalan_detail a
            JOIN invgkg.tbl_surat_jalan b ON a.surat_jalan_id = b.id
            JOIN invgkg.tbl_barang_bs c ON a.barang_bs_id = c.id
            LEFT JOIN (
                SELECT detail_id_surat_jalan, SUM(qty_keluar_detail) AS qty_keluar
                FROM invgkg.tbl_sj_out_detail
                GROUP BY detail_id_surat_jalan
            ) x ON a.id = x.detail_id_surat_jalan
            WHERE a.id IN ($placeholders)
        ";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql, $ids), "Gagal bs_out_preview()");
		return $this->fetchAll($stmt);
	}

	public function bs_update_detail($id, $sisa, $value, $qty_keluar_sebelumya)
	{
		$qty_sisa = $sisa - $value;
		$qty_keluar = $qty_keluar_sebelumya + $value;

		$sql = "UPDATE invgkg.tbl_surat_jalan_detail SET qty_keluar = ?, qty_sisa = ? WHERE id = ?";
		$this->must(sqlsrv_query($this->conn, $sql, [$qty_keluar, $qty_sisa, $id]), "Gagal bs_update_detail()");
	}

	public function bs_input_sj_out()
	{
		$tanggal = date("Y-m-d H:i");
		$sql = "INSERT INTO invgkg.tbl_sj_out(tanggal) VALUES (?); SELECT SCOPE_IDENTITY() AS id;";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql, [$tanggal]), "Gagal bs_input_sj_out()");
		$row = $this->fetchOne($stmt);
		return $row ? (int) $row['id'] : 0;
	}

	public function bs_update_detail_out($sj_out_id, $detail_id_surat_jalan, $qty_keluar_detail)
	{
		// di kode asli ada variabel $sisa/$value yang tidak ada -> kita abaikan, tetap INSERT sesuai tujuan
		$sql = "INSERT INTO invgkg.tbl_sj_out_detail(sj_out_id, detail_id_surat_jalan, qty_keluar_detail) VALUES (?, ?, ?)";
		$this->must(sqlsrv_query($this->conn, $sql, [$sj_out_id, $detail_id_surat_jalan, $qty_keluar_detail]), "Gagal bs_update_detail_out()");
	}

	public function bs_out_last_detail()
	{
		$sql = "
            SELECT a.*, b.qty_sisa, c.nama, c.jenis_kain
            FROM invgkg.tbl_sj_out_detail a
            JOIN invgkg.tbl_surat_jalan_detail b ON a.detail_id_surat_jalan = b.id
            JOIN invgkg.tbl_barang_bs c ON b.barang_bs_id = c.id
            WHERE a.sj_out_id = (SELECT MAX(sj_out_id) FROM tbl_sj_out_detail)
        ";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql), "Gagal bs_out_last_detail()");
		return $this->fetchAll($stmt);
	}

	public function bs_in_detail($id)
	{
		$sql = "
            SELECT
                a.*, c.nama, c.jenis_kain, b.tanggal,
                ISNULL(x.qty_keluar, 0) AS qty_keluar,
                a.qty_masuk - ISNULL(x.qty_keluar, 0) AS qty_sisa
            FROM invgkg.tbl_surat_jalan_detail a
            JOIN invgkg.tbl_surat_jalan b ON a.surat_jalan_id = b.id
            JOIN invgkg.tbl_barang_bs c ON a.barang_bs_id = c.id
            LEFT JOIN (
                SELECT detail_id_surat_jalan, SUM(qty_keluar_detail) AS qty_keluar
                FROM invgkg.tbl_sj_out_detail
                GROUP BY detail_id_surat_jalan
            ) x ON a.id = x.detail_id_surat_jalan
            WHERE b.id = ?
        ";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql, [$id]), "Gagal bs_in_detail()");
		return $this->fetchAll($stmt);
	}

	public function bs_detail($id)
	{
		$sql = "
            SELECT
                a.*, b.tanggal, c.nama,
                a.qty_masuk - ISNULL(x.qty_keluar, 0) AS qty_sisa,
                c.jenis_kain
            FROM invgkg.tbl_surat_jalan_detail a
            JOIN invgkg.tbl_surat_jalan b ON a.surat_jalan_id = b.id
            JOIN invgkg.tbl_barang_bs c ON a.barang_bs_id = c.id
            LEFT JOIN (
                SELECT detail_id_surat_jalan, SUM(qty_keluar_detail) AS qty_keluar
                FROM invgkg.tbl_sj_out_detail
                GROUP BY detail_id_surat_jalan
            ) x ON a.id = x.detail_id_surat_jalan
            WHERE c.id = ?
            ORDER BY a.id
        ";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql, [$id]), "Gagal bs_detail()");
		return $this->fetchAll($stmt);
	}

	public function bs_in_detail_out($id)
	{
		$sql = "
            SELECT a.*, b.id AS idout_detail, b.qty_keluar_detail, c.lokasi_masuk, d.nama, d.jenis_kain
            FROM invgkg.tbl_sj_out a
            JOIN invgkg.tbl_sj_out_detail b ON a.id = b.sj_out_id
            JOIN invgkg.tbl_surat_jalan_detail c ON b.detail_id_surat_jalan = c.id
            JOIN invgkg.tbl_barang_bs d ON c.barang_bs_id = d.id
            WHERE a.id = ?
            ORDER BY a.id desc, d.jenis_kain desc, b.id asc
        ";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql, [$id]), "Gagal bs_in_detail_out()");
		return $this->fetchAll($stmt);
	}

	public function bs_barang()
	{
		$sql = "
            SELECT a.*, ISNULL(x.qty_masuk, 0) AS qty_masuk
            FROM invgkg.tbl_barang_bs a
            LEFT JOIN (
                SELECT barang_bs_id, SUM(qty_masuk) AS qty_masuk
                FROM invgkg.tbl_surat_jalan_detail
                GROUP BY barang_bs_id
            ) x ON a.id = x.barang_bs_id
            ORDER BY a.nama, a.jenis_kain
        ";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql), "Gagal bs_barang()");
		return $this->fetchAll($stmt);
	}

	public function lokasi_list()
	{
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
		return $codes;
	}

	public function bs_barang_in_out($status)
	{
		if ($status == 'in') {
			$sql = "SELECT barang_bs_id, SUM(qty_masuk) AS qty FROM invgkg.tbl_surat_jalan_detail GROUP BY barang_bs_id";
			$stmt = $this->must(sqlsrv_query($this->conn, $sql), "Gagal bs_barang_in_out(in)");
		} else {
			$sql = "
                SELECT b.barang_bs_id, SUM(a.qty_keluar_detail) AS qty
                FROM invgkg.tbl_sj_out_detail a
                JOIN invgkg.tbl_surat_jalan_detail b ON a.detail_id_surat_jalan = b.id
                GROUP BY b.barang_bs_id
            ";
			$stmt = $this->must(sqlsrv_query($this->conn, $sql), "Gagal bs_barang_in_out(out)");
		}

		$result = [];
		while ($d = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$result[$d['barang_bs_id']] = $d['qty'];
		}
		return $result;
	}

	public function roll_masuk($group)
	{
		$sql = "SELECT barang_bs_id, COUNT(*) AS c FROM invgkg.tbl_surat_jalan_detail GROUP BY barang_bs_id";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql), "Gagal roll_masuk()");
		$result = [];
		while ($d = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$result[$d['barang_bs_id']] = $d['c'];
		}
		return $result;
	}

	public function roll_keluar($group)
	{
		$sql = "
            SELECT a.barang_bs_id, COUNT(*) AS c
            FROM invgkg.tbl_surat_jalan_detail a
            LEFT JOIN invgkg.tbl_sj_out_detail b ON a.id = b.detail_id_surat_jalan
            WHERE b.qty_keluar_detail IS NOT NULL
            GROUP BY a.barang_bs_id
        ";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql), "Gagal roll_keluar()");
		$result = [];
		while ($d = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$result[$d['barang_bs_id']] = $d['c'];
		}
		return $result;
	}

	public function roll_sisa($group)
	{
		// Fix GROUP BY agar valid di SQL Server
		$sql = "
            SELECT
                a.$group,
                a.surat_jalan_id,
                SUM(a.qty_masuk) AS qty_masuk,
                a.lokasi_masuk,
                ISNULL(SUM(b.qty_keluar_detail), 0) AS qty_keluar
            FROM invgkg.tbl_surat_jalan_detail a
            LEFT JOIN invgkg.tbl_sj_out_detail b ON a.id = b.detail_id_surat_jalan
            GROUP BY a.$group, a.surat_jalan_id, a.lokasi_masuk
        ";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql), "Gagal roll_sisa()");
		$result = [];

		while ($d = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$qty_masuk = (float) $d['qty_masuk'];
			$qty_keluar = (float) $d['qty_keluar'];
			if ($qty_keluar < $qty_masuk) {
				$result[$d[$group]][] = $d['lokasi_masuk'];
			}
		}
		return $result;
	}

	public function sj_roll_masuk()
	{
		$sql = "
            SELECT a.surat_jalan_id, COUNT(*) AS c
            FROM invgkg.tbl_surat_jalan_detail a
            LEFT JOIN invgkg.tbl_sj_out_detail b ON a.id = b.detail_id_surat_jalan
            GROUP BY a.surat_jalan_id
        ";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql), "Gagal sj_roll_masuk()");
		$result = [];
		while ($d = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$result[$d['surat_jalan_id']] = $d['c'];
		}
		return $result;
	}

	public function sj_roll_keluar()
	{
		$sql = "
            SELECT a.surat_jalan_id, COUNT(*) AS c
            FROM invgkg.tbl_surat_jalan_detail a
            JOIN invgkg.tbl_sj_out_detail b ON a.id = b.detail_id_surat_jalan
            GROUP BY a.surat_jalan_id
        ";
		$stmt = $this->must(sqlsrv_query($this->conn, $sql), "Gagal sj_roll_keluar()");
		$result = [];
		while ($d = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$result[$d['surat_jalan_id']] = $d['c'];
		}
		return $result;
	}

	public function bs_update_in($id, $value)
	{
		$sql = "UPDATE invgkg.tbl_surat_jalan_detail SET qty_masuk = ? WHERE id = ?";
		$this->must(sqlsrv_query($this->conn, $sql, [$value, $id]), "Gagal bs_update_in()");
	}

	public function bs_delete_in($id)
	{
		$sql = "DELETE FROM invgkg.tbl_surat_jalan_detail WHERE id = ?";
		$this->must(sqlsrv_query($this->conn, $sql, [$id]), "Gagal bs_delete_in()");
	}

	public function bs_delete_out($id)
	{
		$sql = "DELETE FROM invgkg.tbl_sj_out_detail WHERE id = ?";
		$this->must(sqlsrv_query($this->conn, $sql, [$id]), "Gagal bs_delete_out()");
	}
}
?>