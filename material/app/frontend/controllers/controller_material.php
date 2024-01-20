<?php
class Controller_Material extends Controller{
    private $data = [];

    function __construct() {
        //$this->model_common = new Model_Common();
        $this->model = new Model_Material();
        $this->view = new View();
        $this->data['controller_name'] = "material";
    }

    function action_index() {
        $materials = $this->model->get_materials();

        for ($i=0; $i<count($materials); $i++) {

            $authors = $this->model->get_material_authors($materials[$i]['id']);
            $authors_str = "";
            for ($j=0; $j<count($authors); $j++) {
                if ( $j == 0 ) {
                    $authors_str = $authors[$j]["name"];
                } else  {
                    $authors_str .= ", ".$authors[$j]["name"];
                }
            }
            $materials[$i]['authors'] = $authors_str;

            $subjects = $this->model->get_material_subjects($materials[$i]['id']);
            $subjects_str = "";
            for ($j=0; $j<count($subjects); $j++) {
                if ( $j == 0 ) {
                    $subjects_str = $subjects[$j]["name"];
                } else  {
                    $subjects_str .= ", ".$subjects[$j]["name"];
                }
            }
            $materials[$i]['subjects'] = $subjects_str;

            $specialties = $this->model->get_material_specialties($materials[$i]['id']);
            $specialties_str = "";
            for ($j=0; $j<count($specialties); $j++) {
                if ( $j == 0 ) {
                    $specialties_str = $specialties[$j]["code"];
                } else  {
                    $specialties_str .= ", ".$specialties[$j]["code"];
                }
            }
            $materials[$i]['specialties'] = $specialties_str;
        }
        $this->data["materials"] = $materials;

        //$this->print_array( $materials ); die;

        $this->view->generate('material/list_view.php', 'template_view.php', $this->data);
    }

    function action_author($id) {
        $materials = $this->model->get_materials_by_author($id);

        for ($i=0; $i<count($materials); $i++) {

            $authors = $this->model->get_material_authors($materials[$i]['id']);
            $authors_str = "";
            for ($j=0; $j<count($authors); $j++) {
                if ( $j == 0 ) {
                    $authors_str = $authors[$j]["name"];
                } else  {
                    $authors_str .= ", ".$authors[$j]["name"];
                }
            }
            $materials[$i]['authors'] = $authors_str;

            $subjects = $this->model->get_material_subjects($materials[$i]['id']);
            $subjects_str = "";
            for ($j=0; $j<count($subjects); $j++) {
                if ( $j == 0 ) {
                    $subjects_str = $subjects[$j]["name"];
                } else  {
                    $subjects_str .= ", ".$subjects[$j]["name"];
                }
            }
            $materials[$i]['subjects'] = $subjects_str;

            $specialties = $this->model->get_material_specialties($materials[$i]['id']);
            $specialties_str = "";
            for ($j=0; $j<count($specialties); $j++) {
                if ( $j == 0 ) {
                    $specialties_str = $specialties[$j]["code"];
                } else  {
                    $specialties_str .= ", ".$specialties[$j]["code"];
                }
            }
            $materials[$i]['specialties'] = $specialties_str;
        }
        $this->data["materials"] = $materials;

        //$this->print_array( $materials ); die;

        $this->view->generate('material/list_view.php', 'template_view.php', $this->data);
    }

    function action_specialty($id) {
        $materials = $this->model->get_materials_by_specialty($id);

        for ($i=0; $i<count($materials); $i++) {

            $authors = $this->model->get_material_authors($materials[$i]['id']);
            $authors_str = "";
            for ($j=0; $j<count($authors); $j++) {
                if ( $j == 0 ) {
                    $authors_str = $authors[$j]["name"];
                } else  {
                    $authors_str .= ", ".$authors[$j]["name"];
                }
            }
            $materials[$i]['authors'] = $authors_str;

            $subjects = $this->model->get_material_subjects($materials[$i]['id']);
            $subjects_str = "";
            for ($j=0; $j<count($subjects); $j++) {
                if ( $j == 0 ) {
                    $subjects_str = $subjects[$j]["name"];
                } else  {
                    $subjects_str .= ", ".$subjects[$j]["name"];
                }
            }
            $materials[$i]['subjects'] = $subjects_str;

            $specialties = $this->model->get_material_specialties($materials[$i]['id']);
            $specialties_str = "";
            for ($j=0; $j<count($specialties); $j++) {
                if ( $j == 0 ) {
                    $specialties_str = $specialties[$j]["code"];
                } else  {
                    $specialties_str .= ", ".$specialties[$j]["code"];
                }
            }
            $materials[$i]['specialties'] = $specialties_str;
        }
        $this->data["materials"] = $materials;

        //$this->print_array( $materials ); die;

        $this->view->generate('material/list_view.php', 'template_view.php', $this->data);
    }

    function action_subject($id) {
        $materials = $this->model->get_materials_by_subject($id);

        for ($i=0; $i<count($materials); $i++) {

            $authors = $this->model->get_material_authors($materials[$i]['id']);
            $authors_str = "";
            for ($j=0; $j<count($authors); $j++) {
                if ( $j == 0 ) {
                    $authors_str = $authors[$j]["name"];
                } else  {
                    $authors_str .= ", ".$authors[$j]["name"];
                }
            }
            $materials[$i]['authors'] = $authors_str;

            $subjects = $this->model->get_material_subjects($materials[$i]['id']);
            $subjects_str = "";
            for ($j=0; $j<count($subjects); $j++) {
                if ( $j == 0 ) {
                    $subjects_str = $subjects[$j]["name"];
                } else  {
                    $subjects_str .= ", ".$subjects[$j]["name"];
                }
            }
            $materials[$i]['subjects'] = $subjects_str;

            $specialties = $this->model->get_material_specialties($materials[$i]['id']);
            $specialties_str = "";
            for ($j=0; $j<count($specialties); $j++) {
                if ( $j == 0 ) {
                    $specialties_str = $specialties[$j]["code"];
                } else  {
                    $specialties_str .= ", ".$specialties[$j]["code"];
                }
            }
            $materials[$i]['specialties'] = $specialties_str;
        }
        $this->data["materials"] = $materials;

        //$this->print_array( $materials ); die;

        $this->view->generate('material/list_view.php', 'template_view.php', $this->data);
    }

}
?>