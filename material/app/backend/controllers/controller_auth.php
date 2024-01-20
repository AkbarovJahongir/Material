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
        $this->view->generate('main/main_view.php', 'template_view.php', $this->data);
    
        Route::AuthPage();
    }
    

    function action_getuser(){
        $users = $this->model->get_user($_SESSION['uid']);
        $this->data["users"] = $users;
       
        //$this->print_array($this->data); die;

		$this->view->generate('user/list_view.php', 'template_view.php', $this->data);
    }

}
?>