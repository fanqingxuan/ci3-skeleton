<?php

class MY_Loader extends CI_Loader
{
    /**
	 * List of loaded sercices
	 *
	 * @var array
	 * @access protected
	 */
	protected $_ci_services = array();
	/**
	 * List of paths to load sercices from
	 *
	 * @var array
	 * @access protected
	 */
	protected $_ci_service_paths		= array(APPPATH.'models/service/');

    protected $_ci_dao = array();
	/**
	 * List of paths to load sercices from
	 *
	 * @var array
	 * @access protected
	 */
	protected $_ci_dao_paths		= array(APPPATH.'models/dao/');
    
    /**
     * Constructor
     * 
     * Set the path to the Service files
     */
    public function __construct()
    {
        
        parent::__construct();
    }

    public function dao($dao = '', $name = NULL)
    {
        if(is_array($dao))
        {
            foreach($dao as $class)
            {
                $this->dao($class);
            }
            
            return;
        }
        
        if (empty($name))
        {
            $name = $dao;
        }

        if (in_array($name, $this->_ci_dao, TRUE))
		{
			return $this;
		}
        
        $subdir = '';

        if (($last_slash = strrpos($dao, '/')) !== FALSE)
        {
                // The path is in front of the last slash
                $subdir = substr($dao, 0, $last_slash + 1);

                $dao = substr($dao, $last_slash + 1);
        }

        $class = config_item('subclass_prefix').'Dao';
        $app_path = APPPATH.'core'.DIRECTORY_SEPARATOR;
        if (file_exists($app_path.$class.'.php'))
        {
            require_once($app_path.$class.'.php');
            if ( ! class_exists($class, FALSE))
            {
                throw new RuntimeException($app_path.$class.".php exists, but doesn't declare class ".$class);
            }

            log_message('info', config_item('subclass_prefix').'Dao class loaded');
        }
        $this->database();
        if(! class_exists($dao,FALSE)) {
            foreach($this->_ci_dao_paths as $path)
            {
                
                $filepath = $path.$subdir.$dao.'.php';
                
                if ( ! file_exists($filepath))
                {
                    continue;
                }
                
                require_once($filepath);

                if ( ! class_exists($dao, FALSE))
                {
                    throw new RuntimeException($filepath." exists, but doesn't declare class ".$dao);
                }
                break;
            }
            if ( ! class_exists($dao, FALSE))
            {
                throw new RuntimeException('Unable to locate the dao you have specified: '.$dao);
            }
        }
        elseif ( ! is_subclass_of($dao, 'MY_Dao'))
		{
			throw new RuntimeException("Class ".$dao." already exists and doesn't extend MY_Dao");
		}
        
        
        $CI = &get_instance();
        $CI->$name = new $dao();
        $this->_ci_dao[] = $name;
        
        log_message('info', 'Dao "'.$dao.'" initialized');
        return $this;
    }
    
    public function service($service = '', $object_name = NULL)
    {
        if(is_array($service))
        {
            foreach($service as $class)
            {
                $this->service($class);
            }
            
            return;
        }
        
        if (empty($object_name))
        {
            $object_name = $service;
        }

        if (in_array($object_name, $this->_ci_services, TRUE))
		{
			return $this;
		}
        
        $subdir = '';

        // Is the service in a sub-folder? If so, parse out the filename and path.
        if (($last_slash = strrpos($service, '/')) !== FALSE)
        {
                // The path is in front of the last slash
                $subdir = substr($service, 0, $last_slash + 1);

                // And the service name behind it
                $service = substr($service, $last_slash + 1);
        }

        $class = config_item('subclass_prefix').'Service';
        $app_path = APPPATH.'core'.DIRECTORY_SEPARATOR;
        if (file_exists($app_path.$class.'.php'))
        {
            require_once($app_path.$class.'.php');
            if ( ! class_exists($class, FALSE))
            {
                throw new RuntimeException($app_path.$class.".php exists, but doesn't declare class ".$class);
            }

            log_message('info', config_item('subclass_prefix').'Service class loaded');
        }
        
        if(! class_exists($service,FALSE)) {
            foreach($this->_ci_service_paths as $path)
            {
                
                $filepath = $path.$subdir.$service.'.php';
                
                if ( ! file_exists($filepath))
                {
                    continue;
                }
                
                require_once($filepath);

                if ( ! class_exists($service, FALSE))
                {
                    throw new RuntimeException($filepath." exists, but doesn't declare class ".$service);
                }
                break;
            }
            if ( ! class_exists($service, FALSE))
            {
                throw new RuntimeException('Unable to locate the service you have specified: '.$service);
            }
        }
        elseif ( ! is_subclass_of($service, 'MY_Service'))
		{
			throw new RuntimeException("Class ".$service." already exists and doesn't extend MY_Service");
		}
        
        
        $CI = &get_instance();
        $CI->$object_name = new $service();
        $this->_ci_services[] = $object_name;
        
        log_message('info', 'Service "'.$service.'" initialized');
        return $this;
    }
}