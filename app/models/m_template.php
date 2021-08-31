<?php

/*
	Template Class
	Handle all templating tasks - displaying views, alerts, errors and view data
*/

class Template {

  private $data = array();
  private $alert_types = array('success', 'alert', 'error');

  function __construct() {}

  /**
   * Loads specified url
   * @access public
   * @param string $url
   * @param string $title
   * @return void
   */
  public function load($url, $title) {
    if ($title != '') $this->set_data('page_title', $title);
    include($url);
  }

  /**
   * Redirects to specified url
   * @access public
   * @param string $url
   * @return void
   */
  public function redirect($url){
    header("Location: $url");
    exit;
  }

  /*
    Get / Set Data
  */

  /**
   * Saves provided data for use by the view later
   * @access public
   * @param string $name
   * @param $value
   * @param boolean $clean (optional)
   * @return void
   */
	public function set_data($name, $value, $clean = FALSE) {
		if ($clean == TRUE) {
			$this->data[$name] = htmlentities($value, ENT_QUOTES);
		}
		else {
			$this->data[$name] = $value;
		}
	}
	
	/**
   * Retrieves data based on provided name for access by view
   * @access public
   * @param string $name
   * @param boolean $echo (optional)
   * @return string
   */
	public function get_data($name, $echo = TRUE) {
		if (isset($this->data[$name])) {
			if ($echo) {
				echo $this->data[$name];
			}
			else {
				return $this->data[$name];
			}
		}
		return '';
	}
	
	
	/*
		Get / Set Alerts
	*/

  /**
   * Sets a alert message stored in the session
   * @access public
   * @param string $value
   * @param string $type(optional)
   * @return void
   */
	public function set_alert($value, $type = 'success') {
		$_SESSION[$type][] = $value;
	}
	
	/**
   * Returns string, containing multiple list items of alerts
   * @access public
   * @return string
   */
	public function get_alerts() {
		$data = '';
		
		foreach($this->alert_types as $alert_type) {
			if (isset($_SESSION[$alert_type])) {
				foreach($_SESSION[$alert_type] as $value)	{
					$data .= '<li class="' . $alert_type . '">' . $value . '</li>';
				}
				unset($_SESSION[$alert_type]);
			}
		}
		echo $data;
	}
  
}