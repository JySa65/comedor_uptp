<?php 
/**
 * Esta se encara de buscar el controlador establecido y lo carga al sistema
 * por otro lado vefifica si tiene un metodo y parametros
 * 1->controller
 * 2->method
 * 3->parameters
 * example = account/update/1
 */
namespace framework\route;

class Routes
{
	protected $toUrl = null;
	function __construct($arrayUrl)
	{
		$this->toUrl = $arrayUrl;
		if (!$this->toUrl) {
			die('<br><br><div style="color:red" align="center">
				<h1>Bienvenido a nuestro framework para empezar declara una ruta en app/routes/Routes.php</h1>
			</div>');
		}else{
			self::getUrl();
		}
	}

	public function getUrl()
	{
		$url = isset($_GET['route']) ? $_GET['route'] : "/";
		if ($url === "/") {
			$res = array_key_exists("/", $this->toUrl);
			if ($res != "" && $res == 1) {
				foreach ($this->toUrl as $route => $controller) {
					if ($route == "/") {
						$_controller = $controller;
					}
				}
				$this->getController("index", $_controller);
			}
		}else{
			$url = explode("/", filter_var(trim($url, "/"), FILTER_SANITIZE_URL));
			$stateRoute = false; 
			foreach($this->toUrl as $route => $controller){
				if (trim($route, "/") == $url[0]) {
					$stateRoute = true;
					$_controller = $controller;
					$methods = "";
					$parameters = [];
					if (count($url) > 1) {
						$methods = $url[1];
						if (isset($url[2])) {
							$parameters = [$url[2]];
						}
					}
					$this->getController($methods, $_controller, $parameters);
				}
			}
			if ($stateRoute == false) {
				die("the route is not declared '{$_SERVER['REQUEST_URI']}'");
			}

		}
	}

	public function getController($method, $controller, $params = null)
	{
		// veficar si existe controlador tiene un metodo llamable
		$methodController = "";
		if ($method == "" && $params == null) {
			$methodController = "index";
		}else{
			$methodController = $method;
		}
		$this->joinController($controller);
		if (class_exists($controller)) {
			$classTemp = new $controller();
			if (is_callable(array($classTemp, $methodController))) {
				if ($methodController == "index") {
					if (count($params) == 0) {
						$classTemp->$methodController();
					} else {
						die("error in parameters");
					}
				} else {
					call_user_func_array(array($classTemp, $methodController), $params);
				}
			}else{
				die("there is not method {$method}");
			}
		}else{
			die("There is the driver but there is not a class {$controller}");
		}
	}

	public function joinController($controller)
	{
		if (file_exists(APP_DIR . "controllers/{$controller}.php")) {
			include(APP_DIR . "controllers/{$controller}.php");
		}else{
			die("there is no driver {$controller}");
		}
	}
}
?>