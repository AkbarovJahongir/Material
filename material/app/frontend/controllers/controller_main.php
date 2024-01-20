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

	function action_smessage($text){
		include "app/models/model_common.php";
		$common = new Model_Common();
		$data = $common->sendTextMessage("Привет!\nДавай знакомиться, Я бот от @OsonEatsBot! 🔥");
		// $this->return($data);
		print_r($data);
	}

	public function action_send_push(){
		$serverKey = "AAAAzO5jISI:APA91bHCo0c0qrxe4mHYvh9iEJHUhqdNletJXxWEIAKywMYB74qQg3AnEwG4rXkql8vGBCnTd35yeXMru1zU1ty6s-c_Map3ohzHvwnej5O702RkKp6emIp3FNym1ZuEze3c1oMq1YfQ";
		$title = "New post!";
		$body = "How to send a simple FCM notification in php";
		$customData = ["body" => $body, "title" => $title, "action" => "refresh"];
		$topic = "new_order";
		
	    if($serverKey != ""){
	        ini_set("allow_url_fopen", "On");
	        $data = 
	        [
	            "to" => '/topics/'.$topic,
	            // "notification" => [
	            //     "body" => $body,
	            //     "title" => $title,
	            // ],
	            "data" => $customData
	        ];

	        $options = array(
	            'http' => array(
	                'method'  => 'POST',
	                'content' => json_encode( $data ),
	                'header'=>  "Content-Type: application/json\r\n" .
	                            "Accept: application/json\r\n" . 
	                            "Authorization:key=".$serverKey
	            )
	        );

	        $context  = stream_context_create( $options );
	        $result = file_get_contents( "https://fcm.googleapis.com/fcm/send", false, $context );
	        $return = json_decode( $result );
	    }
	    $this->return($return);
	}

	

}
?>