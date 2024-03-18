<?php
class Controller_Specialty extends Controller{

    private $data = [];

    function __construct() {
        $this->model_common = new Model_Common();
        $this->model = new Model_Specialty();
        $this->view = new View();
        $this->data['controller_name'] = "specialty";
    }

    function action_index() {
        $specialties = $this->model->get_specialties();
        $this->data["specialties"] = $specialties;

        //$this->print_array($specialties); die;

		$this->view->generate('specialty/list_view.php', 'template_view.php', $this->data);
	}
    function action_add() {

        /* #Field names with POST request
         * @code
         * @name
        */

        if ( isset($_POST["code"]) && isset($_POST["name"]) )
        {
            //$this->print_array( $_POST ); die;
            $code = $_POST["code"];
            $name = $_POST["name"];

            if ( $code != "" && $name != "" )
            {
                $result = $this->model->add_specialty( $code, $name );

                if ( $result ) {
                    $this->data["error"] = 0;
                    $this->data["message"] = "Новый специальность успешно добавлен!";
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = "Не верные данные!";
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = "Некоторые данные пусты!";
            }
        }

        $this->view->generate('specialty/add_view.php', 'template_view.php', $this->data);
    }

    function action_edit($id) {

        /* #Get specialty data by @id */
        $this->data["specialty"] = $this->model->get_specialty( $id );

        /* #Field names with POST request
         * @code
         * @name
        */

        if ( isset($_POST["code"]) && isset($_POST["name"]) )
        {
            //$this->print_array( $_POST ); die;
            $code = $_POST["code"];
            $name = $_POST["name"];

            if ( $code != "" && $name != "" )
            {

                $result = $this->model->edit_specialty( $id, $code, $name );

                if ( $result ) {
                    $this->data["error"] = 0;
                    $this->data["message"] = "Специальность успешно изменен!";
                    /* #Get specialty data by @id */
                    $this->data["specialty"] = $this->model->get_specialty( $id );
                    //$this->view->generate('specialty/success_view.php', 'template_view.php', $this->data);
                    //return true;
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = "Не верные данные!";
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = "Некоторые данные пусты!";
            }
        }

        $this->view->generate('specialty/edit_view.php', 'template_view.php', $this->data);
    }
    function action_list_faculty() {
        $faculty = $this->model->get_facultys();
        $this->data["faculty"] = $faculty;

        //$this->print_array($specialties); die;

		$this->view->generate('specialty/list_view_faculty.php', 'template_view.php', $this->data);
	}
    function action_addFaculty() {
        
        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role != 3) {
            $result = ["error" => 1, "message" => "У вас нет прав для добавления записи!"];
        } else {
            if (isset($_POST["faculty"])) {
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

    public function action_getSpecialtyById($id)
    {
        $faculty = $this->model->get_facultyById($id);
        if (!$faculty) {
            return json_encode(["error" => 1, "message" => "Факультет не найден"]);
        }
        $this->return_json($faculty);
        return;
    }
    function action_editFaculty() {
        
        /* #Get specialty data by @id */
        $id = $_POST["ID"];
        $this->data["faculty"] = $this->model->get_facultyById($id);

        if (isset($_POST["facultyName"]) )
        {
            $name = $_POST["facultyName"];

            if ($name != "" )
            {
                $result = $this->model->edit_faculty( $id, $name );
                if ( !$result ) {
                    $this->print_array( $_POST ); die;
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