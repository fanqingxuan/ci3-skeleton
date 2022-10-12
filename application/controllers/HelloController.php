<?php

class HelloController extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->service(["UserService"]);
        $this->load->service(["UserService"]);

    }

    public function index() {
        $this->success("hello/index");
    }

    public function show() {
        Logger::error("错误","这是错误消息");
        $this->success($this->UserService->getList());
    }
}