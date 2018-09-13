<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MilarianCMS
 * @version    1.0.1
 * @author     Ricky Kusriana Subagja | rickykusriana@gmail.com
 * @copyright  (c) 2016
 * @link       https://github.com/rickykusriana/MilarianCMS
*/

class Templates extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Parameter yang dikirim ke view
	 *
	 * @param	string	$controller Nama controller
	 * @param	array	$replace 	Apabila value parameter ada perubahan
	 * @return 	array
	 */
	public function attribute($controller, $replace = null)
	{
		switch ($controller) {

			case 'dashboard':
				$attr 	= array(
							'title' 		=> 'Dashboard',
							'nav_dashboard'	=> 'active');
				break;

			case 'visit':
				$attr 	= array(
							'title' 		=> 'Data Visit',
							'nav_visit'		=> 'active',
							'list_visit'	=> 'active',
							'widget'		=> $this->auth->access_admin() ? true : false,
							'create_href'	=> true,
							'field'			=> array('Status', 'Visit Date', 'Insp. Class', 'Detail', 'Auditor', 'PIC Name', 'Count Find'));
				break;

			case 'visit/form':
				$attr 	= array(
							'title' 		=> 'Create Visit',
							'nav_visit'		=> 'active',

							$this->uri->segment(2) == 'update' ? 'list_visit' : 'create_visit' => 'active',

							'widget'		=> false,
							'btn_action'	=> false,
							'field'			=> array('Category Name', 'Description'));
				break;

			case 'finding':
				$attr 	= array(
							'title' 		=> 'Manage Finding / NCF',
							'nav_visit'		=> 'active',
							'list_visit'	=> 'active',
							'create_href'	=> true,
							'widget_import'	=> true,
							'field'			=> array('PO Number', 'PO Date'));
				break;

			case 'report':
				$attr 	= array(
							'title' 		=> 'Management Report',
							'nav_report'	=> 'active',
							'widget'		=> false);
				break;

			// Master
			case 'master':

				$breadcumb = str_replace('_', ' ', $this->uri->segment(2));

				$attr 	= array(
							'title' 		=> 'Data '.ucwords($breadcumb),
							'nav_master'	=> 'active',
							'widget'		=> true);
				break;

			case 'users':
				$attr	= array(
						'title' 		=> 'Master User',
						'nav_master'	=> 'active',
						'nav_user'		=> 'active',
						'widget'		=> true,
						'field'			=> array('User', 'Email', 'Level'));
				break;
		}

		if (is_array($replace)) {
			$data = array_replace($attr, $replace);
		}
		else {
			$data = $attr;
		}

		return $data;
	}

	/**
	 * Save into database
	 *
	 * @param	string	$method Metode insert atau update
	 * @param	string	$table 	Nama table database
	 * @param 	array	$where 	Primary key dan value untuk update
	 * @return 	bool
	 */
	public function save($method, $table, $where = null)
	{
		// Load module app_data
		$this->load->module('templates/app_data', 'app_data');

		if ($this->input->post()) {

			// Akses module app_data
			$validation = $this->app_data->validation($table);
			$field_data = $this->app_data->field_data($table);

			// Custom case
			if ($table == 'master') {
				$table = 'tm_'.$this->uri->segment(2);
			}

			if ($validation) {

				if ($method == 'create') {

					if ($this->m_global->save($table, $field_data))
						return TRUE;
				}
				else {

					if ($this->m_global->update($where[0], $where[1], $table, $field_data))
						return TRUE;
				}
			}
			else {
				echo json_encode(array('status' => false, 'error' => validation_errors()));
				die;
			}
		}
	}

	/**
	 * Display on view
	 *
	 * @param	string	$method  Form/interface yang akan ditampilkan
	 * @param	string	$view 	 Lokasi module view
	 * @param 	array	$default Data yang akan ditampilkan
	 * @return 	html
	 */
	public function show($method, $view, $default = null)
	{
		// Penambahan atribut yg akan ditampilkan
		$data 				= $default;
		$data['action']		= site_url(uri_string());

		if ($method == 'create') {
			$data['query']	= false;
			$data['button']	= 'Save';
			$data['alert']	= status('created');
		}
		elseif ($method == 'update') {
			$data['button']	= 'Update';
			$data['alert']	= status('updated');
		}
		elseif ($method == 'detail') {

		}
		else {
			if ( ! in_array($default, array('attr'))) {
				if ($method == 'index') {
					$data['attr'] = $this->attribute($this->router->fetch_class());
				}
				else { // menu/order
					$data['attr'] = $this->attribute($method.'/'.$this->router->fetch_class());
				}
			}
		}

		return $this->load->view($view, $data);
	}

	/**
	 * Generate serverside datatable
	 *
	 * @param	array	$sendData  	Data untuk m_datatable yang dikirim dari controller
	 * @param	string	$field 	 	Nama field tabel yg akan ditampilkan
	 * @param 	array	$button 	Dikirim dari controller untuk function btnAction()
	 * @param 	bool	$checkbox 	Checkbox ditampilakan pada table
	 * @return 	json
	 */
	public function datatable($sendData, $field, $button, $checkbox = true)
	{
		// Load model m_datatable
		$this->load->model('m_datatable');

		// Variable datatables
		$data 	= array();
		$no 	= $this->input->post('start');
		$list 	= $this->m_datatable->get_datatables($sendData);

		foreach ($list as $key) {
			$no++;
			$row   = array();

			if ($checkbox == true) {
				// $row[] = '<input type="checkbox" class="tc" id="checkbox" name="checked[]" value="'.$key->id.'"><span class="labels"></span>';
			}

			$row[] = $no;

			// Pecah $field dari controller
			foreach ($field as $field_data) {

				// Cek apakah ada kondisi yang akan ditampilkan, ditandai dengan array pada data
				if (is_array($field_data)) {

					$label = $field_data[0];
					$value = $field_data[1];

					if ($label == 'is_status') {
						$row[] = $key->$label == 0 ? log_type($key->$value) : $key->$value;
					}
					elseif ($label == 'filter_url') {
						$row[] = filter_var($key->$value, FILTER_VALIDATE_URL) ? '<a href="'.$key->$value.'" target="_blank">'.substr($key->$value, 0, 100).'</a>' : substr($key->$value, 0, 100);
					}
					elseif ($label == 'rupiah') {
						$row[] = '<span class="pull-right">'.rupiah($key->$value).'</span>';
					}
					elseif ($label == 'acronym') {
						$row[] = acronym($key->$value);
					}
					else {

						$row[] = $key->$label .' / '.$key->$value;
					}
				}
				else {
					$row[] = $key->$field_data;
				}

			}

			// Akses function btnAction() untuk menampilkan button
			$row[] = $this->btnAction($button, $key->id);

			$data[] = $row;
		}

		// Variable datatables
		$output = array(
					'draw' 				=> $this->input->post('draw'),
					'recordsTotal' 		=> $this->m_datatable->count_all($sendData),
					'recordsFiltered' 	=> $this->m_datatable->count_filtered($sendData),
					'data' 				=> $data);

		echo json_encode($output);
	}

	/**
	 * Menampilkan button pada datatable
	 *
	 * @param	array	$button  Dikirim dari controller pada function datatable()
	 * @param	string	$id 	 Primary key dari function datatable()
	 * @return 	html
	 */
	private function btnAction($button, $id)
	{
		$btn = '<div class="btn-group btn-group-sm">';

		$separator = (count($button) > 1 ? '&nbsp; | &nbsp;' : '');

		foreach ($button as $key => $value) {

			if ($value['modal'] == TRUE) {

				$modal_lg = (isset($value['modal_lg'])) ? 'data-modal-size="modal-lg"' : '';

				if ($key == 'detail') {

					$btn .= '<button type="button" class="btn waves-effect btn-warning showModal" data-toggle="modal" data-target="#crudModal" '.$modal_lg.'
								data-href="'.site_url(str_replace('$1', $id, $value['data'])).'" data-modal-title="'.icon('show', false, true).'"
								data-rel="tooltip" data-placement="left" title="View"><i class="fa fa-search icon-only"></i>
							</button>';
				}
				elseif ($key == 'update') {

					$btn .= '<a style="cursor:pointer;" class="waves-effect showModal" data-toggle="modal" data-target="#crudModal" '.$modal_lg.'
								data-href="'.site_url(str_replace('$1', $id, $value['data'])).'" data-modal-title="'.icon('edit', false, true).'"
								data-rel="tooltip" data-placement="left" title="Update">
								<i class="fe fe-edit text-info"></i>
							</a>';

					$btn .= $separator;
				}
				elseif ($key == 'delete') {
					$btn .= '<a style="cursor:pointer;" onclick="deleteOne(\''.site_url(str_replace('$1', $id, $value['data'])).'\')" class="waves-effect"
								data-rel="tooltip" data-placement="left" title="Delete">
				                <i class="fe fe-trash text-danger"></i>
				            </a>';
				}
			}
			else {
				if ($key == 'update') {
					$btn .= '<a style="cursor:pointer;" class="waves-effect" href="'.site_url(str_replace('$1', $id, $value['data'])).'"
								data-rel="tooltip" data-placement="left" title="Update">
								<i class="fe fe-edit text-info"></i>
							</a>';

					$btn .= $separator;
				}
				elseif ($key == 'detail') {
					$btn .= '<a style="cursor:pointer;" class="waves-effect" href="'.site_url(str_replace('$1', $id, $value['data'])).'"
								data-rel="tooltip" data-placement="left" title="Data Findings">
								<i class="fa fa-file-text-o text-success"></i>
							</a>';

					$btn .= $separator;
				}
				elseif ($key == 'list') {
					$btn .= '<a style="cursor:pointer;" class="waves-effect" href="'.site_url(str_replace('$1', $id, $value['data'])).'"
								data-rel="tooltip" data-placement="left" title="List Address">
								<i class="fe fe-list text-success"></i>
							</a>';

					$btn .= $separator;
				}
			}

		}

		$btn .= '</div>';

		return $btn;
	}

	/**
	 * Template error view
	 *
	 * @param	string	$method  method error
	 * @return 	html
	 */
	public function error_($method)
	{
		$this->load->view('errors/html/error_'.$method);
	}

}

/* End of file Templates.php */
/* Location: ./application/modules/templates/controllers/Templates.php */
