<?php
class Controller_Material extends Controller
{

    private $data = [];
    private $language_ = [];
    
    function __construct()
    {
        $this->model_common = new Model_Common();
        $this->model = new Model_Material();
        $this->view = new View();
        $this->data['controller_name'] = "material";
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
        $materials = $this->model->get_materials();
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

    function action_get()
    {
        $materials = $this->model->get_materialByuserId($_SESSION["uid"]["role_id"],$_SESSION["uid"]["id"]);
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

        if (isset($_FILES["fileToUpload"])) {
            $target_dir = "./app/uploads/file/";

            if (!file_exists($target_dir) && !mkdir($target_dir, 0755, true)) {
                $error_message = 'Не удалось создать целевой каталог.';
            }

            $file_type = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

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
            isset($_POST["nameOfTheConference"]) &&
            isset($_POST["namejurnal"]) &&
            isset($_POST["direction"])
        ) {
            $name = $_POST["name"];
            $type = $_POST["type"];
            $language = $_POST["language"];
            $date_publish = $_POST["date_publish"];
            $place = $_POST["place"];
            $count = $_POST["count"];
            $kafedra = $_POST["kafedra"];
            $json_authors = json_decode($_POST["json_authors"]);
            $nameOfTheConference = $_POST["nameOfTheConference"];
            $namejurnal = $_POST["namejurnal"];
            $direction = $_POST["direction"];

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
                $nameOfTheConference != "" &&
                $namejurnal != "" &&
                $direction != ""
            ) {
                $jsons = [
                    "authors" => $json_authors
                ];
                $result = $this->model->add_material($name, $type, $language, $date_publish, $place, $count, $jsons, $unique_filename, $kafedra, $nameOfTheConference, $namejurnal, $direction);

                if ($result) {
                    $this->data["error"] = 0;
                    $this->data["message"] = $this->language_["successMessageMaterial"];
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = $this->language_["errorMessageMaterial"];
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = $this->language_["errorMessageMaterialAll"];
            }
        }
        $this->view->generate('material/create_view.php', 'template_view.php', $this->data);

        $fd = fopen("./log/materials_log.txt", "a") or die("Не удалось открыть файл журнала");
        $date_time_now = date("Y-m-d H:i:s",strtotime('+5 hours')); 
        fwrite($fd, $date_time_now . ": " . $error_message . "\n"); 
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

            if (!file_exists($target_dir) && !mkdir($target_dir, 0755, true)) {
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
                    $this->data["message"] = $this->language_["successeditMessageMaterial"];

                    /* #Get material data by @id */
                    $this->data["material"] = $this->model->get_material($id);
                    $this->data["json_authors"] = json_encode($this->model->get_material_authors_id($id));
                    $this->data["json_subjects"] = json_encode($this->model->get_material_subjects_id($id));
                    $this->data["json_specialties"] = json_encode($this->model->get_material_specialties_id($id));

                    // $this->view->generate('material/success_view.php', 'template_view.php', $this->data);
                    // return true;
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = $this->language_["errorMessageAll"];
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = $this->language_["errorMessageMaterialAll"];
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
        $user_role = $_SESSION["uid"]["role_id"];
        $result = $this->model->confirm_material($id, $user_role);

        if ($result) {
            $this->data["error"] = 0;
            $this->data["message"] = "successMessageConfirMaterial";
        } else {
            $this->data["error"] = 1;
            $this->data["message"] = "errorConfirmMessageMaterial";
        }
        //$this->return_json($result);
        $materials = $this->model->get_materialByuserId($_SESSION["uid"]["role_id"],$_SESSION["uid"]["id"]);
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
        // $this->print_array($this->data["materials"]); die;
        //return;
        $this->view->generate('material/list_view.php', 'template_view.php', $this->data);
    }
    function action_decline()
    {
        $id = $_POST["id"];
        $comment =  $_POST["comment"];
        $user_role = $_SESSION["uid"]["role_id"];
        $result = $this->model->decline_material($id, $comment, $user_role);

        if ($result) {
            $result = ["error" => 0, "message" => $this->language_["successDeclineMessageMaterial"]];
        } else {
            $result = ["error" => 1, "message" => $this->language_["errorDecliMessageMaterial"]];
        }
        $this->return_json($result);
        return;
    }
    function action_delete()
    {
        $user_role = $_SESSION["uid"]["role_id"];

        if ($user_role != 1) {
            $result = ["error" => 1, "message" => $this->language_["erroraccessMessageDeleteAll"]];
        } else {
            if (isset($_POST["id"])) {
                $id = $_POST["id"];
                if ($this->model->delete_material($id)) {
                    $result = ["error" => 0, "message" => $this->language_["successDelateMessageMaterial"]];
                } else {
                    $result = ["error" => 1, "message" => $this->language_["errorDeleteMessageMaterial"]];
                }
            } else {
                $result = ["error" => 1, "message" => $this->language_["errorMessageAll"]];
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
            return json_encode(["error" => 1, "message" => $this->language_["errorMessageGetMaterial"]]);
        }
        $this->return_json($material);
        return;
    }
}
