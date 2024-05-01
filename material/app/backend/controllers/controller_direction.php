<?php
class Controller_Direction extends Controller
{

    private $data = [];
    private $language_ = [];

    function __construct()
    {
        $this->model_common = new Model_Common();
        $this->model = new Model_Direction();
        $this->view = new View();
        $this->data['controller_name'] = "direction";
        if ($_SESSION["local"] == "ru") {
            $this->language_ = [];
            include_once './app/language/messageRU.php';
            $this->language_ = $language;
        } else {
            $this->language_ = [];
            include_once './app/language/messageTJ.php';
            $this->language_ = $language;
        }
    }

    function action_index()
    {
        $direction = $this->model->get_directions();
        $this->data["direction"] = $direction;
        $this->view->generate('direction/list_view.php', 'template_view.php', $this->data);
    }
    function action_add()
    {
        $user_role = $_SESSION["uid"]["role_id"];
        if ($user_role != 3 && $user_role != 4) {
            $result = ["error" => 1, "message" => $this->language_["erroraccessMessageAddAll"]];
        } else {
            if (isset($_POST["direction"])) {
                $direction = $_POST["direction"];
                if ($this->model->add_direction($direction)) {
                    $result = ["error" => 0, "message" => $this->language_["successMessageDirection"]];
                } else {
                    $result = ["error" => 1, "message" => $this->language_["errorMessageDirection"]];
                }
            } else {
                $result = ["error" => 1, "message" => $this->language_["errorMessageAll"]];
            }
        }
        $this->return_json($result);
        return;
    }
    function action_getDirection()
    {
        $direction = $this->model->get_facultys();
        $this->return_json($direction);
        return;
    }
    public function action_getDirectionById($id)
    {
        $direction = $this->model->get_directionById($id);
        if (!$direction) {
            return json_encode(["error" => 1, "message" => $this->language_["errorMessageGetDirection"]]);
        }
        $this->return_json($direction);
        return;
    }
    function action_edit()
    {
        //$this->print_array($_POST);die;
        $id = $_POST["id"];
        $this->data["direction"] = $this->model->get_directionById($id);
        if (isset($_POST["directionName"]) && isset($_POST["id"])) {
            $name = $_POST["directionName"];
            $result = $this->model->edit_direction($id, $name);
            if (!$result) {
                return json_encode(["error" => 1, "message" => $this->language_["erroreditMessageDirection"]]);
            }
            $this->return_json($result);

        } else {
            return json_encode(["error" => 1, "message" => $this->language_["errorMessageDirectionedit"]]);
        }
    }
    function action_delete()
    {
        $user_role = $_SESSION["uid"]["role_id"];
        if ($user_role == 3 || $user_role == 4) {
            if (isset($_POST["id"])) {
                $id = $_POST["id"];
                if ($this->model->delete_direction($id)) {
                    $result = ["error" => 0, "message" => $this->language_["successDeleteMessageDirection"]];
                } else {
                    $result = ["error" => 1, "message" => $this->language_["errorDeleteMessageDirection"]];
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