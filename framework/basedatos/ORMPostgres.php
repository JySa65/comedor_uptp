<?php 
use framework\basedatos\Conection;
namespace framework\basedatos;
class ORMPostgres extends Conection
{
	protected static $table;

    public function save()
    {
        $this->getconn();
        $values = $this->getColumns();
        $filtered = null;
        $params = "";
        foreach ($values as $key => $value) {
            if ($value !== null && !is_integer($key) && $value !== '' && strpos($key, 'obj_') === false && $key !== 'id') {
                if ($value === false) {
                    $value = 0;
                }
                $filtered[$key] = $value;
            }
        }
        $columns = array_keys($filtered);
        if ($this->id) {
            for ($i=0; $i < count($columns); $i++) {
                $params .= $columns[$i] . " = $". ($i+1) . ",";
            }
            $params =  trim($params,",");
            $query = "UPDATE " . static ::$table . " SET $params WHERE id =" . $this->id;
        } else {
            for ($i=1; $i <= count($columns); $i++) {
                $params[] = "$".$i;
            }
            $param = join(", ", $params);
            $columns = join(", ", $columns);
            $query = "INSERT INTO " . static ::$table . " ($columns) VALUES ($param)";
        }
        try {
            pg_prepare($this->getconn(), static::$table . "save", $query);
            if (pg_execute($this->getconn(), static::$table . "save", array_values($filtered))){
                $rs = pg_query("SELECT id FROM account ORDER BY id DESC LIMIT 1");
                $this->id = pg_fetch_assoc($rs)['id'];
                $this->destroy();
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
        	echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }  
    }

    public function where($columna, $signo, $valor)
    {
        $table = static::$table;
        $query = "SELECT * FROM {$table} WHERE {$columna} {$signo} $1";
        $class = get_called_class();
        self::getconn();
        pg_prepare($this->getconn(), "{$table}where", $query);
        $rs = pg_execute($this->getconn(), "{$table}where", array($valor));
        $obj = [];
        while ($row = pg_fetch_assoc($rs)){
            $obj[] = new $class($row);
        }  
        self::destroy();
        return $obj;
    }

    public function find($columna, $signo, $id)
    {
        $resultado = self::where($columna, $signo, $id);
        if(count($resultado)){
            return $resultado[0];
        }else{
            return [];
        }
    }

    public function all(){
        $table = static::$table;
        $query = "SELECT * FROM {$table}";
        $class = get_called_class();
        pg_prepare(self::getconn(), "{$table}all", $query);
        $rs = pg_execute(self::getconn(), "{$table}all", []);
        $obj = [];
        while ($row = pg_fetch_assoc($rs)){
            $obj[] = new $class($row);
        }  
        self::destroy();
        return $obj;
    }

    public function delete($valor=null,$columna=null)
    {
        $table = static::$table;
        $colum = (is_null($columna)?"id":$columna);
        $query = "DELETE FROM {$table} WHERE {$colum} = $1";
        pg_prepare(self::getconn(), "{$table}delete", $query);
        $rs = null;
        if(!is_null($valor)){
            $rs = pg_execute(self::getconn(), "{$table}delete", [$valor]);
        }else{
            if (is_null($this->id)) {
                $rs = pg_query(self::getconn(), "DELETE FROM {$table}");
            }else{
                $rs = pg_execute(self::getconn(), "{$table}delete", [$this->id]);
            }
        }
        if($rs){
            self::destroy();
            return true;
        }else{
            return false;
        }
    }

}

?>