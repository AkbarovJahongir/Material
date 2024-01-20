<?php
class View{
	function generate($content_view, $template_view, $data = null){
		include 'app/'.Route::$app_side.'/views/'.$template_view;
	}

	function generate_one($content_view, $data = null){
		include 'app/'.Route::$app_side.'/views/'.$content_view;
	}
}
?>