<?php
class Controller_Report extends Controller
{
    private $data = [];

    function __construct()
    {
        $this->model_common = new Model_Common();
        $this->model = new Model_Report();
        $this->view = new View();
        $this->data['controller_name'] = "user";
    }
    function action_report_barchart()
    {  
        $this->data["user"] = $this->model->get_user();
        $this->view->generate('report/report_barchart.php', 'template_view.php',$this->data);
        return;
    }
    public function action_getFaculty()
    {
        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role != 3) {
            $result = ["error" => 1, "message" => "У вас нет прав!"];
        } else {
            $result = $this->model->get_dataFaculty();
            if (!$result) {
                $result = ["error" => 1, "message" => "Не верные данные или кафедра была уже добавлена!"];
            }
        }
        $this->return_json($result);
        return;
    }
    public function action_getAllByYear()
    {
        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role != 3) {
            $result = ["error" => 1, "message" => "У вас нет прав!"];
        } else {
            $result = $this->model->getFacultyByYear();
            if (!$result) {
                $result = ["error" => 1, "message" => "Не верные данные или кафедра была уже добавлена!"];
            }
        }
        $this->return_json($result);
        return;
    }
    public function action_getUsers()
    {
        $user_role = $_SESSION["uid"]["role_id"];
        $users = $_POST["users"];
        if ($user_role != 3) {
            $result = ["error" => 1, "message" => "У вас нет прав!"];
        } else {
            $result = $this->model->get_dataUsers($users);
            if (!$result) {
                $result = ["error" => 1, "message" => "Неудалось получить данные о пользователе!"];
            }
        }
        $this->return_json($result);
        return;
    }
    public function action_getKafedra()
    {
        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role != 3) {
            $result = ["error" => 1, "message" => "У вас нет прав!"];
        } else {
            $result = $this->model->get_dataKafedra();
            if (!$result) {
                $result = ["error" => 1, "message" => "Не верные данные или кафедра была уже добавлена!"];
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

            $subjects = $this->model->get_material_subjects($materials[$i]['id']);
            $subjects_str = "";
            for ($j = 0; $j < count($subjects); $j++) {
                if ($j == 0) {
                    $subjects_str = $subjects[$j]["name"];
                } else {
                    $subjects_str .= ", " . $subjects[$j]["name"];
                }
            }
            $materials[$i]['subjects'] = $subjects_str;

            $specialties = $this->model->get_material_specialties($materials[$i]['id']);
            $specialties_str = "";
            for ($j = 0; $j < count($specialties); $j++) {
                if ($j == 0) {
                    $specialties_str = $specialties[$j]["code"];
                } else {
                    $specialties_str .= ", " . $specialties[$j]["code"];
                }
            }
            $materials[$i]['specialties'] = $specialties_str;
        }
        $this->data["materials"] = $materials;

        //$this->print_array( $materials ); die;
        $this->view->generate('report/all_report.php', 'template_view.php', $this->data);
    }
}
