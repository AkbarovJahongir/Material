<?php
class Controller_Subject extends Controller{

    private $data = [];

    function __construct() {
        $this->model_common = new Model_Common();
        $this->model = new Model_Subject();
        $this->view = new View();
        $this->data['controller_name'] = "subject";
    }

    function action_index() {
        $subjects = $this->model->get_subjects();
        $this->data["subjects"] = $subjects;

        //$this->print_array($subjects); die;

		$this->view->generate('subject/list_view.php', 'template_view.php', $this->data);
	}

    function action_add() {

        /* #Field names with POST request
         * @name
        */

        if ( isset($_POST["name"]) )
        {
            //$this->print_array( $_POST ); die;
            $name = $_POST["name"];

            if ( $name != "" )
            {
                $result = $this->model->add_subject( $name );

                if ( $result ) {
                    $this->data["error"] = 0;
                    $this->data["message"] = "Новый предмет успешно добавлен!";
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = "Не верные данные!";
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = "Некоторые данные пусты!";
            }
        }

        $this->view->generate('subject/add_view.php', 'template_view.php', $this->data);
    }

    function action_edit($id) {

        /* #Get subject data by @id */
        $this->data["subject"] = $this->model->get_subject( $id );

        /* #Field names with POST request
         * @name
        */

        if ( isset($_POST["name"]) )
        {
            //$this->print_array( $_POST ); die;
            $name = $_POST["name"];

            if ( $name != "" )
            {

                $result = $this->model->edit_subject( $id, $name );

                if ( $result ) {
                    $this->data["error"] = 0;
                    $this->data["message"] = "Предмет успешно изменен!";
                    /* #Get subject data by @id */
                    $this->data["subject"] = $this->model->get_subject( $id );
                    //$this->view->generate('subject/success_view.php', 'template_view.php', $this->data);
                    //return true;
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = "Не верные данные!";
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = "Некоторые данные пусты!";
            }
        }

        $this->view->generate('subject/edit_view.php', 'template_view.php', $this->data);
    }
}
?>