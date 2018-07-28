<?php 
use framework\basedatos\Conection;
namespace framework\basedatos;

if (DB_CONNECTOR === "mysql") {
	class ORM extends ORMysql{
		protected static $table;
	}
}else{
	class ORM extends ORMPostgres{
		protected static $table;
	}
}

/**
 * 
 */

// class ORM extends Conection
// {
// 	protected static $table;
//     private $driver;
//     function __construct()
//     {
//         // parent::__construct();
//         if(DB_CONNECTOR === "postgres"){
//             die("hola");
//         }else{
//             echo "mysql";
//             print_r($this->getColumns());
//             $this->driver = new ORMysql;
//         }
//     }

//     public function save()
//     {
//         $this->driver->save();
//     }

//     public function where($columna, $signo, $valor)
//     {

//     }

//     public function find($columna, $signo, $id)
//     {

//     }

//     public function all()
//     {

//     }

//     public function delete($valor=null,$columna=null)
//     {

//     }

// }

?>