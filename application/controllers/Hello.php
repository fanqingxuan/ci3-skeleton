<?php

class Hello extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->service("UserService");
    }

    public function show() {
        Logger::error("错误","这是错误消息");
        print_r($this->UserService->getUser());
    }
}