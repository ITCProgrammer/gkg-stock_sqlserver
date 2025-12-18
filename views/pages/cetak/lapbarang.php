<?php
include_once('../../../config/koneksi.php');
include_once('../../../controllers/barangclass.php');
require('../../../dist/pdf8/fpdf.php');
// koneksi ke MySQL via method
$db       = new Database();
$db->connectMySQLi();
$barang   = new Barang();
$idsub    = $_GET['idsub'];
$min      = $_GET['min'];
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

		$this->SetFont('Arial','',7);
		$this->SetWidths(array(10,25,30,30,30,20,20,25));
		$this->SetAligns(array('C','C','C','L','L','R','R','C'));
    	$no = 1;
		$tsisa=0;	
    	$this->SetFillColor(255);
    	foreach ($this->data as $baris) {
    	if($baris['jumlah']<=$baris['jumlah_min']){
      		$this->SetTextReds(array('0','0','0','0','0','0',255,'0'));
			$this->SetTextGreens(array('0','0','0','0','0','0',0,'0'));
      		$this->SetTextBlues(array('0','0','0','0','0','0',0,'0'));
    	}else if($baris['jumlah']<=$baris['jumlah_min_a']){
      		$this->SetTextReds(array('0','0','0','0','0','0',0,'0'));
      		$this->SetTextGreens(array('0','0','0','0','0','0',0,'0'));
      		$this->SetTextBlues(array('0','0','0','0','0','0',255,'0'));
    	}else{
      $this->SetTextReds(array('0','0','0','0','0','0',0,'0'));
      $this->SetTextGreens(array('0','0','0','0','0','0',0,'0'));
      $this->SetTextBlues(array('0','0','0','0','0','0',0,'0'));
    }	
		$this->Row(
				array($no++,
        $baris['tgl_buat'],
				$baris['kode'],
				$baris['nama'],
				$baris['jenis'],
				$baris['harga'],
				$baris['jumlah'],
        $baris['tgl_update']
			));
      $tsisa=$tsisa+$baris['jumlah'];
		}
    $this->SetFillColor(200,200,200);
    $this->SetFont("", "B", 8);
    $this->Cell(10,$h,'',1,0,'L',true);
    $this->Cell(25, $h, '', 1, 0, 'C',true);
    $this->Cell(30, $h, '', 1, 0, 'C',true);
    $this->Cell(30, $h, '', 1, 0, 'C',true);
	$this->Cell(30, $h, 'Total', 1, 0, 'L',true);
	$this->Cell(20, $h, '', 1, 0, 'C',true);
    $this->Cell(20, $h, number_format($tsisa,'2','.',''), 1, 0, 'R',true);
    $this->Cell(25, $h, '', 1, 1, 'C',true);
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
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(55);
    // Title
    $this->Cell(30,10,'PT. Indo Taichen Textile Industry',0,0,'R');	
	$this->Ln(10);
	$this->Cell(0, 1, " ", "B");
	$this->SetFont("", "B", 10);
		if($_GET['idsub'] == 'TQ'){
    		$this->SetX(15); $this->Cell(0, 10, 'LAPORAN DATA STOK TEST QUALITY', 0, 1,'C');
        }else if ($_GET['idsub'] == 'PACKING'){
        $this->SetX(15); $this->Cell(0, 10, 'LAPORAN DATA STOK PACKING', 0, 1,'C');
        }else if ($_GET['idsub'] == 'ATK'){
        $this->SetX(15); $this->Cell(0, 10, 'LAPORAN DATA STOK ATK', 0, 1,'C');
        }
        $h = 5;
    	$left = 10;
    	$top = 30;
        $this->SetFillColor(200,200,200);
        $this->SetFont("", "B", 8);
        $this->Cell(0,0.7,"Di cetak pada : ".date("D-d/m/Y"),0,0,'L');
        $this->Ln(5);
    	$left = $this->GetX();
    	$this->Cell(20,$h,'NO',1,0,'L',true);
        $this->SetX($left += 10); $this->Cell(25, $h, 'Tanggal', 1, 0, 'C',true);
        $this->SetX($left += 25); $this->Cell(30, $h, 'Kode', 1, 0, 'C',true);
        $this->SetX($left += 30); $this->Cell(30, $h, 'Nama', 1, 0, 'C',true);
    	$this->SetX($left += 30); $this->Cell(30, $h, 'Jenis', 1, 0, 'C',true);
    	$this->SetX($left += 30); $this->Cell(20, $h, 'Harga', 1, 0, 'C',true);
    	$this->SetX($left += 20); $this->Cell(20, $h, 'Sisa', 1, 0, 'C',true);
        $this->SetX($left += 20); $this->Cell(25, $h, 'Tgl Update', 1, 1, 'C',true);
		$this->settitle("Stock Barang - {$_GET['idsub']}");
	
	
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
  function SetTextReds($a)
	{
		//Set the array of color
		$this->reds=$a;
	}
  function SetTextGreens($a)
	{
		//Set the array of color
		$this->greens=$a;
	}
  function SetTextBlues($a)
	{
		//Set the array of color
		$this->blues=$a;
	}

	function Row($data)
	{
		//Calculate the height of the row
		$nb=1;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
      $r=$this->reds[$i];
      $g=$this->greens[$i];
      $b=$this->blues[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,$w,$h);
			//Print the text
      $this->SetTextColor($r,$g,$b);
      //$this->SetTextColor(0,0,0);
			$this->MultiCell($w,5,$data[$i],0,$a);
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
$data = array();
foreach($barang->tampil_data($idsub,$min) as $rowd){
	array_push($data, $rowd);
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