<?php 

require_once("home.php"); // loading home controller

/**
* @category controller
* class Admin
*/

class Test extends Home
{

	public function __construct()
    {
        parent::__construct();

		$this->load->library('fb_rx_login');
		$this->load->library('google');
	}

	// public function mostofa()
	// {

	// }

	public function publicFoo()
	{
		
	}

}

