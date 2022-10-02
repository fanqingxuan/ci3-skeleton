<?php

class Hello extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->service("UserService");
    }

    public function show() {
        print_r($this->UserService->getUser());
    }
}