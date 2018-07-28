<?php 
namespace framework\view;
class View
{
	public function __construct() {      
		
	} 
	public function render($path=Null, $args=Null)
	{
		if ($path) {
			if (file_exists(TEMPLATES_DIR . $_SERVER['TEMPLATE_DIR'] . $path . ".php")) {
				if ($args) {
					foreach ($args as $key => $value) {
						$$key = $value;
					}
				}
				include(TEMPLATES_DIR . $_SERVER['TEMPLATE_DIR'] . $path . ".php");	
			}else{
				die("No existe el Archivo {$path}.php");
			}	
		}else{
			die("Debe Tener Un Nombre de Template Definido");
		}
	}
}
?>