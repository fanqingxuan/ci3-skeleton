<?php

class UserService extends MY_Service {

    public function __construct()
    {
        $this->load->model("UserModel");
    }

    public function getUser() {
        return $this->UserModel->getUser(2);
    }
}