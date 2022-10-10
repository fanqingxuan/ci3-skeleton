<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class MY_Dao
{
    public function __construct()
    {        
    }

    function __get($key)
    {
        $CI = & get_instance();
        return $CI->$key;
    }
}