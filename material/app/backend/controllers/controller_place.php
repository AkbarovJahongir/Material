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
            include_once './app/language/Messages/messageRU.php';
            $this->language_ = $language;
        }
        else{
            $this->language_ = [];
            include_once './app/language/Messages/messageTJ.php';
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
                    $result = ["error" => 0, "message" => $this->language_["successMessagePlace"]];
                } else {
                    $result = ["error" => 1, "message" => $this->language_["errorMessagePlace"]];
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
            return json_encode(["error" => 1, "message" => $this->language_["errorMessageGetPlace"]]);
        }
        $this->return_json($place);
        return;
    }

    function action_edit()
{
    $result = ["error" => 0, "message" => ""];

    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        //$this->data["place"] = $this->model->get_placeById($id);

        if (isset($_POST["placeName"])) {
            $name = $_POST["placeName"];
            if (!$this->model->edit_place($id, $name)) {
                $result = ["error" => 1, "message" => $this->language_["erroreditMessagePlace"]];
            } else {
                $result["message"] = $this->language_["successMessagePlaceedit"];
            }
        } else {
            $result = ["error" => 1, "message" => $this->language_["errorMessagePlaceedit"]];
        }
    } else {
        $result = ["error" => 1, "message" => "No place ID provided."];
    }

    $this->return_json($result);
}
    function action_delete() {

        $user_role = $_SESSION["uid"]["role_id"];

        if ( $user_role == 3 || $user_role == 1) {
            if ( isset($_POST["id"]) ) {
                $id = $_POST["id"];
                if ( $this->model->delete_place( $id ) ) {
                    $result = ["error" => 0, "message" => $this->language_["successDeleteMessagePlace"]];
                } else {
                    $result = ["error" => 1, "message" => $this->language_["errorDeleteMessagePlace"]];
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