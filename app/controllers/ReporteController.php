<?php 
/**
 * 
 */

use framework\view\View;
use app\models\AccountModel;
use app\models\SedeModel;
use app\models\PnfModel;
use app\models\ComedorModel;
class ReporteController extends View
{
	
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		if (isset($_GET['get_date'])) {
			$date = $_GET['get_date'];
			if (!empty($date)) {
				$account = new AccountModel;
				$data = $account->execute_query("SELECT acc.nacionality, acc.cedula, acc.name, acc.last_name, acc.sex 
					FROM comedor as cm 
					LEFT JOIN account as acc ON cm.id_account = acc.id
					LEFT JOIN sede as sd ON acc.id_sede = sd.id
					LEFT JOIN pnf as pf ON acc.id_pnf = pf.id
					WHERE cm.created_at ='" . date("Y-m-d", strtotime($date)) ."'");
				if (!empty($data)) {
					$this->all_user($data);
				}else{
					echo "<script> alert('No Hay datos'); window.close()</script>";	
				}
			}else{
				echo "<script> window.close()</script>";
			}
		}
		return $this->render('index/reporte');

		
	}

	private function all_user(array $data)
	{
		$pdf = new FPDF('L', 'mm', 'A4');
		$pdf->AddPage();
		$pdf->Image("../public/static/img/bn.png", 6, 5, 280, 30);
		$pdf->Ln(30);
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(215, 4, '', 0, 0);
		$date = explode("-", $_GET['get_date']);
		$pdf->Cell(60, 4, "Fecha: {$date[2]}/{$date[1]}/{$date[0]}", 0, 1, 'L');
		$count = count($data);
		$pdf->Ln(1);
		$pdf->Cell(200, 4, '', 0, 0);
		$pdf->Cell(60, 4, utf8_decode("N° De Bandejas Servidad: {$count}"), 0, 1, 'L');
		$pdf->SetFont('Arial', 'BU', 12);
		$pdf->Cell(280, 12, 'Listado De Personas', 0, 1, 'C');
		$pdf->SetFont('Arial', 'B', 10);
		$pdf->Cell(10, 5, '#', 1, 0, 'C');
		$pdf->Cell(30, 5, utf8_decode("N° CÉDULA"), 1, 0, 'C');
		$pdf->Cell(100, 5, utf8_decode("APELLIDOS"), 1, 0, 'C');
		$pdf->Cell(100, 5, utf8_decode("NOMBRES"), 1, 0, 'C');
		$pdf->Cell(35, 5, utf8_decode("SEXO"), 1, 1, 'C');
		$pdf->SetFont('Arial', '', 9);
		$cont = 1;
		foreach ($data as $account) {
			$pdf->Cell(10, 5, $cont, 1, 0, 'C');
			$pdf->Cell(30, 5, strtoupper(utf8_decode("{$account->nacionality} - {$account->cedula}")), 1, 0, 'C');
			$pdf->Cell(100, 5, strtoupper(utf8_decode("{$account->last_name}")), 1, 0, 'C');
			$pdf->Cell(100, 5, strtoupper(utf8_decode("{$account->name}")), 1, 0, 'C');
			$pdf->Cell(35, 5, strtoupper(utf8_decode("{$account->sex}")), 1, 1, 'C');
			$cont = $cont + 1;	
		}
		$pdf->Output();

	}
}



?>