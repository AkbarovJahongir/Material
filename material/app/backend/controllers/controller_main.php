<?php
class Controller_Main extends Controller{
	function action_index(){	
		$this->view->generate('main_view.php', 'template_view.php');
	}
	
	function action_menustick(){	
		if(isset($_POST['sidenav_toggled'])){
			if($_POST['sidenav_toggled'] != ''){
				$_SESSION["sidenav_toggled"] = $_POST['sidenav_toggled'];
			}
		}
		
		//print_r($_POST);
	}
}
?>