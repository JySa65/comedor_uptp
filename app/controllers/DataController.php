<?php 
/**
 * 
 */
use app\models\SedeModel;
use app\models\PnfModel;
use app\models\AccountModel;
class DataController
{
	
	function __construct()
	{
		
	}

	function index()
	{
		PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
		$name_archive = "../doc/ListaComedor2018-I.xlsx";
		$objPHPExcel = PHPExcel_IOFactory::load($name_archive);
		$objPHPExcel->setActiveSheetIndex(0);
		$num_row = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
		
		// sede
		$dat_sede = "";
		$data_sede = [];
		for ($i=11; $i < $num_row; $i++) { 
			$sheet = $objPHPExcel->getActiveSheet();
			$check_sede = $sheet->getCell('G'.$i);
			if (strtoupper($dat_sede) != strtoupper($check_sede)) {
				$dat_sede = $check_sede;
				$sede = new SedeModel;
				$sede->created_at = date("Y-m-d H:i:s");
				$sede->updated_at = date("Y-m-d H:i:s");
				$sede->nombre = "{$check_sede}";
				$sede->save();
				$data_sede[] .= $check_sede;
			}
		}
		// end sede

		//  pnf
		$dat_pnf = "";
		$data_pnf = [];
		for ($i=11; $i < $num_row; $i++) { 
			$sheet = $objPHPExcel->getActiveSheet();
			$check_pnf = $sheet->getCell('E'.$i);
			if (!in_array($check_pnf, $data_pnf)) {
				$pnf = new PnfModel;
				$pnf->nombre = "{$check_pnf}";
				$pnf->created_at = date("Y-m-d H:i:s");
				$pnf->updated_at = date("Y-m-d H:i:s");
				$pnf->save();
				$data_pnf[] .= $check_pnf;
			}
		}
		//  end pnf
		
		// data alumnos
		for ($i=11; $i < $num_row; $i++) { 
			$sheet = $objPHPExcel->getActiveSheet();
			$last_name = $sheet->getCell('A'.$i);
			$name = $sheet->getCell('B'.$i);
			$ci = $sheet->getCell('C'.$i);
			$sex = $sheet->getCell('D'.$i);
			$sede = $sheet->getCell('G'.$i);
			$pnf = $sheet->getCell('E'.$i);
			$turno = $sheet->getCell('F'.$i);
			$id_pnf = "";
			$id_sede = "";

			$s_pnf = new PnfModel;
			$r_pnf = $s_pnf->find('nombre', '=', "{$pnf}");
			$id_pnf = $r_pnf->id;

			
			$s_sede = new SedeModel;
			$r_sede = $s_sede->find('nombre', '=', "{$sede}");
			$id_sede = $r_sede->id;
			
			$account = new AccountModel;
			$account->nacionality = "V";
			$account->cedula = (int)"{$ci}";
			$account->name = "{$name}";
			$account->last_name = "{$last_name}";
			$account->sex = "{$sex}";
			$account->turno = "{$turno}";
			$account->id_sede = (int)$id_sede;
			$account->id_pnf = (int)$id_pnf;
			$account->created_at = date("Y-m-d H:i:s");
			$account->updated_at = date("Y-m-d H:i:s");
			$account->save();

			echo "Listo con {$name} {$last_name}";
		}

		// end data alumnos
		

		
	}
}
?>