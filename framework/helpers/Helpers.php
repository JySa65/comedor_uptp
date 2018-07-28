<?php 
define('URL_DIR', $_SERVER['HTTP_HOST'] . "/". explode("/", $_SERVER['PHP_SELF'])[1] . "/");
define('SECRET_KEY', $_SERVER['SECRET_KEY']);

function sessionStatus() {
	return (function_exists("session_status")) ? session_status() : session_id();
}

function is_authenticated(){
	return sessionLocal('is_authenticated') ? true : false;
}

function sessionLocal($a = null, $b = null){
	$r = true;
	if(sessionStatus() == 1){
		session_start();
	}
	if(!empty($a)){
		if(empty($b)){
			$r = (isset($_SESSION[$a])) ? $_SESSION[$a] : null;
		}else{
			$_SESSION[$a] = $b;
		}
	}
	return $r;
}

function csrf_token()
{
	if (sessionLocal('csrftoken')) {
		unset($_SESSION["csrftoken"]);
	}
	$hora = date('m:s');
	$session_id = session_id();
	$token = hash('sha256', $hora.$session_id.SECRET_KEY);
	sessionLocal('csrftoken', $token);
	return $token;
}



function val_csrf()
{
	if (isset($_POST["csrftoken"])) {
		if ($_POST["csrftoken"] == sessionLocal('csrftoken')) {
			return true;
		}	
	}else {
		return false;
	}
}

function redirect($path, $args=[])
{
	if (count($args) != 0) {
		foreach ($args as $key => $value) {
			sessionLocal($key, $value);
		}
	}
	return header("Location:". $_SERVER['REQUEST_SCHEME'] . "://" . URL_DIR . $path);
}

function url($path)
{
	return $_SERVER['REQUEST_SCHEME'] . "://" . URL_DIR . $path;
}

function test_text_number($data){
	return preg_match("/^[a-zA-Z0-9 ]*$/",$data);
}

function test_text($data){
	return preg_match("/^[a-zA-Z ]*$/",$data);
}

function test_number($data){
	return preg_match("/^[0-9 ]*$/",$data);
}

function test_email($data){
	return filter_var($data, FILTER_VALIDATE_EMAIL);
}


function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function encrypt($pass){
	$len = strlen($pass);
	$rs = "";
	for ($i=0; $i < $len; $i++) { 
		$rs .= ($i % 2) != 0 ? md5($pass[$i] . SECRET_KEY) : $i;
	}
	return hash('sha512', ($rs));
}

function input_exists($method, $array){
	$es = [];
	print_r($array);
	foreach ($array as $key) {
		if (!isset($method[$key])) {
			array_push($es, "No existe el input con nombre {$key}");
		}
	}
	if (!$es)  {
		return true;
	}else{
		return $es;
	}
}

function typeVar($var) {
	$t = 'b';
	if (is_float($var)) {
		$t = 'd';
	} elseif (is_integer($var)) {
		$t = 'i';
	} elseif (is_string($var)) {
		$t = 's';
	}
	return $t;
}

function valRef(&$arr)
{
	$refs = array();
	foreach ($arr as $key => $value)
	{
		$refs[$key] = &$arr[$key];
	}
	return $refs;
}

function is_file_valid(array $arr, array $type)
{
	$bool = 0;
	for ($i=0; $i < count($arr); $i++) { 
		$res = explode(".", $arr[$i]);
		if (!in_array($res[1], $type)) {
			$bool = $bool +  1;
		}
	}
	if ($bool !== 0) {
		return false;
	}
	return true;
}

?>