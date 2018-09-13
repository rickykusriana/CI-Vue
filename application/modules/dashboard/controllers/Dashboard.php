<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['test']		= 'jajaja';
		$data['content']	= 'dashboard/content';
		$this->templates->show('index', 'templates/index', $data);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
