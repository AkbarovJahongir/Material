<?php
class Controller_Auth extends Controller {
    private $login;
    private $password;

    function __construct() {
        $this->model = new Model_Auth();
        $this->view = new View();
    }

	function action_index() {
        $data = [];
	    if ( isset($_POST["login"]) && isset($_POST["password"]) ) {
	        $this->login = $_POST["login"];
            $this->password = $_POST["password"];

            if ( $this->login != "" && $this->password != "" ) {
                $result = $this->model->check($this->login, $this->password);
                if ( count($result) > 0 ) {
                    if ( $result[0]["access"] == 1 ) {
                        $_SESSION["uid"] = $result[0];
                        $_SESSION["name"] = $result[0]["name"];
                        $_SESSION["image_url"] = $result[0]["image_url"];
                        //print_r($result[0]["role"]);die;
                        //$this->print_array($result[0]);die;
                        $data["message"] = "Success";
                        Route::MainPage();
                    } else {
                        //have not access
                        $data["error"] = 1;
                        $data["message"] = "Access denied for this user";
                    }
                } else {
                    $data["error"] = 1;
                    $data["message"] = "Invalid login or password";
                }
            } else {
                $data["error"] = 1;
                $data["message"] = "Login or password is empty";
            }
        }
		$this->view->generate_one('auth_view.php', $data);
	}
}
?>