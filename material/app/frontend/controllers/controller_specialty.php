<?php
class Controller_Specialty extends Controller{

    private $data = [];

    function __construct() {
        $this->model = new Model_Specialty();
        $this->view = new View();
        $this->data['controller_name'] = "specialty";
    }

    function action_index() {
        $specialties = $this->model->get_specialties();
        $this->data["specialties"] = $specialties;

		$this->view->generate('specialty/list_view.php', 'template_view.php', $this->data);
	}
}
?>