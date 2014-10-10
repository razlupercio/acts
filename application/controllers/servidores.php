<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Servidores extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->model("acts_model");
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->load->library('Datatables');
    }

    public function index() {


//            $this->datatables
//                    ->select('*')
//                    ->from('persona');
//            $data['result'] = $this->datatables->generate();
        $this->load->view('servidores/personas_view');
    }

    //$this->load->view("servidores/personas_view");

    function datatable() {
        $this->datatables->select('id,nombre_completo,domicilio,email')
                ->unset_column('id')
                ->from('persona');

        echo $this->datatables->generate();
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

