<?php
class Controller_Author extends Controller{

    private $data = [];
    private $language_ = [];

    function __construct() {
        $this->model_common = new Model_Common();
        $this->model = new Model_Author();
        $this->view = new View();
        $this->data['controller_name'] = "author";
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
        $authors = $this->model->get_authors();
        $this->data["authors"] = $authors;

        //$this->print_array($authors); die;

		$this->view->generate('author/list_view.php', 'template_view.php', $this->data);
	}
    function action_add() {

        /* #Field names with POST request
         * @name
         * @degree
        */

        if ( isset($_POST["name"]) && isset($_POST["degree"]) )
        {
            //$this->print_array( $_POST ); die;
            $name = $_POST["name"];
            $degree = $_POST["degree"];

            if ( $name != "" )
            {
                $result = $this->model->add_author( $name, $degree );

                if ( $result ) {
                    $this->data["error"] = 0;
                    $this->data["message"] = $this->language_["successMessageAuthor"];
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = $this->language_["errorMessageAuthor"];
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = $this->language_["errorMessageAuthorAll"];
            }
        }

        $this->view->generate('author/add_view.php', 'template_view.php', $this->data);
    }

    function action_edit($id) {

        /* #Get author data by @id */
        $this->data["author"] = $this->model->get_author( $id );

        /* #Field names with POST request
         * @name
         * @degree
        */

        if ( isset($_POST["name"]) && isset($_POST["degree"]) )
        {
            //$this->print_array( $_POST ); die;
            $name = $_POST["name"];
            $degree = $_POST["degree"];

            if ( $name != "" )
            {

                $result = $this->model->edit_author( $id, $name, $degree );

                if ( $result ) {
                    $this->data["error"] = 0;
                    $this->data["message"] = $this->language_["editsuccessMessageAuthor"];

                    /* #Get author data by @id */
                    $this->data["author"] = $this->model->get_author( $id );
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = $this->language_["errorMessageAuthor"];
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = $this->language_["errorMessageAuthorAll"];
            }
        }

        $this->view->generate('author/edit_view.php', 'template_view.php', $this->data);
    }

    function action_delete() {

        $user_role = $_SESSION["uid"]["role_id"];

        if ( $user_role != 1 ) {
            $result = ["error" => 1, "message" => $this->language_["erroraccessMessageDeleteAll"]];
        } else {
            if ( isset($_POST["id"]) ) {
                $id = $_POST["id"];
                if ( $this->model->delete_author( $id ) ) {
                    $result = ["error" => 0, "message" => $this->language_["deletesuccessMessageAuthor"]];
                } else {
                    $result = ["error" => 1, "message" => $this->language_["deleteerrorMessageAuthor"]];
                }
            } else {
                $result = ["error" => 1, "message" => $this->language_["errorMessageAuthor"]];
            }
        }
        $this->return_json($result);
        return;
    }
}
?>