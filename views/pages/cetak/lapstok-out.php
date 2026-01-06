<?php
include_once('../../../config/koneksi.php');
include_once('../../../controllers/barangclass.php');
include_once('../../../controllers/barangkeluarclass.php');
require('../../../dist/pdf8/fpdf.php');
// koneksi ke MySQL via method
$db       = new Database();
$db->connectMySQLi();
$barang   = new Barang();
$barangout = new BarangKeluar();
$idsub    = $_GET['idsub'];
class FPDF_AutoWrapTable extends FPDF
{
// Page header
	private $data = array();
	private $options = array(
  		'filename' => '',
  		'destinationfile' => '',
  		'paper_size'=>'F4',
  		'orientation'=>'P'
  	);
	function __construct($data = array(), $options = array()) {
    	parent::__construct();
    	$this->data = $data;
    	$this->options = $options;
	}
	public function rptDetailData () {
		//
		$border = 0;
		$this->AddPage();
		$this->SetAutoPageBreak(true,60);
		$this->AliasNbPages();
		//$left = 25;
        // $this->settitle("Stock Barang - {$_GET['idsub']}");


		//$this->Ln(10);

		$h = 5;
		$left = 10;
		$top = 30;
		#tableheader

		//$this->Ln(20);

		$this->SetFont('Arial','',8);
		$this->SetWidths(array(10,20,10,30,40,15,15,10,40)); 
		$this->SetAligns(array('C','C','C','L','L','R','R','C','L'));
		$no = 1; 
		$total=0;
		$this->SetFillColor(255);
		foreach ($this->data as $baris) {
			$this->Row(
				array($no++,
        $baris['tanggal'],
				$baris['kode'],
				$baris['nama'],
				$baris['jenis'],
				$baris['harga'],
				$baris['jumlah'],
        $baris['satuan'],
        $baris['note']
			));
      $total=$total+$baris['jumlah'];
		}
		$this->SetFillColor(200,200,200);
    $this->SetFont("", "B", 8);
    $this->Cell(10,$h,'',1,0,'L',true);
    $this->Cell(20, $h, '', 1, 0, 'C',true);
    $this->Cell(10, $h, '', 1, 0, 'C',true);
    $this->Cell(30, $h, '', 1, 0, 'C',true);
		$this->Cell(40, $h, 'Total', 1, 0, 'L',true);
		$this->Cell(15, $h, '', 1, 0, 'C',true);
		$this->Cell(15, $h, number_format($total,'2','.',''), 1, 0, 'R',true);
    $this->Cell(10, $h, '', 1, 0, 'C',true);
    $this->Cell(40, $h, '', 1, 1, 'C',true);
	}
	public function printPDF () {
		//$this->AliasNbPages();
		//$this->AddPage();
		//$this->SetFont('Times','',12);
		$this->rptDetailData();

	    //$this->Output($this->options['filename'],$this->options['destinationfile']);
		$this->Output();
	}
function Header()
{
    // Logo
    //$this->Image('module_table_top.png',10,6,30);
    // Arial bold 15
	$h = 5;
    $left = 10; 
    $top = 30;
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(55); 
    // Title
    $this->Cell(30,10,'PT. Indo Taichen Textile Industry',0,0,'R');	
	$this->Ln(10);
	$this->Cell(0, 1, " ", "B");
	$this->SetFont("", "B", 10);
	if($_GET['idsub'] == 'TQ'){
      $this->SetX($left); $this->Cell(0, 10, 'LAPORAN DATA KELUAR BARANG TEST QUALITY', 0, 1,'C');
      }else if ($_GET['idsub'] == 'PACKING'){
      $this->SetX($left); $this->Cell(0, 10, 'LAPORAN DATA KELUAR BARANG PACKING', 0, 1,'C');
      }else if ($_GET['idsub'] == 'ATK'){
      $this->SetX($left); $this->Cell(0, 10, 'LAPORAN DATA KELUAR BARANG ATK', 0, 1,'C');
      }
      $this->settitle('Stock Barang Keluar');  
        $this->SetFillColor(200,200,200);
        $this->SetFont("", "B", 8);
        $this->Cell(0,0.7,"Di cetak pada : ".date("D-d/m/Y"),0,0,'L');
		$this->Cell(0,0.7,"Periode : ".$_GET['tgl1']." s/d ".$_GET['tgl2'],0,0,'R');
        $this->Ln(5);
    	$left = $this->GetX();
    	$this->Cell(10,$h,'NO',1,0,'L',true);
     	$this->SetX($left += 10); $this->Cell(20, $h, 'Tanggal', 1, 0, 'C',true);
     	$this->SetX($left += 20); $this->Cell(10, $h, 'Kode', 1, 0, 'C',true);
     	$this->SetX($left += 10); $this->Cell(30, $h, 'Nama', 1, 0, 'C',true);
 		$this->SetX($left += 30); $this->Cell(40, $h, 'Jenis', 1, 0, 'C',true);
 		$this->SetX($left += 40); $this->Cell(15, $h, 'Harga', 1, 0, 'C',true);
 		$this->SetX($left += 15); $this->Cell(15, $h, 'Jumlah', 1, 0, 'C',true);
     	$this->SetX($left += 15); $this->Cell(10, $h, 'Unit', 1, 0, 'C',true);
     	$this->SetX($left += 10); $this->Cell(40, $h, 'Note', 1, 1, 'C',true);
	
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
	private $widths;
	private $aligns;

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}

	function Row($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=10*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,10,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}
	
}
#ambil data dari DB dan masukkan ke array
$data = [];

$result = $barangout->tampildataout_tgl($_GET['tgl1'], $_GET['tgl2'], $idsub);

if (!empty($result)) {
	foreach ($result as $rowd) {

		if (isset($rowd['tanggal']) && $rowd['tanggal'] instanceof DateTime) {
			$rowd['tanggal'] = $rowd['tanggal']->format('d-m-Y');
		}

		$data[] = $rowd; 
	}
}

//pilihan
$options = array(
	'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
	'destinationfile' => '', //I=inline browser (default), F=local file, D=download
	'paper_size'=>'F4',	//paper size: F4, A3, A4, A5, Letter, Legal
	'orientation'=>'P' //orientation: P=portrait, L=landscape
);
// Instanciation of inherited class
$pdf = new FPDF_AutoWrapTable($data, $options);
$pdf->printPDF();