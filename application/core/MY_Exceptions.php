<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions {

	/**
	 *
	 * @var CI_Controller
	 */
	private $_ci;
	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		$this->_ci = &get_instance();
		parent::__construct();
	}

	private function response($status_code,$message) {
		$response = [
			'code'    =>  $status_code,
			'data'    =>  [],
			'message' =>  $message
		];
		header("Content-Type:application/json;charset=utf-8");

		set_status_header($status_code);
		echo json_encode($response);
		exit;
	}
	// --------------------------------------------------------------------

	/**
	 * General Error Page
	 *
	 * Takes an error message as input (either as a string or an array)
	 * and displays it using the specified template.
	 *
	 * @param	string		$heading	Page heading
	 * @param	string|string[]	$message	Error message
	 * @param	string		$template	Template name
	 * @param 	int		$status_code	(default: 500)
	 *
	 * @return	string	Error page output
	 */
	public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
	{
		$templates_path = config_item('error_views_path');
		if (empty($templates_path))
		{
			$templates_path = VIEWPATH.'errors'.DIRECTORY_SEPARATOR;
		}
		
		$message = "\t".(is_array($message) ? implode("\n\t", $message) : $message);
		$template = 'cli'.DIRECTORY_SEPARATOR.$template;

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}
		ob_start();
		include($templates_path.$template.'.php');
		$buffer = ob_get_contents();
		ob_end_clean();
		log_message('error',$buffer);
		
		return $this->response($status_code,"服务器内部错误");
	}

	public function show_exception($exception)
	{
		$templates_path = config_item('error_views_path');
		if (empty($templates_path))
		{
			$templates_path = VIEWPATH.'errors'.DIRECTORY_SEPARATOR;
		}

		$message = $exception->getMessage();
		if (empty($message))
		{
			$message = '(null)';
		}

		$templates_path .= 'cli'.DIRECTORY_SEPARATOR;

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}

		ob_start();
		include($templates_path.'error_exception.php');
		$buffer = ob_get_contents();
		ob_end_clean();
		log_message('error', $buffer);
		$this->response(500,"服务器内部错误");
	}

	// --------------------------------------------------------------------

	/**
	 * Native PHP error handler
	 *
	 * @param	int	$severity	Error level
	 * @param	string	$message	Error message
	 * @param	string	$filepath	File path
	 * @param	int	$line		Line number
	 * @return	void
	 */
	public function show_php_error($severity, $message, $filepath, $line)
	{
		$templates_path = config_item('error_views_path');
		if (empty($templates_path))
		{
			$templates_path = VIEWPATH.'errors'.DIRECTORY_SEPARATOR;
		}

		$severity = isset($this->levels[$severity]) ? $this->levels[$severity] : $severity;

		// For safety reasons we don't show the full file path in non-CLI requests
		$template = 'cli'.DIRECTORY_SEPARATOR.'error_php';

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}
		ob_start();
		include($templates_path.$template.'.php');
		$buffer = ob_get_contents();
		ob_end_clean();
		log_message('error', $buffer);
		$this->response(500,"服务器内部错误");
	}

	public function show_404($page = '', $log_error = TRUE) {
		if ($log_error)
		{
			$heading = 'Not Found';
			log_message('error', $heading.': '.$page);
		}

		$this->response(404,"页面不存在");
	}
}
