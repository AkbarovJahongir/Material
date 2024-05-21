<?php
class Route
{

	public static $app_side;
	public static $active_controller;

	static function start()
	{
		$controller_name = 'auth';
		$action_name = 'index';
		$routes = explode('/', $_SERVER['REQUEST_URI']);
		if (!empty($routes[1])) {
			$controller_name = $routes[1];
		}
		if (!empty($routes[2])) {
			$action_name = $routes[2];
		}
		self::$active_controller = $controller_name;

		$model_name = 'Model_' . $controller_name;
		$controller_name = 'Controller_' . $controller_name;
		$action_name = 'action_' . $action_name;


		self::$app_side = "backend";

		// if (!isset($_SESSION["uid"])) {
		// 	if ($controller_name == "Controller_auth") {
		// 		self::AuthPage();
		// 	}
		// } else {
		// 	if ($controller_name != "Controller_auth") {
		// 		self::MainPage();
		// 	}
		// }

		if(!isset($_SESSION["uid"])){
			if($controller_name != "Controller_auth"){
				Route::AuthPage();
			}
		}else{
			if($controller_name == "Controller_auth"){
				Route::MainPage();
			}else{
				$arr = explode(",",$_SESSION["roles"]["controllers"].",auth,main,address,error,opa");
				//echo $_SESSION["roles"]["controllers"];
				if (!in_array($routes[1],$arr) && !empty($routes[1])) {
					//Route::ErrorPage403();
					//Route::MainPage();
				}
				 //var_dump(in_array($routes[1],$arr));
			}
		}

		$model_file = strtolower($model_name) . '.php';
		$model_path = "app/" . self::$app_side . "/models/" . $model_file;
		if (file_exists($model_path)) {
			include "app/" . self::$app_side . "/models/" . $model_file;
			include "app/" . self::$app_side . "/models/model_common.php";
		}

		$controller_file = strtolower($controller_name) . '.php';
		$controller_path = "app/" . self::$app_side . "/controllers/" . $controller_file;
		if (file_exists($controller_path)) {
			include "app/" . self::$app_side . "/controllers/" . $controller_file;
		} else {
			self::ErrorPage404();
		}

		$controller = new $controller_name;
		$action = $action_name;

		if (method_exists($controller, $action)) {
			if (count($routes) == 4) {
				// @controller => $controller   | controller_main
				// @action => $action           | action_index
				// @id => $routes[3]            | 1
				$controller->$action($routes[3]);
			} else {
				//echo "login: ".$_POST["login"]; die;
				$controller->$action();
			}
		} else {
			self::ErrorPage403();
		}
	}

	static function MainPage()
	{
		$host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
		header('Location:' . $host . 'main');
	}

	static function AuthPage()
	{
		$host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
		header('Location:' . $host . 'auth');
	}

	static function ErrorPage404()
	{
		$host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
		header('HTTP/1.1 404 Not Found');
		header("Status: 404 Страница не найдена");
		header('Location:' . $host . 'error/404');
	}

	static function ErrorPage403()
	{
		$host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
		header('HTTP/1.1 403 Forbidden');
		header("Status: 403 Запрещено");
		header('Location:' . $host . 'error/403');
	}
}
