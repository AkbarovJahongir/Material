<?php
class Controller_Author extends Controller{

    private $data = [];

    function __construct() {
        $this->model = new Model_Author();
        $this->view = new View();
        $this->data['controller_name'] = "author";
    }

    function action_index() {
        $authors = $this->model->get_authors();
        $this->data["authors"] = $authors;

		$this->view->generate('author/list_view.php', 'template_view.php', $this->data);
	}
}
?>