<?php 
namespace framework\basedatos;
class Conection 
{
	public $host; 
	public $db; 
	public $user; 
	public $pass; 
	public $url; 

	private function loadvalue()
	{
		$this->host= DB_HOST;
		$this->db= DB_NAME;
		$this->user= DB_USER;
		$this->pass= DB_PASSWORD;
	}

	function connect()
	{
		$this->loadvalue();
		if (DB_CONNECTOR === "postgres") {
			$this->connect_postgres();
		}else if (DB_CONNECTOR === "mysql"){
			$this->connect_mysql();
		}else{
			die("Debe Especificar un conector solo estan permitidos = postgres o mysql");
		}
		return true;
	}

	private function connect_mysql()
	{
		$this->url= new \mysqli($this->host, $this->user, $this->pass, $this->db);
		$this->url->set_charset("utf8");	
	}

	private function connect_postgres()
	{
		$conexion="host='$this->host' dbname='$this->db' user='$this->user' password='$this->pass' ";
		$this->url=pg_connect($conexion);
	}

	function destroy()
	{
		if (DB_CONNECTOR === "mysql") {
			$this->url->close();
		}else{
			pg_close($this->url);	
		}
	}

	public function getconn()
	{
		if(!$this->connect()){
			$this->connect();			
		}
		return $this->url;  
	}
}
?>