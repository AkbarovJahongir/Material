<?php
class Controller_User extends Controller
{
    private $data = [];

    function __construct()
    {
        $this->model_common = new Model_Common();
        $this->model = new Model_User();
        $this->view = new View();
        $this->data['controller_name'] = "user";
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
        // Открытие файла для записи лога
        $fd = fopen("./log/users_log.txt", "a") or die("Не удалось открыть файл лога");
        // Check if "fileToUpload" key is set in $_FILES
        //$this->print_array($_FILES["image_url"]); die;
        if (isset($_FILES["image_url"])) {
            $target_dir = "./app/uploads/image_users/";

            // Create the target directory if it doesn't exist
            if (!file_exists($target_dir) && !mkdir($target_dir, 0755, true)) {
                echo 'Failed to create the target directory';
                die('Failed to create the target directory');
            }

            $file_type = strtolower(pathinfo($_FILES["image_url"]["name"], PATHINFO_EXTENSION));

            // Генерация уникального имени для файла
            $unique_filename = $_FILES["image_url"]["name"]; // uniqid() . "." . $file_type;

            $target_file = $target_dir . $unique_filename;

            // Проверка наличия файла
            if ($_FILES["image_url"]["size"] == 0) {
                echo "Файл не был загружен.";
                $error_message = "Файл не был загружен.";
            }

            $allowed_extensions = array("png", "jpg");

            if (!in_array($file_type, $allowed_extensions)) {
                echo "Недопустимый формат файла.";
                $error_message = "Недопустимый формат файла.";
            }

            if (isset($_FILES["image_url"]["tmp_name"]) && move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
                echo "Файл " . basename($_FILES["image_url"]["name"]) . " успешно загружен.";
            } else {
                echo "Ошибка при загрузке файла.";
                $error_message = "Ошибка при загрузке файла.";
            }
        } else {
            echo "Файл не был загружен.";
            $error_message = "Файл не был загружен.";
        }
        $this->data["role"] = $this->model_common->get_roles();
        //$this->print_array( $_POST ); die;
        if (
            isset($_POST["login"]) && 
            isset($_POST["name"]) && 
            isset($_POST["password"]) && 
            isset($_POST["role_id"]) && 
            isset($unique_filename) &&
            isset($_POST["role"]) && 
            isset($_POST["access"])
        ) {
            $login = $_POST["login"];
            $name = $_POST["name"];
            $password = $_POST["password"];
            $role_id = $_POST["role_id"];
            $access = $_POST["access"];
            $role = json_decode($_POST["role"]);

            if ($login != "" && $name != "" && $password != "" && $role_id != "" && $unique_filename != "" && $access != "") {
                $jsons = ["role_id" => $role];
                $result = $this->model->add_user($name, $login, $password, $access, $jsons, $unique_filename);
                //$this->print_array($_POST);
                die;
                if ($result) {
                    $this->data["error"] = 0;
                    $this->data["message"] = "Новый пользователь добавлен!";
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = "Не верные данные!";
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = "Некоторые данные пусты!";
            }

        }
        $this->view->generate('user/add_view.php', 'template_view.php', $this->data);

        fwrite($fd, $error_message . "\n");
        fclose($fd);
    }

    function action_edit($id)
    {

        $this->data["user"] = $this->model->get_user($id);

        $this->data["role"] = $this->model_common->get_roles();

        if (
            isset($_POST["login"]) && isset($_POST["name"]) && isset($_POST["password"]) && isset($_POST["role_id"]) && isset($_POST["image_url"]) &&
            isset($_POST["role"]) && isset($_POST["access"])
        ) {
            //$this->print_array( $_POST ); die;
            $login = $_POST["login"];
            $name = $_POST["name"];
            $password = $_POST["password"];
            $role_id = $_POST["role_id"];
            $image_url = $_POST["image_url"];
            $access = $_POST["access"];
            $role = json_decode($_POST["role"]);

            if ($login != "" && $name != "" && $password != "" && $role_id != "" && $image_url != "" && $access != "") {
                $jsons = ["role_id" => $role];
                $result = $this->model->edit_user($id, $name, $login, $password, $access, $image_url, $jsons);

                if ($result) {
                    $this->data["error"] = 0;
                    $this->data["message"] = "Специальность успешно изменен!";
                    /* #Get specialty data by @id */
                    $this->data["user"] = $this->model->get_user($id);
                    //$this->view->generate('user/index.php', 'template_view.php', $this->data);
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
        //$this->print_array($this->data["user"]);die;
        $this->view->generate('user/edit_view.php', 'template_view.php', $this->data);
    }
}
