<?php 
/**
 * 
 */

use framework\view\View;
use app\models\AccountModel;
use app\models\SedeModel;
use app\models\PnfModel;
class IndexController extends View
{
	
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$account = new AccountModel;
		$sede = new SedeModel;
		$pnf = new PnfModel;
		$accounts = $account->paginate(100);
		$data = [];
		foreach ($accounts[0] as $account) {
			$id_sede = $account->id_sede;
			$id_pnf = $account->id_pnf;
			$sed = $sede->find('id', '=', $id_sede);
			$pf = $pnf->find('id', '=', $id_pnf);
			array_push($data, [$account, $sed->nombre, $pf->nombre]);
		}		
		return $this->render('index/index', ['accounts' => $data, 'paginate' => $accounts[1]]);
	}
}



?>