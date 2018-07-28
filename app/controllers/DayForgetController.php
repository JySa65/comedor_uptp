<?php 
sessionLocal();
/**
 * 
 */
use framework\view\View;
use app\models\AccountModel;
use app\models\SedeModel;
use app\models\PnfModel;
use app\models\ComedorModel;
class DayForgetController extends View 
{
	
	function __construct()
	{
		$this->error = array();
	}

	function index()
	{
		if($_SERVER['REQUEST_METHOD'] === "GET"){
			if (isset($_GET['get_cedula'])) {
				$q = $this->search_dayforget();
				if (!empty($q)) {
					sessionLocal('id', $q[0]);
				}
				return $this->render('index/account_dayforget', ['acc' => $q]);
			}

			return $this->render('index/account_dayforget');
		}else if($_SERVER['REQUEST_METHOD'] === "POST") {
			$message = [];
			if (val_csrf()) {
				if (isset($_POST['comida']) and isset($_POST['date'])) {
					$comedor = new ComedorModel;
					$id_account = (int)sessionLocal('id')->id;
					$date = date("Y-m-d", strtotime($_POST['date']));
					if ($date <= date('Y-m-d')) {
						$comida_status = $comedor->execute_query("SELECT * FROM comedor WHERE id_account = {$id_account} and created_at = '{$date}'");
						if (empty($comida_status)) {
							$comedor->id_account = $id_account;
							$comedor->status = (int)(bool)$_POST['comida'];
							$comedor->created_at = $date;
							$comedor->updated_at = date("Y-m-d H:i:s");
							$comedor->save();		
							return redirect('dayforget');
						}else{
							return redirect('dayforget', ['error' => "El usuario ya comio el dia {$date}"]);
						}	
					}else{
						return redirect('dayforget', ['error' => "no estamos en un futuro"]);
					} 
				}
			}
		}
	}

	private function search_dayforget()
	{
		if ($this->valid_dayforget()) {
			$account = new AccountModel;
			$pnf = new PnfModel;
			$sede = new SedeModel;
			$comedor = new ComedorModel;
			$q = test_input($_GET['get_cedula']);
			$accoun = $account->find('cedula', '=', (int)$q);
			if (!empty($accoun)) {
				$id_pnf = $pnf->find('id', '=', $accoun->id_pnf)->nombre;
				$id_sede = $sede->find('id', '=', $accoun->id_sede)->nombre;
				return [$accoun, $id_pnf, $id_sede];
			}else{
				return $accoun;
			}
		}else{
			return redirect('dayforget', ['error'=>$this->error]);
		}
	}


	private function valid_dayforget()
	{
		if ($_GET['get_cedula'] == "") {
			array_push($this->error, "La Variable es requerida");	
		}
		if (!is_numeric($_GET['get_cedula'])) {
			array_push($this->error, "El valor es solo Numerico");
		}
		if (count($this->error) > 0) {			
			return false;
		}
		return true;

	}
}
?>