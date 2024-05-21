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
    public function action_add()
    {
        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role != 3) {
            $result = ["error" => 1, "message" => $this->language_["erroraccessMessageAddAll"]];
        } else {
            if (isset($_POST["faculty"])) {
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
    }

    public function action_getFaculty()
    {
        $faculty = $this->model->get_facultys();
        $this->return_json($faculty);
    }

    public function action_getFacultyById($id)
    {
        $faculty = $this->model->get_facultyById($id);
        if (!$faculty) {
            $result = ["error" => 1, "message" => $this->language_["errorMessageGetFaculty"]];
            $this->return_json($result);
        } else {
            $this->return_json($faculty);
        }
    }

    public function action_getKafedraById($id)
    {
        $kafedra = $this->model->get_kafedraById($id);
        if (!$kafedra) {
            $result = ["error" => 1, "message" => $this->language_["errorMessageGetKafedra"]];
            $this->return_json($result);
        } else {
            $kafedra["faculty"] = $this->model->get_facultys();
            $this->return_json($kafedra);
        }
    }

    public function action_edit()
    {
        $result = ["error" => 0, "message" => ""];

        if (isset($_POST["id"])) {
            $id = $_POST["id"];

            if (isset($_POST["facultyName"])) {
                $name = $_POST["facultyName"];
                if (!$this->model->edit_faculty($id, $name)) {
                    $result = ["error" => 1, "message" => $this->language_["erroreditMessageFaculty"]];
                } else {
                    $result["message"] = $this->language_["successMessageFacultyedit"];
                }
            } else {
                $result = ["error" => 1, "message" => $this->language_["errorMessageFacultyedit"]];
            }
        } else {
            $result = ["error" => 1, "message" => "No faculty ID provided."];
        }

        $this->return_json($result);
    }

    public function action_editKafedra()
    {
        $result = ["error" => 0, "message" => ""];

        if (isset($_POST["id"]) && isset($_POST["kafedra"]) && isset($_POST["faculty"])) {
            $id = $_POST["id"];
            $name = $_POST["kafedra"];
            $faculty = $_POST["faculty"];

            if (!$this->model->edit_kafedra($id, $name, $faculty)) {
                $result = ["error" => 1, "message" => $this->language_["erroreditMessageKafedra"]];
            } else {
                $result["message"] = $this->language_["successMessageKafedraedit"];
            }
        } else {
            $result = ["error" => 1, "message" => $this->language_["errorMessageKafedraedit"]];
        }

        $this->return_json($result);
    }

    public function action_delete()
    {
        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role == 3) {
            if (isset($_POST["id"])) {
                $id = $_POST["id"];
                if ($this->model->delete_faculty($id)) {
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
    }

    public function action_addKafedra()
    {
        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role != 3) {
            $result = ["error" => 1, "message" => $this->language_["erroraccessMessageAddAll"]];
        } else {
            if (isset($_POST["kafedra"]) && isset($_POST["faculty"])) {
                $kafedra = $_POST["kafedra"];
                $faculty = $_POST["faculty"];
                if ($this->model->add_kafedra($kafedra, $faculty)) {
                    $result = ["error" => 0, "message" => $this->language_["successMessageKafedra"]];
                } else {
                    $result = ["error" => 1, "message" => $this->language_["errorMessageKafedraedit"]];
                }
            } else {
                $result = ["error" => 1, "message" => $this->language_["errorMessageAll"]];
            }
        }

        $this->return_json($result);
    }

    public function action_deleteKafedra()
    {
        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role == 3) {
            if (isset($_POST["id"])) {
                $id = $_POST["id"];
                if ($this->model->delete_kafedra($id)) {
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
    }
}
?>