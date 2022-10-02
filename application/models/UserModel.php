<?php

class UserModel extends CI_Model {


    public function getUser($uid) {
        return [
            'id'    =>  $uid,
            'username'=>'张三'
        ];
    }
}