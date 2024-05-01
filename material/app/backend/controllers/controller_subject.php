<?php
class Controller_Subject extends Controller{

    private $data = [];
    private $language_ = [];

    function __construct() {
        $this->model_common = new Model_Common();
        $this->model = new Model_Subject();
        $this->view = new View();
        $this->data['controller_name'] = "subject";
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
        $subjects = $this->model->get_subjects();
        $this->data["subjects"] = $subjects;

        //$this->print_array($subjects); die;

		$this->view->generate('subject/list_view.php', 'template_view.php', $this->data);
	}
    
    function action_add() {

        if ( isset($_POST["name"]) )
        {
            //$this->print_array( $_POST ); die;
            $name = $_POST["name"];

            if ( $name != "" )
            {
                $result = $this->model->add_subject( $name );

                if ( $result ) {
                    $this->data["error"] = 0;
                    $this->data["message"] = $this->language_["successMessageSubject"];
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = $this->language_["errorMessageAll"];
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = $this->language_["errorMessageAuthorAll"];
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
                    $this->data["message"] = $this->language_["successeditMessageSubject"];
                    /* #Get subject data by @id */
                    $this->data["subject"] = $this->model->get_subject( $id );
                    //$this->view->generate('subject/success_view.php', 'template_view.php', $this->data);
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

        $this->view->generate('subject/edit_view.php', 'template_view.php', $this->data);
    }
    
}
?>