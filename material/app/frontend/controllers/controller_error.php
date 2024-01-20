<?php
class Controller_Error extends Controller
{
    function action_index()
    {
        $this->view->generate('404_view.php', 'template_view.php');
    }

    function action_404()
	{	
		$this->view->generate('404_view.php', 'template_view.php');
	}
	function action_403()
	{	
		$this->view->generate('403_view.php', 'template_view.php');
	}
}
?>