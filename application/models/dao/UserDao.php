<?php
class UserDao extends MY_Dao {

    public function getUser() {
        echo $arr[0];
        return $this->db->query("SELECT * FROM users");
    }
}