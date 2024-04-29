<?php
class Controller_Subject extends Controller{

    private $data = [];

    function __construct() {
        $this->model = new Model_Subject();
        $this->view = new View();
        $this->data['controller_name'] = "subject";
    }

    function action_index() {
        $subjects = $this->model->get_subjects();
        $this->data["subjects"] = $subjects;

		$this->view->generate('subject/list_view.php', 'template_view.php', $this->data);
	}
}
?>