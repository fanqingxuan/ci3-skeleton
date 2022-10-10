<?php
class UserDao extends MY_Dao {

    public function getUser() {
        return $this->db->query("SELECT * FROM users");
    }
}