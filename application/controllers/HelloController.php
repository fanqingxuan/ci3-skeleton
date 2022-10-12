<?php

class HelloController extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->service(["UserService"]);
        $this->load->service(["UserService"]);

    }

    public function index() {
        // {"code":0,"data":[1,2,3],"message":"\u83b7\u53d6\u6570\u636e\u6210\u529f"}
        $this->error(404,'Id不存在');
    }

    public function show() {
        Logger::error("错误","这是错误消息");
        $this->success($this->UserService->getList());
    }
}