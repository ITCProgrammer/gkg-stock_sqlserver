<?php
include_once('../../../config/koneksi.php');
include_once('../../../controllers/barangclass.php');
require('../../../dist/pdf8/fpdf.php');

// koneksi DB (SQL Server)
// kalau Database kamu masih pakai nama connectMySQLi tapi isinya SQLSRV, biarkan.
// tapi idealnya pakai connectSQLSRV().
$db = new Database();
$db->connectMySQLi();
// $db->connectSQLSRV();

$barang = new Barang();

// FIX: amankan GET
$idsub = $_GET['idsub'] ?? '';
$min = $_GET['min'] ?? 0;

class FPDF_AutoWrapTable extends FPDF
{
	// Page header
	private $data = array();
	private $options = array(
		'filename' => '',
		'destinationfile' => '',
		'paper_size' => 'F4',
		'orientation' => 'P'
	);

	function __construct($data = array(), $options = array())
	{
		parent::__construct();
		$this->data = $data;
		$this->options = $options;
	}

	// ===== FIX: convert semua value cell jadi text =====
	function toText($v)
	{
		if ($v instanceof DateTime)
			return $v->format('Y-m-d'); // format yang kamu mau
		if ($v === null)
			return '';
		return (string) $v;
	}

	public function rptDetailData()
	{
		$border = 0;
		$this->AddPage();
		$this->SetAutoPageBreak(true, 60);
		$this->AliasNbPages();

		$h = 5;
		$left = 10;
		$top = 30;

		$this->SetFont('Arial', '', 7);
		$this->SetWidths(array(10, 25, 30, 30, 30, 20, 20, 25));
		$this->SetAligns(array('C', 'C', 'C', 'L', 'L', 'R', 'R', 'C'));

		$no = 1;
		$tsisa = 0;
		$this->SetFillColor(255);

		foreach ($this->data as $baris) {
			if (($baris['jumlah'] ?? 0) <= ($baris['jumlah_min'] ?? 0)) {
				$this->SetTextReds(array('0', '0', '0', '0', '0', '0', 255, '0'));
				$this->SetTextGreens(array('0', '0', '0', '0', '0', '0', 0, '0'));
				$this->SetTextBlues(array('0', '0', '0', '0', '0', '0', 0, '0'));
			} else if (($baris['jumlah'] ?? 0) <= ($baris['jumlah_min_a'] ?? 0)) {
				$this->SetTextReds(array('0', '0', '0', '0', '0', '0', 0, '0'));
				$this->SetTextGreens(array('0', '0', '0', '0', '0', '0', 0, '0'));
				$this->SetTextBlues(array('0', '0', '0', '0', '0', '0', 255, '0'));
			} else {
				$this->SetTextReds(array('0', '0', '0', '0', '0', '0', 0, '0'));
				$this->SetTextGreens(array('0', '0', '0', '0', '0', '0', 0, '0'));
				$this->SetTextBlues(array('0', '0', '0', '0', '0', '0', 0, '0'));
			}

			$jumlahRaw = $baris['jumlah'] ?? 0;
			$hargaRaw = $baris['harga'] ?? 0;

			$jumlahFmt = number_format((float) $jumlahRaw, 2, '.', '');

			if (is_string($jumlahRaw) && preg_match('/^\s*\./', $jumlahRaw)) {
				$jumlahFmt = '0' . ltrim($jumlahRaw);
			}

			$hargaFmt = (float) $hargaRaw; 

			$this->Row(array(
				$no++,
				$baris['tgl_buat'] ?? '',
				$baris['kode'] ?? '',
				$baris['nama'] ?? '',
				$baris['jenis'] ?? '',
				$hargaFmt,
				$jumlahFmt,
				$baris['tgl_update'] ?? ''
			));
			$tsisa = $tsisa + (float) ($baris['jumlah'] ?? 0);
		}

		$this->SetFillColor(200, 200, 200);
		$this->SetFont("", "B", 8);
		$this->Cell(10, $h, '', 1, 0, 'L', true);
		$this->Cell(25, $h, '', 1, 0, 'C', true);
		$this->Cell(30, $h, '', 1, 0, 'C', true);
		$this->Cell(30, $h, '', 1, 0, 'C', true);
		$this->Cell(30, $h, 'Total', 1, 0, 'L', true);
		$this->Cell(20, $h, '', 1, 0, 'C', true);
		$this->Cell(20, $h, number_format($tsisa, '2', '.', ''), 1, 0, 'R', true);
		$this->Cell(25, $h, '', 1, 1, 'C', true);
	}

	public function printPDF()
	{
		$this->rptDetailData();
		$this->Output();
	}

