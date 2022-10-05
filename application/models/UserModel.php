<?php

class UserModel extends CI_Model {


    public function getUser($uid) {
        Logger::warn("warn",'这是warning');
        Logger::error("这是error",'error message');
        return [
            'id'    =>  $uid,
            'username'=>'张三'
        ];
    }
}