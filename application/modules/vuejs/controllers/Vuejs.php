<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vuejs extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('index');
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
