<?php
class Controller_Report extends Controller
{
    private $data = [];
    private $language_ = [];

    function __construct()
    {
        $this->model_common = new Model_Common();
        $this->model = new Model_Report();
        $this->view = new View();
        $this->data['controller_name'] = "user";
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
    function action_report_barchart()
    {  
        $this->data["users"] = $this->model->get_user();
        $this->data["kafedra"] = $this->model->get_kafedra();
        if (isset($_SESSION["uid"]["role_id"])) {
            if ($_SESSION["uid"]["role_id"] == 1 || $_SESSION["uid"]["role_id"] == 2) {
                $this->view->generate('403_view.php', 'template_view.php', $this->data);

            }
            else{
                $this->view->generate('report/report_barchart.php', 'template_view.php', $this->data);
            }
        }
        //$this->view->generate('report/report_barchart.php', 'template_view.php',$this->data);
        return;
    }
    public function action_getFaculty()
    {
        $user_role = $_SESSION["uid"]["role_id"];
        //$this->print_array($user_role);die;
        if ($user_role != 3 && $user_role != 4) {
            $result = ["error" => 1, "message" => $this->language_["accessMessageAll"]];
        } else {
            $result = $this->model->get_dataFaculty();
            if (!$result) {
                $result = ["error" => 1, "message" => $this->language_["errorMessageAll"]];
            }
        }
        $this->return_json($result);
        return;
    }
    public function action_getAllByYear()
    {
        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role != 3 && $user_role != 4) {
            $result = ["error" => 1, "message" => $this->language_["accessMessageAll"]];
        } else {
            $result = $this->model->getFacultyByYear();
            if (!$result) {
                $result = ["error" => 1, "message" => $this->language_["errorMessageAll"]];
            }
        }
        $this->return_json($result);
        return;
    }
    public function action_getUsers()
    {
        $user_role = $_SESSION["uid"]["role_id"];
        $users = $_POST["users"];
        if ($user_role != 3 && $user_role != 4) {
            $result = ["error" => 1, "message" => $this->language_["accessMessageAll"]];
        } else {
            $result = $this->model->get_dataUsers($users);
            if (!$result) {
                $result = ["error" => 1, "message" => $this->language_["errorMessageUser"]];
            }
        }
        $this->return_json($result);
        return;
    }
    public function action_getKafedra()
    {
        $user_role = $_SESSION["uid"]["role_id"];
        $kafedra = $_POST["kafedra"];
        //$this->print_array($_POST);die;
        if ($user_role != 3 && $user_role != 4) {
            $result = ["error" => 1, "message" => $this->language_["accessMessageAll"]];
        } else {
            $result = $this->model->get_dataKafedra($kafedra);
            if (!$result) {
                $result = ["error" => 1, "message" => $this->language_["errorMessageGetKafedra"]];
            }
        }
        $this->return_json($result);
        return;
    }
    function action_allReport()
    {
        $materials = $this->model->get_materials();

        for ($i = 0; $i < count($materials); $i++) {

            $authors = $this->model->get_material_authors($materials[$i]['id']);
            $authors_str = "";
            for ($j = 0; $j < count($authors); $j++) {
                if ($j == 0) {
                    $authors_str = $authors[$j]["name"];
                } else {
                    $authors_str .= ", " . $authors[$j]["name"];
                }
            }
            $materials[$i]['authors'] = $authors_str;
        }
        $this->data["materials"] = $materials;

        //$this->print_array( $materials ); die;
        if (isset($_SESSION["uid"]["role_id"])) {
            if ($_SESSION["uid"]["role_id"] == 1 || $_SESSION["uid"]["role_id"] == 2) {
                $this->view->generate('403_view.php', 'template_view.php', $this->data);

            }
            else{
                $this->view->generate('report/all_report.php', 'template_view.php', $this->data);
            }
        }
        //$this->view->generate('report/all_report.php', 'template_view.php', $this->data);
    }
    function action_report_kafedra()
    {
        $materials = $this->model->get_materials();

        for ($i = 0; $i < count($materials); $i++) {

            $authors = $this->model->get_material_authors($materials[$i]['id']);
            $authors_str = "";
            for ($j = 0; $j < count($authors); $j++) {
                if ($j == 0) {
                    $authors_str = $authors[$j]["name"];
                } else {
                    $authors_str .= ", " . $authors[$j]["name"];
                }
            }
            $materials[$i]['authors'] = $authors_str;
        }
        $this->data["faculty"] = $this->model->get_facultys();
        //$this->data["kafedra"] = $this->model->get_kafedra();
        $this->data["materials"] = $materials;

        //$this->print_array( $materials ); die;
        if (isset($_SESSION["uid"]["role_id"])) {
            if ($_SESSION["uid"]["role_id"] == 1 || $_SESSION["uid"]["role_id"] == 2) {
                $this->view->generate('403_view.php', 'template_view.php', $this->data);

            }
            else{
                $this->view->generate('report/report_kafedra.php', 'template_view.php', $this->data);
            }
        }
        //$this->view->generate('report/all_report.php', 'template_view.php', $this->data);
    }
    public function action_getKafedraByIdFaculty()
    {
        $user_role = $_SESSION["uid"]["role_id"];
        $faculty_id = $_POST["faculty_id"];
        //$this->print_array($_POST);die;
        if ($user_role != 3 && $user_role != 4) {
            $result = ["error" => 1, "message" => $this->language_["accessMessageAll"]];
        } else {
            $result = $this->model->get_kafedraById($faculty_id);
            if (!$result) {
                $result = ["error" => 1, "message" => $this->language_["errorMessageGetKafedra"]];
            }
        }
        $this->return_json($result);
        return;
    }
    public function action_getreportArticle()
    {
        $user_role = $_SESSION["uid"]["role_id"];
        //$this->print_array($_POST);die;
        $kefedra = $_POST["kafedra_id"];
        if ($user_role != 3 && $user_role != 4) {
            $result = ["error" => 1, "message" => $this->language_["accessMessageAll"]];
        } else {
            $result = $this->model->get_reportArticle($kefedra);
            if (!$result) {
                $result = ["error" => 1, "message" => $this->language_["errorMessageGetKafedra"]];
            }
        }
        $this->return_json($result);
        return;
    }
}
