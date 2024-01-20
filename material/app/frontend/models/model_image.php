<?php

class Model_Image extends Model{
	
	public function get_image($image_id){
		$result = $this->select("SELECT `src` FROM `images` WHERE id=?",array($image_id));
		return $result[0]['src'];
	}
	
	public function add_image($src, $category, $date_in){

		return $this->insert_getId("INSERT INTO `images` SET src=?, category=?, date_in=?", array($src, $category, $date_in));
	}

	public function edit_image($src, $category, $date_in){

		return $this->update("UPDATE INTO `images` SET src=?, category=?, date_in=?", array($src, $category, $date_in));
	}
	
}