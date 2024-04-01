<?php
class Controller_Auth extends Controller {
    private $data = [];
    private $login;
    private $password;

    function __construct() {
        $this->model = new Model_Auth();
        $this->view = new View();
        
    }
    function action_logout() {
        session_destroy();
        unset($_SESSION['uid']);
        $this->view->generate_one('auth_view.php');
    
        Route::AuthPage();
    }
    
    
    function action_getuser(){
        $users = $this->model->get_user($_SESSION['uid']);
        $this->data["users"] = $users;
       
        //$this->print_array($this->data); die;

		$this->view->generate('user/list_view.php', 'template_view.php', $this->data);
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
                        $_SESSION["role_id"] = $result[0]["role_id"];
                        //print_r($result[0]["role"]);die;
                        //$this->print_array($result[0]);die;
                        $data["message"] = "Success";
                            Route::MainPage();
                    } else {
                        //have not access
                        $data["error"] = 1;
                        $data["message"] = "Доступ запрещен для этого пользователя";
                    }
                } else {
                    $data["error"] = 1;
                    $data["message"] = "Неправильный логин или пароль";
                }
            } else {
                $data["error"] = 1;
                $data["message"] = "Логин или пароль пуст";
            }
            $this->view->generate_one('auth_view.php', $data);
        }
        //$this->print_array($result[0]);die;
       else{
        $this->view->generate_one('auth_view.php', $data);
       }
	}
}
?>