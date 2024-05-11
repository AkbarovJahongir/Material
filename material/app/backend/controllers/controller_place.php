<?php
class Controller_Place extends Controller
{

    private $data = [];
    private $language_ = [];

    function __construct()
    {
        $this->model_common = new Model_Common();
        $this->model = new Model_Place();
        $this->view = new View();
        $this->data['controller_name'] = "place"; 
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
        $place = $this->model->get_places();
        $this->data["place"] = $place;
        $this->view->generate('place/list_view.php', 'template_view.php', $this->data);
    }
    function action_add()
    {
        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role != 3) {
            $result = ["error" => 1, "message" => $this->language_["erroraccessMessageAddAll"]];
        } else {
            if (isset ($_POST["place"])) {
                $place = $_POST["place"];
                if ($this->model->add_place($place)) {
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
    public function action_getPlaceById($id)
    {
        $place = $this->model->get_palceById($id);
        if (!$place) {
            return json_encode(["error" => 1, "message" => $this->language_["errorMessageGetFaculty"]]);
        }
        $this->return_json($place);
        return;
    }

    function action_edit()
    {
        $id = $_POST["id"];
        $this->data["place"] = $this->model->get_palceById($id);
        $this->print_array($_POST);
        die;
        if (isset ($_POST["placeName"]) && isset ($_POST["id"])) {
            $name = $_POST["placeName"];
            $result = $this->model->edit_place($id, $name);
            if (!$result) {
                return json_encode(["error" => 1, "message" => $this->language_["erroreditMessageFaculty"]]);
            }
            $this->return_json($result);

        } else {
            return json_encode(["error" => 1, "message" => $this->language_["errorMessageFacultyedit"]]);
        }
    }
    function action_delete() {

        $user_role = $_SESSION["uid"]["role_id"];

        if ( $user_role == 3 ) {
            if ( isset($_POST["id"]) ) {
                $id = $_POST["id"];
                if ( $this->model->delete_place( $id ) ) {
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
}
?>