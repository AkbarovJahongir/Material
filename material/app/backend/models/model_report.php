<?php
class Model_Report extends Model
{
    public function check_account($login)
    {
        return $this->select("SELECT id FROM `user` WHERE login=?", array($login));
    }
    public function get_user()
	{
		$result = $this->select("SELECT `user`.*"
        . " FROM `user`"
        . " INNER JOIN `material` ON `user`.`id` = `material`.`user_id`"
        . " WHERE `user`.`role_id` NOT IN (3,4)"
        . " GROUP BY `user`.`id`"
        . " HAVING COUNT(`material`.`id`) > 0;");
		return $result;
	}
    public function get_kafedra()
    {
        $result = $this->select(
            "SELECT k.`id`"
            . " ,k.`name`"
            . " ,`f`.`name` AS `facultyName`"
            . " FROM `kafedra` AS k"
            . " INNER JOIN `faculty` AS `f` ON `f`.id = k.faculty_id"
            . " ORDER BY k.`date_add` DESC"
        );
        return $result;
    }
    public function get_materials()
    {
        $result = $this->select(
            "SELECT m.`id`"
            . " ,m.`name`"
            . " ,t.`name` AS type_name"
            . " ,m.`language_id`"
            . " ,DATE_FORMAT(m.`date_publish`, \"%d/%m/%Y\") AS `date_publish`"
            . " ,m.`pub_place_id`"
            . " ,m.`count`"
            . " ,mt.desciption"
            . " ,m.`file_path`"
            . " ,uk.name AS user_k"
            . " ,ud.name AS user_d" 
            . " ,m.`conference_name`"
            . " ,m.`name_jurnal`"
            . " ,md.`name` AS direction"
            . " FROM `material` m"
            . " LEFT JOIN `type` t ON t.`id`=m.`type_id`"
            . " INNER JOIN `material_status` mt ON m.`status` = mt.id"
            . " INNER JOIN `material_direction` AS `md` ON m.`material_direction_id` = `md`.`id`"
            . " LEFT JOIN `user` uk ON m.user_k = uk.id"
            . " LEFT JOIN `user` ud ON m.user_d = ud.id"
            . " ORDER BY m.`date_add` DESC"
        );
        return $result;
    }
    public function get_dataFaculty(){
        return $this->select("SELECT f.`name`, COUNT(m.id) AS `count` FROM faculty f"
        ." LEFT JOIN kafedra k ON f.id = k.faculty_id"
        ." LEFT JOIN `material` m ON m.kafedra_id = k.id"
        ." GROUP BY f.`name`");
    }
    public function getFacultyByYear(){
        return $this->select(" SELECT COUNT(id) AS `count`,YEAR(date_publish) AS `year` FROM `material`"
        ." GROUP BY YEAR(date_publish)"
        ." ORDER BY YEAR(date_publish) ASC");
    }
    public function get_dataKafedra($kafedra){
        return $this->select("SELECT k.`name`, COUNT(m.id) AS `count`,YEAR(m.date_publish) AS `year` FROM kafedra k"
        ." LEFT JOIN material m ON k.id = m.kafedra_id"
        ." WHERE (k.id = ? OR m.kafedra_id = k.id)"
        ." GROUP BY k.`name`,YEAR(m.date_publish) ASC",[$kafedra]);
    }
    public function get_dataUsers($users)
    {
        if($users != 0){
            return $this->select("SELECT u.`name`, COUNT(m.id) AS `count`,YEAR(m.date_publish) AS `year` FROM `user` u"
            ." INNER JOIN `material` m ON m.user_id = u.id"
            ." WHERE u.id =? AND m.`status` = 3"
            ." GROUP BY u.`name`,YEAR(m.date_publish) ASC HAVING COUNT(m.id) > 0",[$users]);
        }
        else{
            return $this->select("SELECT COUNT(m.id) AS `count`,YEAR(m.date_publish) AS `year` FROM `user` u"
            ." LEFT JOIN `material` m ON m.user_id = u.id"
            ." GROUP BY YEAR(m.date_publish) ASC HAVING COUNT(m.id) > 0");
        }
    }
    public function get_material_authors($id)
    {
        $result = $this->select("SELECT a.`id`, a.`name` FROM `material_author` m_a "
            . " LEFT JOIN `author` a ON a.`id` = m_a.`author_id`"
            . " WHERE m_a.`material_id`=?", [$id]);
        return $result;
    }

    public function get_material($id)
    {
        $result = $this->select("SELECT `id`"
            . " ,`name`"
            . " ,`type_id`"
            . " ,`language_id`"
            . " ,DATE_FORMAT(`date_publish`, \"%d/%m/%Y\") AS `date_publish`"
            . " ,`pub_place_id`"
            . " ,`count`"
            . " FROM `material` WHERE id=?", [$id])[0];
        return $result;
    }

    public function get_materials_by_author($id)
    {
        $result = $this->select("SELECT m.`id`"
            . " ,m.`name`"
            . " ,t.`name` AS type_name"
            . " ,m.`language_id`"
            . " ,m.`date_publish` AS `date_publish`"
            . " ,m.`pub_place_id`"
            . " ,m.`count` FROM `material` m"
            . " LEFT JOIN `type` t ON t.`id`=m.`type_id`"
            . " LEFT JOIN `material_author` ma ON ma.`material_id`=m.`id`"
            . " WHERE ma.`author_id`=? ORDER BY m.`date_add` DESC", [$id]);
        return $result;
    }

    public function get_materials_by_specialty($id)
    {
        $result = $this->select("SELECT m.`id`"
            . " ,m.`name`"
            . " ,t.`name` AS type_name"
            . " ,m.`language_id`"
            . " ,m.`date_publish` AS `date_publish`"
            . " ,m.`pub_place_id`"
            . " ,m.`count` FROM `material` m"
            . " LEFT JOIN `type` t ON t.`id`=m.`type_id`"
            . " LEFT JOIN `material_specialty` ms ON ms.`material_id`=m.`id`"
            . " WHERE ms.`specialty_id`=? ORDER BY m.`date_add` DESC", [$id]);
        return $result;
    }

    public function get_materials_by_subject($id)
    {
        $result = $this->select("SELECT m.`id`"
            . " ,m.`name`"
            . " ,t.`name` AS type_name"
            . " ,m.`language_id`"
            . " ,m.`date_publish` AS `date_publish`"
            . " ,m.`pub_place_id`"
            . " ,m.`count` FROM `material` m"
            . " LEFT JOIN `type` t ON t.`id`=m.`type_id`"
            . " LEFT JOIN `material_subject` ms ON ms.`material_id`=m.`id`"
            . " WHERE ms.`subject_id`=? ORDER BY m.`date_add` DESC", [$id]);
        return $result;
    }
}
