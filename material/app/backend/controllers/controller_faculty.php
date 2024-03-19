<?php
class Controller_Faculty extends Controller
{

    private $data = [];

    function __construct()
    {
        $this->model_common = new Model_Common();
        $this->model = new Model_Faculty();
        $this->view = new View();
        $this->data['controller_name'] = "faculty";
    }

    function action_index()
    {
        $faculty = $this->model->get_facultys();
        $this->data["faculty"] = $faculty;

        //$this->print_array($specialties); die;

        $this->view->generate('faculty/list_view.php', 'template_view.php', $this->data);
    }
    function action_index_kafedra()
    {
        $kafedra = $this->model->get_kafedra();
        $this->data["kafedra"] = $kafedra;

        //$this->print_array($specialties); die;

        $this->view->generate('faculty/list_view_kafedra.php', 'template_view.php', $this->data);
    }
    function action_add()
    {

        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role != 3) {
            $result = ["error" => 1, "message" => "У вас нет прав для добавления записи!"];
        } else {
            if (isset ($_POST["faculty"])) {
                $faculty = $_POST["faculty"];
                if ($this->model->add_faculty($faculty)) {
                    $result = ["error" => 0, "message" => "Новый факультет успешно добавлен!"];
                } else {
                    $result = ["error" => 1, "message" => "Не верные данные или факультет был уже добавлен!"];
                }
            } else {
                $result = ["error" => 1, "message" => "Не верные параметры"];
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
            return json_encode(["error" => 1, "message" => "Факультет не найден"]);
        }
        $this->return_json($faculty);
        return;
    }
    public function action_getKafedraById($id)
    {
        $faculty = $this->model->get_kafedraById($id);
        if (!$faculty) {
            return json_encode(["error" => 1, "message" => "Кафедра не найдена"]);
        }
        
        // Дополнительная информация о факультете
        $faculty["faculty"] = $this->model->get_facultys();
        
        $this->return_json($faculty);
        return;
    }

    function action_editFaculty()
    {

        /* #Get specialty data by @id */
        $id = $_POST["ID"];
        $this->data["faculty"] = $this->model->get_facultyById($id);

        if (isset ($_POST["facultyName"])) {
            $name = $_POST["facultyName"];

            if ($name != "") {
                $result = $this->model->edit_faculty($id, $name);
                if (!$result) {
                    $this->print_array($_POST);
                    die;
                    return json_encode(["error" => 1, "message" => "Ошибка при изменении"]);
                    //$this->view->generate('specialty/success_view.php', 'template_view.php', $this->data);
                    //return true;
                }
                $this->return_json($result);
            } else {
                return json_encode(["error" => 1, "message" => "Некоторые данные пусты!"]);
            }
        }
    }
}
?>