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
    function action_type() {
        $types = $this->model->get_types();
        $this->data["type"] = $types;

        //$this->print_array($types); die;

		$this->view->generate('subject/list_view_type.php', 'template_view.php', $this->data);
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
    function action_addType()
    {
        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role != 3) {
            $result = ["error" => 1, "message" => $this->language_["erroraccessMessageAddAll"]];
        } else {
            if (isset ($_POST["type"])) {
                $type = $_POST["type"];
                if ($this->model->add_type($type)) {
                    $result = ["error" => 0, "message" => $this->language_["successMessageType"]];
                } else {
                    $result = ["error" => 1, "message" => $this->language_["errorMessageType"]];
                }
            } else {
                $result = ["error" => 1, "message" => $this->language_["errorMessageAuthorAll"]];
            }
        }
        $this->return_json($result);
        return;

    }
    function action_editType()
    {
        $id = $_POST["id"];
        $this->data["type"] = $this->model->get_typeById($id);

        if (isset ($_POST["typeName"]) && isset ($_POST["id"])) {
            $name = $_POST["typeName"];
            $result = $this->model->edit_type($id, $name);
            if (!$result) {
                return json_encode(["error" => 1, "message" => $this->language_["erroreditMessageFaculty"]]);
            }
            $this->return_json($result);

        } else {
            return json_encode(["error" => 1, "message" => $this->language_["erroreditMessageType"]]);
        }
    }
    public function action_getTypeById($id)
    {
        $type = $this->model->get_typeById($id);
        if (!$type) {
            return json_encode(["error" => 1, "message" => $this->language_["errorMessageGetType"]]);
        }
        $this->return_json($type);
        return;
    }
}
?>