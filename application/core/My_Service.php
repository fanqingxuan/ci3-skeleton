<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class MY_Service
{
    /**
	 * CI_Loader
	 *
	 * @var	MY_Loader
	 */
	public $load;

    private $CI;

    public function __construct()
    {
        $this->CI = & get_instance();
        $this->load = $this->CI->load;
    }
    function __get($key)
    {
        return $this->CI->$key;
    }
}