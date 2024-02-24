<?php
class Controller_Author extends Controller{

    private $data = [];

    function __construct() {
        $this->model_common = new Model_Common();
        $this->model = new Model_Author();
        $this->view = new View();
        $this->data['controller_name'] = "author";
    }

    function action_index() {
        $authors = $this->model->get_authors();
        $this->data["authors"] = $authors;

        //$this->print_array($authors); die;

		$this->view->generate('author/list_view.php', 'template_view.php', $this->data);
	}
    function action_add() {

        /* #Field names with POST request
         * @name
         * @degree
        */

        if ( isset($_POST["name"]) && isset($_POST["degree"]) )
        {
            //$this->print_array( $_POST ); die;
            $name = $_POST["name"];
            $degree = $_POST["degree"];

            if ( $name != "" )
            {
                $result = $this->model->add_author( $name, $degree );

                if ( $result ) {
                    $this->data["error"] = 0;
                    $this->data["message"] = "Новый автор успешно добавлен!";
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = "Не верные данные!";
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = "Некоторые данные пусты!";
            }
        }

        $this->view->generate('author/add_view.php', 'template_view.php', $this->data);
    }

    function action_edit($id) {

        /* #Get author data by @id */
        $this->data["author"] = $this->model->get_author( $id );

        /* #Field names with POST request
         * @name
         * @degree
        */

        if ( isset($_POST["name"]) && isset($_POST["degree"]) )
        {
            //$this->print_array( $_POST ); die;
            $name = $_POST["name"];
            $degree = $_POST["degree"];

            if ( $name != "" )
            {

                $result = $this->model->edit_author( $id, $name, $degree );

                if ( $result ) {
                    $this->data["error"] = 0;
                    $this->data["message"] = "Автор успешно изменен!";

                    /* #Get author data by @id */
                    $this->data["author"] = $this->model->get_author( $id );
                } else {
                    $this->data["error"] = 1;
                    $this->data["message"] = "Не верные данные!";
                }
            } else {
                $this->data["error"] = 1;
                $this->data["message"] = "Некоторые данные пусты!";
            }
        }

        $this->view->generate('author/edit_view.php', 'template_view.php', $this->data);
    }

    function action_delete() {

        $user_role = $_SESSION["uid"]["role_id"];

        if ( $user_role != 1 ) {
            $result = ["error" => 1, "message" => "У вас нет прав для удаление записи!"];
        } else {
            if ( isset($_POST["id"]) ) {
                $id = $_POST["id"];
                if ( $this->model->delete_author( $id ) ) {
                    $result = ["error" => 0, "message" => "Автор успешно удален!"];
                } else {
                    $result = ["error" => 1, "message" => "Вы не можете удалить этого автора! Так как он есть в списке материалов!"];
                }
            } else {
                $result = ["error" => 1, "message" => "Не верные параметры"];
            }
        }
        $this->return_json($result);
        return;
    }
}
?>