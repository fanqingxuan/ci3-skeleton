<?php

class UserService extends MY_Service {

    public function __construct()
    {
        parent::__construct();
    }

    public function getUser($uid) {
        return [
            'uid'   =>  $uid,
            'name'  =>  "test-".$uid
        ];
    }

    public function getList() {
        JLog::error("service","hello");
        $this->load->dao("UserDao");
        return $this->UserDao->getUser();
    }
}