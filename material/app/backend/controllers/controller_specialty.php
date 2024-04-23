<?php
class Controller_Specialty extends Controller{

    private $data = [];
    private $language_ = [];

    function __construct() {
        $this->model_common = new Model_Common();
        $this->model = new Model_Specialty();
        $this->view = new View();
        $this->data['controller_name'] = "specialty";
        if ($_SESSION["local"] == "ru") {
            $this->language_ = [];
            include_once './app/language/messageRU.php';
            $this->language_ = $language;
        }
        else{
            $this->language_ = [];
            include_once './app/language/messageTJ.php';
            $this->language_ = $language;
        }
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
                    $this->data["message"] = $this->language_["successMessageSpecialty"];
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = $this->language_["errorMessageAll"];
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = $this->language_["errorMessageAuthorAll"];
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
                    $this->data["message"] = $this->language_["successeditMessageSpecialty"];
                    /* #Get specialty data by @id */
                    $this->data["specialty"] = $this->model->get_specialty( $id );
                    //$this->view->generate('specialty/success_view.php', 'template_view.php', $this->data);
                    //return true;
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = $this->language_["errorMessageAll"];
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = $this->language_["errorMessageAuthorAll"];
            }
        }

        $this->view->generate('specialty/edit_view.php', 'template_view.php', $this->data);
    }
}
?>