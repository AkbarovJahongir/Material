<?php
class Model_Material extends Model{

    public function get_materials(){
		$result = $this->select("SELECT m.`id`"
                                        ." ,m.`name`"
                                        ." ,t.`name` AS type_name"
                                        ." ,m.`language_id`"
                                        ." ,m.`date_publish` AS `date_publish`"
                                        ." ,m.`pub_place_id`"
                                        ." ,m.`count`"
                                        ." ,m.`file_path`"
                                        ." FROM `material` m"
                                        ." LEFT JOIN `type` t ON t.`id`=m.`type_id`"
                                        ." ORDER BY m.`date_add` DESC");
		return $result;
	}
    public function get_material_authors( $id ) {
        $result = $this->select("SELECT a.`id`, a.`name` FROM `material_author` m_a "
                                ." LEFT JOIN `author` a ON a.`id` = m_a.`author_id`"
                                ." WHERE m_a.`material_id`=?", [$id] );
        return $result;
    }
    public function get_material_subjects( $id ) {
        $result = $this->select("SELECT s.`id`, s.`name` FROM `material_subject` m_s "
                                ." LEFT JOIN `subject` s ON s.`id` = m_s.`subject_id`"
                                ." WHERE m_s.`material_id`=?", [$id] );
        return $result;
    }
    public function get_material_specialties( $id ) {
        $result = $this->select("SELECT s.`id`, s.`code`, s.`name` FROM `material_specialty` m_s "
                                ." LEFT JOIN `specialty` s ON s.`id` = m_s.`specialty_id`"
                                ." WHERE m_s.`material_id`=?", [$id] );
        return $result;
    }



    public function get_material($id){
        $result = $this->select("SELECT `id`"
                                    ." ,`name`"
                                    ." ,`type_id`"
                                    ." ,`language_id`"
                                    ." ,DATE_FORMAT(`date_publish`, \"%d/%m/%Y\") AS `date_publish`"
                                    ." ,`pub_place_id`"
                                    ." ,`count`"
                                    ." FROM `material` WHERE id=?", [$id] )[0];
        return $result;
    }

    public function get_materials_by_author($id){
        $result = $this->select("SELECT m.`id`"
            ." ,m.`name`"
            ." ,t.`name` AS type_name"
            ." ,m.`language_id`"
            ." ,m.`date_publish` AS `date_publish`"
            ." ,m.`pub_place_id`"
            ." ,m.`count` FROM `material` m"
            ." LEFT JOIN `type` t ON t.`id`=m.`type_id`"
            ." LEFT JOIN `material_author` ma ON ma.`material_id`=m.`id`"
            ." WHERE ma.`author_id`=? ORDER BY m.`date_add` DESC", [$id]);
        return $result;
    }

    public function get_materials_by_specialty($id){
        $result = $this->select("SELECT m.`id`"
            ." ,m.`name`"
            ." ,t.`name` AS type_name"
            ." ,m.`language_id`"
            ." ,m.`date_publish` AS `date_publish`"
            ." ,m.`pub_place_id`"
            ." ,m.`count` FROM `material` m"
            ." LEFT JOIN `type` t ON t.`id`=m.`type_id`"
            ." LEFT JOIN `material_specialty` ms ON ms.`material_id`=m.`id`"
            ." WHERE ms.`specialty_id`=? ORDER BY m.`date_add` DESC", [$id]);
        return $result;
    }

    public function get_materials_by_subject($id){
        $result = $this->select("SELECT m.`id`"
            ." ,m.`name`"
            ." ,t.`name` AS type_name"
            ." ,m.`language_id`"
            ." ,m.`date_publish` AS `date_publish`"
            ." ,m.`pub_place_id`"
            ." ,m.`count` FROM `material` m"
            ." LEFT JOIN `type` t ON t.`id`=m.`type_id`"
            ." LEFT JOIN `material_subject` ms ON ms.`material_id`=m.`id`"
            ." WHERE ms.`subject_id`=? ORDER BY m.`date_add` DESC", [$id]);
        return $result;
    }
}