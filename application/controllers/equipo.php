<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Equipo extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->model("acts_model");
        $this->load->library('grocery_CRUD');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
    }

    public function equipo_param() {
        if ($this->tank_auth->is_logged_in()) {
//            $title["title"] = "ACTS : Directorio";
//            $this->load->view('templates/header', $title);
            $data["retiros"] = $this->acts_model->get_retiros();
            $this->load->view('equipo_form', $data);

//            $this->load->view('templates/footer');
        } else {

            redirect('/auth/login');
        }
    }

    public function show_equipo() {

        if ($this->tank_auth->is_logged_in()) {
            if ($_POST != null) {
                $retiro_id = $this->input->post("retiro");
                $n = $this->acts_model->get_numero_retiro($retiro_id);
                $data["director"] = $this->acts_model->get_director_retiro($retiro_id);
                $data["sub_espiritual"] = $this->acts_model->get_subdirector_espiritual($retiro_id);
                $data["sub_administrativo"] = $this->acts_model->get_subdirector_administrativo($retiro_id);
                $exp1 = $this->input->post("exp_med_1");
                $exp2 = $this->input->post("exp_med_2");
                $exp = $this->input->post("exp_high_2");

                $limitadores = array(
                    "exp" => $exp,
                    "exp1" => $exp1,
                    "exp2" => $exp2,
                );
                
                $this->acts_model->add_limitadores_retiro($retiro_id, $limitadores);

                $this->acts_model->insert_servidores_nuevos($retiro_id);
                $this->acts_model->insert_servidores_media($retiro_id, $exp1, $exp2, $n, 2);
                $this->acts_model->insert_servidores_alta($retiro_id, $exp, $n, 2);
                $this->acts_model->get_retiro($retiro_id);
                //$this->load->view("show_equipo", $data);
            }

            redirect('/crud/servidores_confirmar_id/' . $retiro_id . '/' . $exp1 . '/' . $exp2 . '/' . $exp);
        } else {

            redirect('/auth/login');
        }
    }

    public function add_servidor() {
        $retiro = $this->uri->segment(3);
        $id = $this->uri->segment(4);

        $data = array(
            "persona_id" => $id,
            "retiro_id" => $retiro
        );

        if ($this->acts_model->check_sevidor($id, $retiro) == false) {
            $this->acts_model->add_servidor($data);
            $this->acts_model->updateRetirosServidos($id);
            $this->acts_model->update_persona($id, $retiro);
            $this->load->view("templates/close");
        } else {
            $this->load->view("templates/close");
        }
    }

    public function servidor_exists($id, $retiro) {
        $this->acts_model->check_sevidor($id, $retiro);
    }

    public function confirmar($id) {
        $this->acts_model->confirm_servidores_all($id);
        $this->acts_model->update_estatus_retiro($id);
        $this->load->view("templates/close");
    }

}
