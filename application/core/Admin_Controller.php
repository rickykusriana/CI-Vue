<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MilarianCMS
 * @version    1.0.1
 * @author     Ricky Kusriana Subagja | rickykusriana@gmail.com
 * @copyright  (c) 2016
 * @link       https://github.com/rickykusriana/MilarianCMS
*/

class Admin_Controller extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        // $this->load->library('auth');
        // $this->auth->restrict();

        if (ENVIRONMENT !== 'development') {
            $this->isXMLHttpRequest();
        }
    }

    /**
     * isXMLHttpRequest()
     * For denied access http url request
     */
    function isXMLHttpRequest()
    {
        $CI =& get_instance();
        $notClass = array('visit/update', 'visit/create');
        $method = array('read', 'create', 'update', 'delete', 'detail');
        if ( ! in_array($CI->router->fetch_class().'/'.$CI->router->fetch_method(), $notClass) && in_array($CI->router->fetch_method(), $method)) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
                return TRUE;
            }
            else {
                redirect('405');
            }
        }
    }

}
