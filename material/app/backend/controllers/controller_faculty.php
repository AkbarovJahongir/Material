<?php
class Controller_Faculty extends Controller
{

    private $data = [];
    private $language_ = [];

    function __construct()
    {
        $this->model_common = new Model_Common();
        $this->model = new Model_Faculty();
        $this->view = new View();
        $this->data['controller_name'] = "faculty"; 
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

    function action_index()
    {
        $faculty = $this->model->get_facultys();
        $this->data["faculty"] = $faculty;
        $this->view->generate('faculty/list_view.php', 'template_view.php', $this->data);
    }
    function action_index_kafedra()
    {
        $kafedra = $this->model->get_kafedra();
        $this->data["kafedra"] = $kafedra;
        $this->view->generate('faculty/list_view_kafedra.php', 'template_view.php', $this->data);
    }
    function action_add()
    {
        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role != 3) {
            $result = ["error" => 1, "message" => $this->language_["erroraccessMessageAddAll"]];
        } else {
            if (isset ($_POST["faculty"])) {
                $faculty = $_POST["faculty"];
                if ($this->model->add_faculty($faculty)) {
                    $result = ["error" => 0, "message" => $this->language_["successMessageFaculty"]];
                } else {
                    $result = ["error" => 1, "message" => $this->language_["errorMessageFaculty"]];
                }
            } else {
                $result = ["error" => 1, "message" => $this->language_["errorMessageAll"]];
            }
        }
        $this->return_json($result);
        return;

    }
    function action_getFaculty()
    {
        $faculty = $this->model->get_facultys();
        $this->return_json($faculty);
        return;
    }
    public function action_getFacultyById($id)
    {
        $faculty = $this->model->get_facultyById($id);
        if (!$faculty) {
            return json_encode(["error" => 1, "message" => $this->language_["errorMessageGetFaculty"]]);
        }
        $this->return_json($faculty);
        return;
    }
    public function action_getKafedraById($id)
    {
        $faculty = $this->model->get_kafedraById($id);
        if (!$faculty) {
            return json_encode(["error" => 1, "message" => $this->language_["errorMessageGetKafedra"]]);
        }
        $faculty["faculty"] = $this->model->get_facultys();

        $this->return_json($faculty);
        return;
    }

    function action_edit()
    {
        $id = $_POST["id"];
        $this->data["faculty"] = $this->model->get_facultyById($id);

        if (isset ($_POST["facultyName"]) && isset ($_POST["id"])) {
            $name = $_POST["facultyName"];
            $result = $this->model->edit_faculty($id, $name);
            if (!$result) {
                return json_encode(["error" => 1, "message" => $this->language_["erroreditMessageFaculty"]]);
            }
            $this->return_json($result);

        } else {
            return json_encode(["error" => 1, "message" => $this->language_["errorMessageFacultyedit"]]);
        }
    }
    function action_editKafedra()
    {
        $id = $_POST["id"];
        $this->data["kafedra"] = $this->model->get_kafedraById($id);

        if (isset ($_POST["kafedra"]) && isset ($_POST["id"]) && isset($_POST["faculty"])) {
            $name = $_POST["kafedra"];
            $faculty = $_POST["faculty"];
            $result = $this->model->edit_kafedra($id, $name, $faculty);
            if (!$result) {
                return json_encode(["error" => 1, "message" => $this->language_["erroreditMessageFaculty"]]);
            }
            $this->return_json($result);

        } else {
            return json_encode(["error" => 1, "message" => $this->language_["errorMessageKafedraedit"]]);
        }
    }
    function action_delete() {

        $user_role = $_SESSION["uid"]["role_id"];

        if ( $user_role == 3 ) {
            if ( isset($_POST["id"]) ) {
                $id = $_POST["id"];
                if ( $this->model->delete_faculty( $id ) ) {
                    $result = ["error" => 0, "message" => $this->language_["successDeleteMessageFaculty"]];
                } else {
                    $result = ["error" => 1, "message" => $this->language_["errorDeleteMessageFaculty"]];
                }
            } else {
                $result = ["error" => 1, "message" => $this->language_["errorMessageAll"]];
            }
        } else {
            $result = ["error" => 1, "message" => $this->language_["erroraccessMessageDeleteAll"]];
        }
        $this->return_json($result);
        return;
    }
    function action_addKafedra()
    {
        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role != 3) {
            $result = ["error" => 1, "message" => $this->language_["erroraccessMessageAddAll"]];
        } else {
            if (isset ($_POST["kafedra"]) && isset($_POST["faculty"])) {
                $kafedra = $_POST["kafedra"];
                $facilty = $_POST["faculty"];
                if ($this->model->add_kafedra($kafedra,$facilty)) {
                    $result = ["error" => 0, "message" => $this->language_["successMessageKafedra"]];
                } else {
                    $result = ["error" => 1, "message" => $this->language_["errorMessageKafedraedit"]];
                }
            } else {
                $result = ["error" => 1, "message" => $this->language_["errorMessageAll"]];
            }
        }
        $this->return_json($result);
        return;

    }
    function action_deleteKafedra() {

        $user_role = $_SESSION["uid"]["role_id"];

        if ( $user_role == 3 ) {
            if ( isset($_POST["id"]) ) {
                $id = $_POST["id"];
                if ( $this->model->delete_kafedra( $id ) ) {
                    $result = ["error" => 0, "message" => $this->language_["successDeleteMessageKafedra"]];
                } else {
                    $result = ["error" => 1, "message" => $this->language_["errorDeleteMessageKafedra"]];
                }
            } else {
                $result = ["error" => 1, "message" => $this->language_["errorMessageAll"]];
            }
        } else {
            $result = ["error" => 1, "message" => $this->language_["erroraccessMessageDeleteAll"]];
        }
        $this->return_json($result);
        return;
    }
}
?>