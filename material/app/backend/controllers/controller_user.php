<?php
class Controller_User extends Controller
{
    private $data = [];
    private $language_ = [];

    function __construct()
    {
        $this->model_common = new Model_Common();
        $this->model = new Model_User();
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

    function action_index()
    {
        $users = $this->model->get_users();
        $this->data["users"] = $users;

        //$this->print_array($this->data); die;

        $this->view->generate('user/list_view.php', 'template_view.php', $this->data);
    }

    function action_add()
    {
        $error_message = '';

        if (isset($_FILES["image_url"])) {
            $target_dir = "./app/uploads/image_users/";

            if (!file_exists($target_dir) && !mkdir($target_dir, 0755, true)) {
                //echo 'Failed to create the target directory';
                $error_message = 'Не удалось создать целевой каталог.';
            }

            $file_type = strtolower(pathinfo($_FILES["image_url"]["name"], PATHINFO_EXTENSION));

            // Генерация уникального имени для файла
            $unique_filename = $_FILES["image_url"]["name"]; // uniqid() . "." . $file_type;

            $target_file = $target_dir . $unique_filename;

            // Проверка наличия файла
            if ($_FILES["image_url"]["size"] == 0) {
                //echo "Файл не был загружен.";
                $error_message = "Файл не был загружен.";
            }

            $allowed_extensions = array("png", "jpg");

            if (!in_array($file_type, $allowed_extensions)) {
                // echo "Недопустимый формат файла.";
                $error_message = "Недопустимый формат файла.";
            }

            if (isset($_FILES["image_url"]["tmp_name"]) && move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
                //echo "Файл " . basename($_FILES["fileToUpload"]["name"]) . " успешно загружен.";
            } else {
                //echo "Ошибка при загрузке файла.";
                $error_message = "Ошибка при загрузке файла.";
            }
        } else {
            $error_message = "File was not uploaded.";
        }
        //$this->print_array($_POST);die;
        //$this->print_array($unique_filename);die;
        if (
            !empty($_POST["login"]) &&
            !empty($_POST["name"]) &&
            !empty($_POST["password"]) &&
            //isset($unique_filename) &&
            !empty($_POST["role"]) &&
            !empty($_POST["kafedra"]) &&
            !empty($_POST["access"]) &&
            !empty($_POST["author"])
        ) {
            $login = $_POST["login"];
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $father_name = $_POST["father_name"];
            $password = $_POST["password"];
            $role_id = $_POST["role"];
            $kafedra = $_POST["kafedra"];
            $access = $_POST["access"] == 'on' ? 1 : 0;
            $full_name = $surname . ' ' . $name . ' ' . $father_name;
            $author_id = $_POST["author"];
            if ($login != "" && $full_name != "" && $password != "" && $role_id != "" && $unique_filename != "" && $access != "" && $kafedra != "" && $author_id != "") {
                $result = $this->model->add_user($full_name, $login, $password, $access, $role_id, $unique_filename, $kafedra,$author_id);

                if ($result) {
                    $this->data["error"] = 0;
                    $this->data["message"] = $this->language_["successMessageUser"];
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = $this->language_["errorMessageAll"];
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = $this->language_["errorMessageAuthorAll"];
            }
        }

        $this->data["role"] = $this->model_common->get_roles();
        $this->data["kafedra"] = $this->model_common->get_kafedra();
        $this->data["author"] = $this->model_common->get_authors();
        //$this->data["users"] = $this->model->get_user();
        //$this->print_array($this->data["author"]);die;
        $this->view->generate('user/add_view.php', 'template_view.php', $this->data);

        // Logging error messages
        $fd = fopen("./log/users_log.txt", "a") or die("Не удалось открыть файл журнала");
        $date_time_now = date("Y-m-d H:i:s"); // Get current date and time in the format YYYY-MM-DD HH:MM:SS
        fwrite($fd, $date_time_now . ": " . $error_message . "\n"); // Append date and time to the error message
        fclose($fd);
    }


    function action_edit($id)
    {
        // $this->print_array($id);
        // die;

        $this->data["user"] = $this->model->get_user($id);
        $this->data["kafedra"] = $this->model_common->get_kafedra();
        $this->data["author"] = $this->model_common->get_authors();

        $this->data["role"] = $this->model_common->get_roles();
        //$this->print_array($_POST);die;
        if (
            isset($_POST["login"]) && isset($_POST["name"]) &&
            !empty($_POST["kafedra"]) && isset($_POST["role"]) && isset($_POST["image_url"]) && isset($_POST["access"]) && isset($_POST["author"])
        ) {
            $login = $_POST["login"];
            $name = $_POST["name"];
            $kafedra = $_POST["kafedra"];
            $role_id = $_POST["role"];
            $image_url = $_POST["image_url"];
            $access = $_POST["access"] == 'on' ? 1 : 0;
            $author_id = $_POST["author"];

            if ($login != "" && $name != "" && $kafedra != "" && $role_id != "" && $image_url != "" && $access != "" && $author_id != "") {
                $result = $this->model->edit_user($id, $name, $login, $kafedra, $access, $image_url, $role_id,$author_id);

                if ($result) {
                    $this->data["error"] = 0;
                    $this->data["message"] = $this->language_["successeditMessageUser"];
                    /* #Get specialty data by @id */
                    $this->data["user"] = $this->model->get_user($id);
                    //$this->view->generate('user/index.php', 'template_view.php', $this->data);
                    //return true;
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = $this->language_["errorMessageAll"];
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = $this->language_["errorMessageAuthorAll"];
            }
        }
        //$this->data["user"] = $this->model->get_user($id);
        //  $this->print_array($this->data);
        //  die;
        $this->view->generate('user/edit_view.php', 'template_view.php', $this->data);
    }

    function action_operation()
    {
        // $this->print_array($id, $type_operation);
        // die;
        $id = $_POST["id"];
        $type_operation =  $_POST["typeOperation"];
        if (isset($id) && isset($type_operation)) {
            if($type_operation == "blockUser"){
                $result = $this->model->access_user($id, 0);
                if ($result) {
                    $this->return_json($result);
                    return;
                } else {
                    return json_encode(["error" => 1, "message" => $this->language_["errorblockMessageUser"]]);
                }
            }
            else if($type_operation == "unlockUser"){
                $result = $this->model->access_user($id, 1);
                if ($result) {
                    $this->return_json($result);
                    return;
                } else {
                    return json_encode(["error" => 1, "message" => $this->language_["errorunblockMessageUser"]]);
                }
            }
        }else {
            return json_encode(["error" => 1, "message" => $this->language_["errorOperationMessageUser"]]);
        }
    }

    public function action_getUserById($id)
    {
        $user = $this->model->get_user($id);
        if (!$user) {
            return json_encode(["error" => 1, "message" => $this->language_["errorMessageGetUser"]]);
        }
        $this->return_json($user);
        return;
    }

    function action_resetPassword()
    {
        $id = $_POST["id"];
        $password =  $_POST["password"];

        if (isset($id) && isset($password)) {
                $result = $this->model->reset_password($id, $password);
                if ($result) {
                    $this->return_json($result);
                    return;
                } else {
                    return json_encode(["error" => 1, "message" => $this->language_["errorMessageResetPasswordUser"]]);
                }
        }
        else{
            return json_encode(["error" => 1, "message" => $this->language_["errorMessageResetPasswordUser"]]);
        }
    }
}
?>