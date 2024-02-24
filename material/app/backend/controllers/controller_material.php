<?php
class Controller_Material extends Controller
{

    private $data = [];

    function __construct()
    {
        $this->model_common = new Model_Common();
        $this->model = new Model_Material();
        $this->view = new View();
        $this->data['controller_name'] = "material";
    }

    function action_index()
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

        $this->view->generate('material/list_view.php', 'template_view.php', $this->data);
    }

    function action_get()
    {
        $materials = $this->model->get_materialByuserId($_SESSION["uid"]["role_id"]);
        //$this->print_array($materials);die;
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

        $this->view->generate('material/list_view.php', 'template_view.php', $this->data);
    }

    function action_add()
    {
        $error_message = '';

        //$this->print_array($_POST); 
        //$this->print_array($_FILES["fileToUpload"]);die;
        /* #Получение общих данных */
        $this->data["authors"] = $this->model_common->get_authors();
        $this->data["languages"] = $this->model_common->get_languages();
        $this->data["specialties"] = $this->model_common->get_specialties();
        $this->data["subjects"] = $this->model_common->get_subjects();
        $this->data["types"] = $this->model_common->get_types();
        $this->data["places"] = $this->model_common->get_places();
        $this->data["kafedra"] = $this->model_common->get_kafedra();

        // Check if "fileToUpload" key is set in $_FILES
        if (isset($_FILES["fileToUpload"])) {
            $target_dir = "./app/uploads/file/";

            // Create the target directory if it doesn't exist
            if (!file_exists($target_dir) && !mkdir($target_dir, 0755, true)) {
                //echo 'Failed to create the target directory';
                $error_message = 'Не удалось создать целевой каталог.';
            }

            $file_type = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

            // Генерация уникального имени для файла
            $unique_filename =  $_FILES["fileToUpload"]["name"]; // uniqid() . "." . $file_type;

            $target_file = $target_dir . $unique_filename;

            // Проверка наличия файла
            if ($_FILES["fileToUpload"]["size"] == 0) {
                //echo "Файл не был загружен.";
                $error_message = "Файл не был загружен.";
            }

            $allowed_extensions = array("pdf", "doc", "docx", "txt");

            if (!in_array($file_type, $allowed_extensions)) {
                // echo "Недопустимый формат файла.";
                $error_message = "Недопустимый формат файла.";
            }

            if (isset($_FILES["fileToUpload"]["tmp_name"]) && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                //echo "Файл " . basename($_FILES["fileToUpload"]["name"]) . " успешно загружен.";
            } else {
                //echo "Ошибка при загрузке файла.";
                $error_message = "Ошибка при загрузке файла.";
            }
        } else {
            //echo "Файл не был загружен.";
            $error_message = "Файл не был загружен.";
        }

        if (
            isset($_POST["name"]) &&
            isset($_POST["type"]) &&
            isset($_POST["language"]) &&
            isset($_POST["date_publish"]) &&
            isset($_POST["place"]) &&
            isset($_POST["count"]) &&
            isset($_POST["kafedra"]) &&
            isset($unique_filename) &&
            isset($_POST["json_authors"]) &&
            isset($_POST["json_subjects"]) &&
            isset($_POST["json_specialties"])
        ) {
            //$this->print_array($_FILES["fileToUpload"]);
            $name = $_POST["name"];
            $type = $_POST["type"];
            $language = $_POST["language"];
            $date_publish = $_POST["date_publish"];
            $place = $_POST["place"];
            $count = $_POST["count"];
            $kafedra = $_POST["kafedra"];
            $json_authors = json_decode($_POST["json_authors"]);
            $json_subjects = json_decode($_POST["json_subjects"]);
            $json_specialties = json_decode($_POST["json_specialties"]);
            // $this->print_array($_POST["name"]); 
            // $this->print_array($_POST["type"]); 
            // $this->print_array($_POST["language"]); 
            // $this->print_array($_POST["date_publish"]); 
            // $this->print_array($_POST["place"]); 
            // $this->print_array($_POST["count"]); 
            // $this->print_array($_POST["kafedra"]); 
            // $this->print_array($json_authors); 
            // $this->print_array($json_subjects); 
            // $this->print_array($json_specialties);
            // $this->print_array($_POST["kafedra"]);
            //die;

            if (
                $name != "" &&
                $type != "" &&
                $language != "" &&
                $date_publish != "" &&
                $place != "" &&
                $count != "" &&
                $kafedra != "" &&
                $unique_filename != "" &&
                $json_authors != null &&
                $json_subjects != null &&
                $json_specialties != null
            ) {
                $jsons = [
                    "authors" => $json_authors,
                    "subjects" => $json_subjects,
                    "specialties" => $json_specialties,
                ];
                $result = $this->model->add_material($name, $type, $language, $date_publish, $place, $count, $jsons, $unique_filename, $kafedra);

                if ($result) {
                    $this->data["error"] = 0;
                    $this->data["message"] = "Новый материал успешно добавлен!";
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = "Неверные данные или материал был уже добавлен!";
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = "Некоторые данные пусты!";
            }
        }
        $this->view->generate('material/create_view.php', 'template_view.php', $this->data);

        $fd = fopen("./log/materials_log.txt", "a") or die("Не удалось открыть файл журнала");
        $date_time_now = date("Y-m-d H:i:s",strtotime('+5 hours')); // Get current date and time in the format YYYY-MM-DD HH:MM:SS
        fwrite($fd, $date_time_now . ": " . $error_message . "\n"); // Append date and time to the error message
        fclose($fd);
    }

    function action_edit($id)
    {
        $error_message = '';
        //$this->print_array($_POST); 
        //$this->print_array($_FILES["fileToUpload"]);die;
        // Check if "fileToUpload" key is set in $_FILES
        if (isset($_FILES["fileToUpload"])) {
            $target_dir = "./app/uploads/file/";

            // Create the target directory if it doesn't exist
            if (!file_exists($target_dir) && !mkdir($target_dir, 0755, true)) {
                //echo 'Failed to create the target directory';
                $error_message = 'Не удалось создать целевой каталог.';
            }

            $file_type = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

            // Генерация уникального имени для файла
            $unique_filename =  $_FILES["fileToUpload"]["name"]; // uniqid() . "." . $file_type;

            $target_file = $target_dir . $unique_filename;

            // Проверка наличия файла
            if ($_FILES["fileToUpload"]["size"] == 0) {
                //echo "Файл не был загружен.";
                $error_message = "Файл не был загружен.";
            }

            $allowed_extensions = array("png", "jpeg", "jpg", "txt");

            if (!in_array($file_type, $allowed_extensions)) {
                // echo "Недопустимый формат файла.";
                $error_message = "Недопустимый формат файла.";
            }

            if (isset($_FILES["fileToUpload"]["tmp_name"]) && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                //echo "Файл " . basename($_FILES["fileToUpload"]["name"]) . " успешно загружен.";
            } else {
                //echo "Ошибка при загрузке файла.";
                $error_message = "Ошибка при загрузке файла.";
            }
        } else {
            //echo "Файл не был загружен.";
            $error_message = "Файл не был загружен.";
        }
        $this->data["authors"] = $this->model_common->get_authors();
        $this->data["kafedra"] = $this->model_common->get_kafedra();
        $this->data["languages"] = $this->model_common->get_languages();
        $this->data["specialties"] = $this->model_common->get_specialties();
        $this->data["subjects"] = $this->model_common->get_subjects();
        $this->data["types"] = $this->model_common->get_types();
        $this->data["places"] = $this->model_common->get_places();
        //$this->print_array($_FILES["fileToUpload"]); die;

        $this->data["material"] = $this->model->get_material($id);
        $this->data["json_authors"] = json_encode($this->model->get_material_authors_id($id));
        $this->data["json_subjects"] = json_encode($this->model->get_material_subjects_id($id));
        $this->data["json_specialties"] = json_encode($this->model->get_material_specialties_id($id));
        //
        if (
            isset($_POST["name"]) &&
            isset($_POST["type"]) &&
            isset($_POST["language"]) &&
            isset($_POST["date_publish"]) &&
            isset($_POST["place"]) &&
            isset($_POST["count"]) &&
            isset($_POST["kafedra"]) &&
            isset($unique_filename) &&
            isset($_POST["json_authors"]) &&
            isset($_POST["json_subjects"]) &&
            isset($_POST["json_specialties"])
        ) {
           
            $name = $_POST["name"];
            $type = $_POST["type"];
            $language = $_POST["language"];
            $date_publish = $_POST["date_publish"];
            $place = $_POST["place"];
            $count = $_POST["count"];
            $kafedra = $_POST["kafedra"];
            $json_authors = json_decode($_POST["json_authors"]);
            $json_subjects = json_decode($_POST["json_subjects"]);
            $json_specialties = json_decode($_POST["json_specialties"]);

            if (
                $name != "" &&
                $type != "" &&
                $language != "" &&
                $date_publish != "" &&
                $place != "" &&
                $count != "" &&
                $kafedra != "" &&
                $unique_filename != "" &&
                $json_authors != null &&
                $json_subjects != null &&
                $json_specialties != null
            ) {
                $jsons = [
                    "authors" => $json_authors,
                    "subjects" => $json_subjects,
                    "specialties" => $json_specialties,
                ];

                $date = str_replace('/', '-', $date_publish);
                $date_publish = date('Y-m-d', strtotime($date));

                // $this->print_array([ "id" => $id
                //     ,"name" => $name
                //     ,"type" => $type
                //     ,"language" => $language
                //     ,"date_publish" => $date_publish
                //     ,"place" => $place
                //     ,"count" => $count
                //     ,"jsons" => $jsons ]); die;

                $result = $this->model->edit_material($id, $name, $type, $language, $date_publish, $place, $count, $unique_filename, $jsons, $kafedra);

                if ($result) {
                    $this->data["error"] = 0;
                    $this->data["message"] = "Материал успешно изменен!";

                    /* #Get material data by @id */
                    $this->data["material"] = $this->model->get_material($id);
                    $this->data["json_authors"] = json_encode($this->model->get_material_authors_id($id));
                    $this->data["json_subjects"] = json_encode($this->model->get_material_subjects_id($id));
                    $this->data["json_specialties"] = json_encode($this->model->get_material_specialties_id($id));

                    // $this->view->generate('material/success_view.php', 'template_view.php', $this->data);
                    // return true;
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = "Не верные данные!";
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = "Некоторые данные пусты!";
            }
        }

        $fd = fopen("./log/materials_log.txt", "a") or die("Не удалось открыть файл журнала");
        $date_time_now = date("Y-m-d H:i:s",strtotime('+5 hours')); // Get current date and time in the format YYYY-MM-DD HH:MM:SS
        fwrite($fd, $date_time_now . ": " . $error_message . "\n"); // Append date and time to the error message
        fclose($fd);
        $this->view->generate('material/edit_view.php', 'template_view.php', $this->data);
    }
    function action_confirm($id)
    {
        $result = $this->model->confirm_material($id);

        if ($result) {
            $this->data["error"] = 0;
            $this->data["message"] = "Материал успешно подтвержден!";
        } else {
            $this->data["error"] = 1;
            $this->data["message"] = "По каким то причинам материал не может быть подтвержден!";
        }
        //$this->return_json($result);
        $materials = $this->model->get_materialByuserId($_SESSION["uid"]["id"]);
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
        //$this->print_array($_FILES["fileToUpload"] ); die;
        $this->view->generate('material/list_view.php', 'template_view.php', $this->data);
    }
    function action_decline()
    {
        $id = $_POST["id"];
        $comment =  $_POST["comment"];
        $result = $this->model->decline_material($id, $comment);

        if ($result) {
            $this->data["error"] = 0;
            $this->data["message"] = "Материал отклонен!";
        } else {
            $this->data["error"] = 1;
            $this->data["message"] = "По каким то причинам материал не может быть отклонен!";
        }
        $this->return_json($result);
        return;
        $materials = $this->model->get_materialByuserId($_SESSION["uid"]["id"]);
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
        $this->view->generate('material/list_view.php', 'template_view.php', $this->data);
    }
    function action_delete()
    {

        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role != 1) {
            $result = ["error" => 1, "message" => "У вас нет прав для удаление записи!"];
        } else {
            if (isset($_POST["id"])) {
                $id = $_POST["id"];
                if ($this->model->delete_material($id)) {
                    $result = ["error" => 0, "message" => "Метериал успешно удален!"];
                } else {
                    $result = ["error" => 1, "message" => "Невозможно удалить материал!"];
                }
            } else {
                $result = ["error" => 1, "message" => "Не верные параметры"];
            }
        }
        $this->return_json($result);
        return;
    }
    function action_author($id)
    {
        $materials = $this->model->get_materials_by_author($id);

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

        $this->view->generate('material/list_view.php', 'template_view.php', $this->data);
    }
    function action_specialty($id)
    {
        $materials = $this->model->get_materials_by_specialty($id);

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

        $this->view->generate('material/list_view.php', 'template_view.php', $this->data);
    }

    function action_subject($id)
    {
        $materials = $this->model->get_materials_by_subject($id);

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

        $this->view->generate('material/list_view.php', 'template_view.php', $this->data);
    }

    public function action_getMaterialById($id)
    {
        $material = $this->model->get_material($id);
        if (!$material) {
            return json_encode(["error" => 1, "message" => "Материал не найден"]);
        }
        $this->return_json($material);
        return;
    }
}
