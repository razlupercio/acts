<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utils {

    function __construct() {

        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->library('grocery_CRUD');
        $this->CI->load->library('form_validation');
        $this->CI->load->library('security');
        $this->CI->load->library('tank_auth');
        $this->CI->lang->load('tank_auth');
        $this->CI->tank_auth->is_logged_in_redirect();
        $this->CI->load->helper('url');
        $this->CI->load->helper('form');
    }

    function load_template($page, $data) {

        if ($this->CI->tank_auth->is_logged_in()) {
            $title["title"] = "ACTS : Directorio";
            $this->load->view('templates/header', $title);
            $this->load->view($page, $data);
            $this->load->view('templates/footer');
        } else {

            redirect('/auth/login');
        }
    }

    function load_teplate($page, $data) {

        if ($this->CI->tank_auth->is_logged_in()) {
            $nivel_id = $this->CI->users->get_user_nivel($this->CI->tank_auth->get_user_id());
            $data2['userid'] = $this->CI->tank_auth->get_user_id();
            $data2['username'] = $this->CI->tank_auth->get_username();
            $data2['nivel_id'] = $nivel_id->nivel_id;
            $data2['param'] = $this->CI->uri->segment(4);
            $this->CI->load->view('templates/header');
            $this->CI->load->view('templates/main_menu', $data2);
            $this->CI->load->view('main_content');
            $this->validate_view($page, $data);
            $this->CI->load->view('templates/footer');
        } else {
            redirect('/auth/login');
        }
    }

    function validate_view($page, $data) {

        if (!file_exists('application/views/' . $page . '.php'))
            show_404();
        else
            return $this->CI->load->view($page, $data);
    }

}

/* End of file Utils.php */

    /* Location: ./application/libraries/Utils.php */