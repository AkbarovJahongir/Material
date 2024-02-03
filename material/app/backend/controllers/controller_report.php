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
        
        $this->view->generate('report/report_barchart.php', 'template_view.php', $this->data);
    }
    function action_allReport()
    {
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
        $this->view->generate('report/all_report.php', 'template_view.php', $this->data);
    }
}
