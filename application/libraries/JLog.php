<?php

class JLog {

    private static function log($level,$keywords,$message) {
        $_str = is_array($message)?json_encode($message):$message;
        $_msg = $keywords.' | '.$_str;
        $logObj = & load_class('Log','core');
        return $logObj->write_log($level, $_msg,'app');
    }

    public static function error($keywords,$message) {
        return self::log('error',$keywords,$message);
    }

    public static function warn($keywords,$message) {
        return self::log('warn',$keywords,$message);
    }

    public static function info($keywords,$message) {
        return self::log('info',$keywords,$message);
    }

    public static function debug($keywords,$message) {
        return self::log('debug',$keywords,$message);
    }


}