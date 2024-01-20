<?php
class Controller_Specialty extends Controller{

    private $data = [];

    function __construct() {
        $this->model_common = new Model_Common();
        $this->model = new Model_Specialty();
        $this->view = new View();
        $this->data['controller_name'] = "specialty";
    }

    function action_index() {
        $specialties = $this->model->get_specialties();
        $this->data["specialties"] = $specialties;

        //$this->print_array($specialties); die;

		$this->view->generate('specialty/list_view.php', 'template_view.php', $this->data);
	}

    function action_add() {

        /* #Field names with POST request
         * @code
         * @name
        */

        if ( isset($_POST["code"]) && isset($_POST["name"]) )
        {
            //$this->print_array( $_POST ); die;
            $code = $_POST["code"];
            $name = $_POST["name"];

            if ( $code != "" && $name != "" )
            {
                $result = $this->model->add_specialty( $code, $name );

                if ( $result ) {
                    $this->data["error"] = 0;
                    $this->data["message"] = "Новый специальность успешно добавлен!";
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = "Не верные данные!";
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = "Некоторые данные пусты!";
            }
        }

        $this->view->generate('specialty/add_view.php', 'template_view.php', $this->data);
    }

    function action_edit($id) {

        /* #Get specialty data by @id */
        $this->data["specialty"] = $this->model->get_specialty( $id );

        /* #Field names with POST request
         * @code
         * @name
        */

        if ( isset($_POST["code"]) && isset($_POST["name"]) )
        {
            //$this->print_array( $_POST ); die;
            $code = $_POST["code"];
            $name = $_POST["name"];

            if ( $code != "" && $name != "" )
            {

                $result = $this->model->edit_specialty( $id, $code, $name );

                if ( $result ) {
                    $this->data["error"] = 0;
                    $this->data["message"] = "Специальность успешно изменен!";
                    /* #Get specialty data by @id */
                    $this->data["specialty"] = $this->model->get_specialty( $id );
                    //$this->view->generate('specialty/success_view.php', 'template_view.php', $this->data);
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

        $this->view->generate('specialty/edit_view.php', 'template_view.php', $this->data);
    }
}
?>