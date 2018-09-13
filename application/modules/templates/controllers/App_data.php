<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MilarianCMS
 * @version    1.0.1
 * @author     Ricky Kusriana Subagja | rickykusriana@gmail.com
 * @copyright  (c) 2016
 * @link       https://github.com/rickykusriana/MilarianCMS
*/

class App_data extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function validation($data)
	{
		$this->load->library('form_validation');

        if ($data == 'master') {

            $table = $this->uri->segment(2);

            if ($table == 'pic_ibs' || $table == 'address_detail') {
                $field = array('name', 'email');
            }
            elseif ($table == 'inspection_class' || $table == 'region') {
                $field = array('description', 'code');
            }
            else {
                $field = array('description');
            }

            $config = array();
            foreach ($field as $key) {
                $config[$data][] = array(
                                    'field' => $key,
                                    'label' => $key,
                                    'rules' => 'trim|required'.( $key == 'email' ? '|valid_email' : '') );
            }
        }
        else {

    		$config = array(

                'db_quadran.dbo.th_visit' => array(
                    array(
                        'field' => 'visit_date',
                        'label' => 'visit_date',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'inspection_class',
                        'label' => 'inspection_class',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'pic_1',
                        'label' => 'pic_1',
                        'rules' => 'trim|required'
                    )
                ),

                'db_quadran.dbo.td_visit_detail' => array(
                    array(
                        'field' => 'wbs_id',
                        'label' => 'wbs_id',
                        'rules' => 'trim|required'
                    )
                ),

                'db_quadran.dbo.td_visit_fit' => array(
                    array(
                        'field' => 'fabricator_name',
                        'label' => 'fabricator_name',
                        'rules' => 'trim|required'
                    )
                ),

                'db_quadran.dbo.td_visit_fo' => array(
                    array(
                        'field' => 'near_end_site_id',
                        'label' => 'near_end_site_id',
                        'rules' => 'trim|required'
                    )
                ),

                'th_finding' => array(
                    array(
                        'field' => 'visit_id',
                        'label' => 'visit_id',
                        'rules' => 'trim|required'
                    )
                ),

            // Default template

    	        'tm_user' => array(
                    array(
                        'field' => 'user_display',
                        'label' => 'user_display',
                        'rules' => 'trim|required'
                    ),
                    array(
                        'field' => 'user_email',
                        'label' => 'user_email',
                        'rules' => 'trim|required|valid_email'
                    ),
                    array(
                        'field' => 'user_level',
                        'label' => 'user_level',
                        'rules' => 'trim|required'
                    ),
					array(
                        'field' => 'user_group',
                        'label' => 'user_group',
                        'rules' => 'trim|required'
                    )
    	        )

    		);
        }

		$this->form_validation->set_rules($config[$data]);
		if ($this->form_validation->run())
			return TRUE;
	}

	public function field_data($data)
	{
		$user = getSession('user_email');
        $date = date('Y-m-d H:i:s.000');

		switch($data) {

            // Master

            case 'master' :

                if ($this->uri->segment(2) == 'pic_ibs' || $this->uri->segment(2) == 'address_detail') {
                    $field = array(
                                'name'  => $this->input->post('name'),
                                'email' => $this->input->post('email'));

                    if ($this->uri->segment(2) == 'address_detail') {
                        $field['group_id'] = $this->input->post('group_id');
                    }

                }
                elseif ($this->uri->segment(2) == 'inspection_class' || $this->uri->segment(2) == 'region') {
                    $field = array(
                                'description'   => $this->input->post('description'),
                                'code'          => $this->input->post('code'));
                }
                else {
                    $field = array(
                                'description'   => $this->input->post('description'));
                }

                $field['is_status'] = $this->input->post('is_status');

                if ($this->uri->segment(3) == 'update') {
                    $field['updated_at']    = $date;
                    $field['updated_by']    = $user;
                }
                else {
                    $field['created_at']    = $date;
                    $field['created_by']    = $user;
                }

                return $field;
                break;

            // Visit

            case 'db_quadran.dbo.th_visit' :
                return array(
                    'pic_1'             => $this->input->post('pic_1'),
                    'pic_2'             => $this->input->post('pic_2'),
                    'pic_3'             => $this->input->post('pic_3'),
                    'contractor_name'   => $this->input->post('contractor_name'),
                    'inspector_name'    => $this->input->post('inspector_name'),
                    'inspector_team'    => $this->input->post('inspector_team'),
                    'visit_date'        => $this->input->post('visit_date'),
                    'inspection_class'  => $this->input->post('inspection_class'),
                    'inspection_type'   => $this->input->post('inspection_type'),
                    'is_status'         => 'Draft',
                    $this->uri->segment(2) == 'update' ? 'updated_by' : 'created_by' => $user,
                    $this->uri->segment(2) == 'update' ? 'updated_at' : 'created_at' => $date );
                break;

            case 'db_quadran.dbo.td_visit_detail' :
                $field = array(
                            'wbs_id'            => $this->input->post('wbs_id'),
                            'site_name'         => $this->input->post('site_name'),
                            'longitude'         => $this->input->post('longitude'),
                            'latitude'          => $this->input->post('latitude'),
                            'region'            => $this->input->post('region'),
                            'work_type'         => $this->input->post('work_type'),
                            'site_type'         => $this->input->post('site_type'),
                            'tower_type'        => $this->input->post('tower_type'),
                            'tower_height'      => $this->input->post('tower_height'),
                            'building_height'   => $this->input->post('building_height') );

                if ($this->uri->segment(2) == 'create') {
                    $field['visit_id'] = $this->db->insert_id();
                }

                return $field;
                break;

            case 'db_quadran.dbo.td_visit_fit' :
                $field = array(
                            'fabricator_name'   => $this->input->post('fabricator_name'),
                            'address'           => $this->input->post('address'),
                            'work_type'         => $this->input->post('work_type'),
                            'material_type'     => $this->input->post('material_type'),
                            'tower_height'      => $this->input->post('tower_height'),
                            'inspection_method' => ucfirst($this->input->post('inspection_method')),
                            'reference'         => ucfirst($this->input->post('reference')));

                if ($this->uri->segment(2) == 'create') {
                    $field['visit_id'] = $this->db->insert_id();
                }

                return $field;
                break;

            case 'db_quadran.dbo.td_visit_fo' :
                $field = array(
                            'near_end_site_id'    => $this->input->post('near_end_site_id'),
                            'far_end_site_name'    => $this->input->post('far_end_site_name'),
							'near_end_site_name'   => $this->input->post('near_end_site_name'),
                            'far_end_site_id'   => $this->input->post('far_end_site_id'),
                            'work_type'         => $this->input->post('work_type'),
                            'construction_type' => $this->input->post('construction_type'),
                            'fo_length'     	=> $this->input->post('fo_length'),
							'region'            => $this->input->post('region'));

                if ($this->uri->segment(2) == 'create') {
                    $field['visit_id'] = $this->db->insert_id();
                }

                return $field;
                break;

            case 'th_finding' :

                $is_status = $this->input->get('is_status');

                $field = array(
                    'visit_id'          => $this->input->post('visit_id'),
                    'is_status'         => $this->input->post('is_status'),

                    $this->uri->segment(2) == 'update' ? 'updated_by' : 'created_by' => $user,
                    $this->uri->segment(2) == 'update' ? 'updated_at' : 'created_at' => $date );

                if ($this->uri->segment(3) == 'create' || $is_status == 'Draft') {
                    $field['category']          = $this->input->post('category');
                    $field['work_group']        = $this->input->post('work_group');
                    $field['focus_point']       = $this->input->post('focus_point');
                    $field['detail_finding']    = ucfirst($this->input->post('detail_finding'));
                    $field['reference']         = ucfirst($this->input->post('reference'));
                }
                elseif ( ! $this->auth->access_admin()) {
                    $field['action']            = ucfirst($this->input->post('action'));
                    $field['lesson_learn']      = ucfirst($this->input->post('lesson_learn'));
                    $field['completion_date']   = $this->input->post('completion_date');
                }
                else {
                    $field['reason']            = ($this->input->post('is_status') == 'Reject' ? ucfirst($this->input->post('reason')) : '');
                }

                return $field;
                break;

            // Default

            case 'tm_user':
                if ($this->input->post('user_password') != '' || $this->input->post('user_password') != NULL) {
                    $field['user_password'] = password_hash($this->input->post('user_password'), PASSWORD_DEFAULT);
                }

                $field['user_display']  = $this->input->post('user_display');
                $field['user_email']    = $this->input->post('user_email');
                $field['user_level']    = $this->input->post('user_level');
                $field['user_group']    = $this->input->post('user_group');
                $field['modified_by']   = $user;

                if ($this->input->post('user_activation')) {
                    $field['user_activation'] = $this->input->post('user_activation');
                    $field['is_active']       = 'N';
                }
                else {
                    $field['is_active']  = $this->input->post('is_active');
                }

                if ($this->uri->segment(3) == 'update') {
                    $field['updated_at'] = $date;
                }
                else {
                    $field['created_at'] = $date;
                }

                return $field;
                break;

            case 'user_level':
                return array(
                    'user_level'    => $this->input->post('user_level'),
                    'description'   => $this->input->post('description'),
                    'modified_by'   => $user,
                    $this->uri->segment(3) == 'update' ? 'updated_at' : 'created_at' => $date);
                break;
        }
	}

}

/* End of file Templates.php */
/* Location: ./application/modules/templates/controllers/Templates.php */
