<?php

class MY_Controller extends CI_Controller {

    /**
	 * CI_Loader
	 *
	 * @var	MY_Loader
	 */
	public $load;

    public function __construct()
    {
        parent::__construct();
    }

    public function response($code,$data,$message) {
        $response = [
            'code'    =>  $code,
            'data'    =>  $data,
            'message' =>  $message
        ];
        $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response));
    }

    public function success($data,$message = '成功') {
        $this->response(0,$data,$message);
    }

    public function error($code,$message='失败') {
        $this->response((int)$code,[],$message);
    }
}