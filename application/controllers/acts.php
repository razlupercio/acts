<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acts extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("acts_model");
        $this->load->library('grocery_CRUD');
    }

    public function index() {
        if ($this->tank_auth->is_logged_in()) {
            $title["title"] = "ACTS : Directorio";
            $this->load->view('templates/header', $title);
            $this->load->view('acts_view');
            $this->load->view('templates/footer');
        } else {

            redirect('/auth/login');
        }
    }

    public function confirmar() {
        $this->load->view("confirmar_asistentes");
    }

    public function seleccionar_retiro() {
        $data["retiros"] = $this->acts_model->get_retiros();
        $this->load->view("seleccionar_retiro", $data);
    }

    public function seleccionar_retiro_asistentes() {
        $data["retiros"] = $this->acts_model->get_retiros();
        $this->load->view("seleccionar_retiro_asistentes", $data);
    }

}
