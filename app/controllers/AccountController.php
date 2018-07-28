<?php 
/**
 * 
 */
use framework\view\View;
use app\models\AccountModel;
use app\models\SedeModel;
use app\models\PnfModel;
use app\models\ComedorModel;
class AccountController extends View 
{
	
	function __construct()
	{
		parent::__construct();
		$this->error = array();
	}

	function index()
	{
		$this->runtine();
	}

	function new()
	{
		if($_SERVER['REQUEST_METHOD'] === "GET"){
			$sede = new SedeModel;
			$sedes = $sede->all();
			$pnf = new PnfModel;
			$pnfs = $pnf->all();
			return $this->render('index/account_form', ['sedes' => $sedes, 'pnfs' => $pnfs]);
		}else if($_SERVER['REQUEST_METHOD'] === "POST") {
			sessionLocal();
			$this->save();	
			
		}
	}

	private function save($id=null)
	{
		if ($this->form_valid() == true) {
			$account = new AccountModel;
			$account->nacionality = test_input($_POST['nacionality']);
			$account->cedula = (int)test_input($_POST['cedula']);
			$account->name = test_input($_POST['name']);
			$account->last_name = test_input($_POST['last_name']);
			$account->sex = test_input($_POST['sex']);
			$account->id_sede = (int)test_input($_POST['sede']);
			$account->id_pnf = (int)test_input($_POST['pnf']);
			$account->turno = (int)test_input($_POST['turno']);
			$account->created_at = date("Y-m-d H:i:s");
			$account->updated_at = date("Y-m-d H:i:s");
			if (!is_null($id)) {
				$account->id = (int)test_input($id);
				$account->save();
				return redirect('', ['message' => 'Actualizado Exitosamente']);
			}else{
				$seach_account = $account->find('cedula', '=', test_input($_POST['cedula']));
				if (count($seach_account) == 0) {
					$account->save();
					return redirect('', ['message' => 'Guadador Exitosamente']);
				}else{
					return redirect('account/new', ['error'=>"Este Usuario Ya Existe"]);
				}
			}
		}else{
			return redirect('account/new', ['error'=>$this->error]);
		}
	}

	private function form_valid()
	{
		$data_valid = ['csrftoken', 'nacionality', 'cedula', 'name', 'last_name', 'sex', 'sede', 'pnf', 'turno'];
		$data_text = ['nacionality', 'name', 'last_name', 'sex', 'turno'];
		$data_number = ['cedula', 'sede', 'pnf'];
		foreach ($data_valid as $value) {
			if ($_POST[$value] == "") {
				array_push($this->error, "La Variable {$value} es requerida");	
			}
		}

		foreach ($data_text as $value) {
			if (!test_text(test_input($_POST[$value]))) {
				array_push($this->error, "El Campo {$value} Es Solo Letra");	
			}
		}

		foreach ($data_number as $value) {
			if (!test_number(test_input($_POST[$value]))) {
				array_push($this->error, "El Campo {$value} Es Solo numero");	
			}
		}

		if (count($this->error) > 0) {
			return false;
		}
		return true;
	}

	function runtine(){
		if($_SERVER['REQUEST_METHOD'] === "GET"){
			if (isset($_GET['get_cedula'])) {
				$q = $this->search_runtine();
				if (!empty($q)) {
					sessionLocal('id', $q[0]);
				}
				return $this->render('index/account_runtine', ['acc' => $q]);
			}
			return $this->render('index/account_runtine');
		}else if($_SERVER['REQUEST_METHOD'] === "POST") {
			$message = [];
			if (val_csrf()) {
				if (isset($_POST['comida'])) {
					$comedor = new ComedorModel;
					$comedor->id_account = (int)sessionLocal('id')->id;
					$comedor->status = (int)(bool)$_POST['comida'];
					$comedor->created_at = date("Y-m-d");
					$comedor->updated_at = date("Y-m-d H:i:s");
					$comedor->save();
				}
			}
			return redirect('account/runtine');
		}
	}

	private function search_runtine()
	{
		if ($this->valid_runtine()) {
			$account = new AccountModel;
			$pnf = new PnfModel;
			$sede = new SedeModel;
			$comedor = new ComedorModel;
			$q = test_input($_GET['get_cedula']);
			$accoun = $account->find('cedula', '=', (int)$q);
			if (!empty($accoun)) {
				$id_pnf = $pnf->find('id', '=', $accoun->id_pnf)->nombre;
				$id_sede = $sede->find('id', '=', $accoun->id_sede)->nombre;
				$stat = "";
				$status = $comedor->execute_query("SELECT * FROM comedor WHERE id_account = " . $accoun->id . " and created_at = '" . date("Y-m-d" . "'"));
				if (!empty($status)) {
					$stat = $status[0]->status;
				}
				return [$accoun, $id_pnf, $id_sede, $stat];
			}else{
				return $accoun;
			}
		}
	}

	private function valid_runtine()
	{
		$data_valid = ['get_cedula'];

		foreach ($data_valid as $value) {
			if ($_GET[$value] == "") {
				array_push($this->error, "La Variable {$value} es requerida");	
			}
		}

		if (!is_numeric($_GET['get_cedula'])) {
			array_push($this->error, "El {$value} es solo Numerico");
		}

		if (count($this->error) > 0) {
			return false;
		}
		return true;

	}



}
?>