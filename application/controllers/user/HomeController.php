<?php

class HomeController extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
       

    }

    public function index() {
        $this->success("user/home");
    }

    public function show() {
        $this->success("user/home/show");
    }
}