	function Header()
	{
		$this->SetFont('Arial', 'B', 15);
		$this->Cell(55);
		$this->Cell(30, 10, 'PT. Indo Taichen Textile Industry', 0, 0, 'R');
		$this->Ln(10);
		$this->Cell(0, 1, " ", "B");
		$this->SetFont("", "B", 10);

		if (($_GET['idsub'] ?? '') == 'TQ') {
			$this->SetX(15);
			$this->Cell(0, 10, 'LAPORAN DATA STOK TEST QUALITY', 0, 1, 'C');
		} else if (($_GET['idsub'] ?? '') == 'PACKING') {
			$this->SetX(15);
			$this->Cell(0, 10, 'LAPORAN DATA STOK PACKING', 0, 1, 'C');
		} else if (($_GET['idsub'] ?? '') == 'ATK') {
			$this->SetX(15);
			$this->Cell(0, 10, 'LAPORAN DATA STOK ATK', 0, 1, 'C');
		}

		$h = 5;
		$left = 10;
		$top = 30;

		$this->SetFillColor(200, 200, 200);
		$this->SetFont("", "B", 8);
		$this->Cell(0, 0.7, "Di cetak pada : " . date("D-d/m/Y"), 0, 0, 'L');
		$this->Ln(5);

		$left = $this->GetX();
		$this->Cell(20, $h, 'NO', 1, 0, 'L', true);
		$this->SetX($left += 10);
		$this->Cell(25, $h, 'Tanggal', 1, 0, 'C', true);
		$this->SetX($left += 25);
		$this->Cell(30, $h, 'Kode', 1, 0, 'C', true);
		$this->SetX($left += 30);
		$this->Cell(30, $h, 'Nama', 1, 0, 'C', true);
		$this->SetX($left += 30);
		$this->Cell(30, $h, 'Jenis', 1, 0, 'C', true);
		$this->SetX($left += 30);
		$this->Cell(20, $h, 'Harga', 1, 0, 'C', true);
		$this->SetX($left += 20);
		$this->Cell(20, $h, 'Sisa', 1, 0, 'C', true);
		$this->SetX($left += 20);
		$this->Cell(25, $h, 'Tgl Update', 1, 1, 'C', true);

		$this->settitle("Stock Barang - " . ($_GET['idsub'] ?? ''));
	}

	function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Arial', 'I', 8);
		$this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
	}

	private $widths;
	private $aligns;
	private $reds;
	private $greens;
	private $blues;

	function SetWidths($w)
	{
		$this->widths = $w;
	}

	function SetAligns($a)
	{
		$this->aligns = $a;
	}

	function SetTextReds($a)
	{
		$this->reds = $a;
	}

	function SetTextGreens($a)
	{
		$this->greens = $a;
	}

	function SetTextBlues($a)
	{
		$this->blues = $a;
	}

	function Row($data)
	{
		// ===== FIX: paksa semua cell jadi string (hindari DateTime/NULL) =====
		for ($k = 0; $k < count($data); $k++) {
			$data[$k] = $this->toText($data[$k]);
		}

		$nb = 1;
		for ($i = 0; $i < count($data); $i++)
			$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		$h = 5 * $nb;

		$this->CheckPageBreak($h);

		for ($i = 0; $i < count($data); $i++) {
			$w = $this->widths[$i];
			$r = $this->reds[$i] ?? 0;
			$g = $this->greens[$i] ?? 0;
			$b = $this->blues[$i] ?? 0;
			$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

			$x = $this->GetX();
			$y = $this->GetY();

			$this->Rect($x, $y, $w, $h);

			$this->SetTextColor($r, $g, $b);
			$this->MultiCell($w, 5, $data[$i], 0, $a);

			$this->SetXY($x + $w, $y);
		}

		$this->Ln($h);
	}

	function CheckPageBreak($h)
	{
		if ($this->GetY() + $h > $this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w, $txt)
	{
		// ===== FIX: DateTime/NULL -> string sebelum str_replace =====
		if ($txt instanceof DateTime)
			$txt = $txt->format('Y-m-d H:i:s');
		if ($txt === null)
			$txt = '';
		$txt = (string) $txt;

		$cw = &$this->CurrentFont['cw'];
		if ($w == 0)
			$w = $this->w - $this->rMargin - $this->x;
		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;

		$s = str_replace("\r", '', $txt); // <-- ini sekarang aman
		$nb = strlen($s);
		if ($nb > 0 and $s[$nb - 1] == "\n")
			$nb--;

		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
				continue;
			}
			if ($c == ' ')
				$sep = $i;
			$l += $cw[$c] ?? 0;
			if ($l > $wmax) {
				if ($sep == -1) {
					if ($i == $j)
						$i++;
				} else
					$i = $sep + 1;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
			} else
				$i++;
		}
		return $nl;
	}
}

// ambil data dari DB dan masukkan ke array
$data = array();
foreach ($barang->tampil_data($idsub, $min) as $rowd) {
	$data[] = $rowd;
}

// pilihan
$options = array(
	'filename' => '',
	'destinationfile' => '',
	'paper_size' => 'F4',
	'orientation' => 'P'
);

$pdf = new FPDF_AutoWrapTable($data, $options);
$pdf->printPDF();
