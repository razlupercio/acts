<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->model("acts_model");
        $this->load->library('grocery_CRUD');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
    }

    /**

      Función para la presentación del CRUD

     */
    public function index() {
        $this->_example_output((object) array('output' => '', 'js_files' => array(), 'css_files' => array()));
    }

    public function _example_output($output = null) {
        $this->load->view('crud_view.php', $output);
    }

    public function _listado_output($output = null) {
        $this->load->view('servidores_view.php', $output);
    }

    public function _listado_participantes_output($output = null) {
        $this->load->view('participantes_view.php', $output);
    }

    /**


      Tablas básicas y catálogos


     */
    public function parroquia() {
        $crud = new grocery_CRUD();

        $crud->set_table('parroquia');
        $crud->display_as("identificador_parroquia", "IDENTIFICADOR")
                ->display_as("nombre_parroquia", "PARROQUIA")
                ->display_as("contacto_parroquia", "CONTACTO")
                ->display_as("direccion", "DIRECCION")
                ->display_as("contacto_parroquia", "CONTACTO")
                ->display_as("email", "E-MAIL")
                ->display_as("telefono", "TELEFONO");


        $output = $crud->render();
        $this->_example_output($output);
    }

    public function persona() {
        $crud = new grocery_CRUD();

        $crud->set_table('persona');
        $crud->columns("nombre_completo", "domicilio", "telefono", "cel", "email")
                ->display_as("curso_liderazgo", "Taller liderazgo");
        $crud->field_type('curso_liderazgo', 'dropdown', array('0' => 'SIN CURSAR', '1' => 'CURSADO'));
        $crud->unset_delete();
        $crud->set_theme("flexigrid");
        $crud->unset_fields("apellido_paterno", "apellido_materno", "nombre", "n_servidos");
        $crud->display_as("servido", "Último retiro que sirvio");
        $crud->set_relation("servido", "retiro", "identificador_retiro");
        $crud->set_relation("retiro", "retiro", "identificador_retiro");
        $crud->field_type("sexo", "dropdown", array("H" => "HOMBRE", "M" => "MUJER"));
        $crud->unset_columns("sexo", "apellido_paterno", "apellido_materno", "nombre", "nombre_contacto", "parentezco", "tel_contacto", "cel_contacto", "email_contacto", "curso_liderazgo"); //, "n_servidos");
        $crud->add_action("", base_url() . "img/people_icon.png", "", " ui-icon-plus", array($this, '_add_persona_servidor'), "_blank");

        $output = $crud->render();
        $this->_example_output($output);
    }

    public function retiro() {
        //$genero = $this->acts_model->get_genero_retiro($id);
        $crud = new grocery_CRUD();

        $crud->set_table('retiro');
        //$crud->unset_delete();
        $crud->field_type("identificador_retiro", "hidden");
        $crud->field_type("grupo", "dropdown", array("H" => "HOMBRES", "M" => "MUJERES", "J" => "JOVENES"));
        $crud->columns("identificador_retiro", "director", "subdirector_administrativo", "subdirector_espiritual", "fecha_inicio", "fecha_termino");
        $crud->set_relation("parroquia", "parroquia", "nombre_parroquia");
        //$crud->unset_fields("exp1", "exp2", "exp", "terminado");
        $crud->set_relation("subdirector_espiritual", "persona", "nombre_completo");
        $crud->set_relation("subdirector_administrativo", "persona", "nombre_completo");
        $crud->set_relation("director", "persona", "nombre_completo", array("curso_liderazgo" => 1));
        $crud->callback_before_insert(array($this, '_identificador'));
        $crud->callback_after_insert(array($this, '_directores'));
        $crud->callback_after_update(array($this, '_update_identificador'));
        $crud->add_action("Agregar Participante", base_url() . "img/plus.gif", "", " ui-icon-plus", array($this, '_add_participante'));
        $crud->add_action("Agregar Servidor", base_url() . "img/people_icon.png", "", " ui-icon-plus", array($this, '_add_servidor'));

        $output = $crud->render();

        $this->_example_output($output);
    }

    public function persona_retiro() {
        $crud = new grocery_CRUD();

        $crud->set_table('participante_retiro_final');
        $crud->set_relation("persona_id", "persona", "nombre_completo");
        $crud->set_relation("retiro_id", "retiro", "identificador_retiro");
        $crud->add_action(" Ver detalles participante", base_url() . "img/profile.gif", "", " ui-icon-plus", array($this, '_view_participante'));
        $crud->columns("persona_id", "retiro_id", "DOMICILIO", "CEL", "EMAIL");
        $crud->display_as("persona_id", "PARTICIPANTE");
        $crud->display_as("retiro_id", "RETIRO");
        $crud->display_as("persona_id", "PARTICIPANTE");
        $crud->unset_operations();
        $crud->callback_column('DOMICILIO', array($this, '_domicilio'));
        $crud->callback_column('TEL', array($this, '_tel'));
        $crud->callback_column('CEL', array($this, '_cel'));
        $crud->callback_column('EMAIL', array($this, '_email'));
        $output = $crud->render();
        $this->_example_output($output);
    }

    public function servidores_confirmar() {
        $this->uri->segment(3);

        $crud = new grocery_CRUD();

        $crud->set_table('servidor_retiro_final');
        $crud->set_relation("persona_id", "persona", "nombre_completo", array("retiro >" => "1"));
        $crud->set_relation("retiro_id", "retiro", "identificador_retiro");
        $crud->columns("persona_id", "retiro_id", "DOMICILIO", "CEL", "EMAIL");
        $crud->display_as("persona_id", "PARTICIPANTE");
        $crud->display_as("retiro_id", "RETIRO");
        $crud->display_as("persona_id", "PARTICIPANTE");
        $crud->unset_edit()->unset_read();
        $crud->callback_column('DOMICILIO', array($this, '_domicilio'))->callback_column('TEL', array($this, '_tel'))->callback_column('CEL', array($this, '_cel'))->callback_column('EMAIL', array($this, '_email'));

        $output = $crud->render();

        $this->_example_output($output);
    }

    public function servidores_confirmar_id() {
        $retiro_id = $this->uri->segment(3);

//
//        $crud->set_table('servidor_retiro_final');
//        $crud->where("retiro_id", $retiro_id);
//        $crud->set_relation("persona_id", "persona", "nombre_completo", array("retiro >" => "1"));
//        //$crud->set_relation("RETIRO QUE VIVIO", "retiro", "identificador_retiro");
//        $crud->columns("persona_id", "RETIRO QUE VIVIO", "DOMICILIO", "CEL", "EMAIL");
//        $crud->display_as("persona_id", "PARTICIPANTE");
//        $crud->display_as("retiro_id", "RETIRO");
//        $crud->display_as("persona_id", "PARTICIPANTE");
//        $crud->unset_edit()->unset_read();
//        $crud->callback_column('RETIRO QUE VIVIO', array($this, '_retiro'))->callback_column('DOMICILIO', array($this, '_domicilio'))->callback_column('TEL', array($this, '_tel'))->callback_column('CEL', array($this, '_cel'))->callback_column('EMAIL', array($this, '_email'));
//        $output = $crud->render();
//

        $data["participantes"] = $this->acts_model->get_servidores_all($retiro_id);
        $this->load->view('servidores_view', $data);
    }

    public function persona_retiro_confirmar() {
        $crud = new grocery_CRUD();

        $crud->set_table('participante_retiro_final');
        $crud->set_relation("persona_id", "persona", "nombre_completo");
        $crud->set_relation("retiro_id", "retiro", "identificador_retiro");
//        $crud->add_action(" Ver detalles participante", base_url() . "img/profile.gif", "", " ui-icon-plus", array($this, '_view_participante'));
        $crud->columns("persona_id", "retiro_id", "DOMICILIO", "CEL", "EMAIL");
        $crud->display_as("persona_id", "PARTICIPANTE");
        $crud->display_as("retiro_id", "RETIRO");
        $crud->display_as("persona_id", "PARTICIPANTE");
        $crud->callback_column('DOMICILIO', array($this, '_domicilio'));
        $crud->callback_column('TEL', array($this, '_tel'));
        $crud->callback_column('CEL', array($this, '_cel'));
        $crud->callback_column('EMAIL', array($this, '_email'));
        $crud->unset_edit()->unset_read();
        //$crud->unset_delete();
        $output = $crud->render();

        $this->_listado_output($output);
    }

    public function persona_retiro_confirmar_id() {
//        $crud = new grocery_CRUD();
        $retiro_id = $this->uri->segment(3);
        $data["participantes"] = $this->acts_model->get_participantes_all($retiro_id);
        $this->load->view('participantes_view', $data);
//        $crud->where("retiro_id", $id);
//
//        $crud->set_table('participante_retiro_final');
//        $crud->set_relation("persona_id", "persona", "nombre_completo");
//        $crud->set_relation("retiro_id", "retiro", "identificador_retiro");
////        $crud->add_action(" Ver detalles participante", base_url() . "img/profile.gif", "", " ui-icon-plus", array($this, '_view_participante'));
//        $crud->columns("persona_id", "retiro_id", "DOMICILIO", "CEL", "EMAIL");
//        $crud->display_as("persona_id", "PARTICIPANTE");
//        $crud->display_as("retiro_id", "RETIRO");
//        $crud->display_as("persona_id", "PARTICIPANTE");
//        $crud->callback_column('DOMICILIO', array($this, '_domicilio'));
//        $crud->callback_column('TEL', array($this, '_tel'));
//        $crud->callback_column('CEL', array($this, '_cel'));
//        $crud->callback_column('EMAIL', array($this, '_email'));
//        $crud->unset_edit()->unset_read();
//        //$crud->unset_delete();
//        $output = $crud->render();
//
//        $this->_listado_participantes_output($output);
    }

    public function servidores() {

        $crud = new grocery_CRUD();

        $crud->set_table('persona_retiro_servidor');
        $crud->set_relation("persona_id", "persona", "nombre_completo", array("retiro >" => "1"));
        $crud->set_relation("retiro_id", "retiro", "identificador_retiro");
        $crud->columns("persona_id", "retiro_id", "DOMICILIO", "CEL", "EMAIL");
        $crud->display_as("persona_id", "PARTICIPANTE");
        $crud->display_as("retiro_id", "RETIRO");
        $crud->display_as("persona_id", "PARTICIPANTE");
        $crud->unset_delete();
        $crud->unset_edit();
        $crud->unset_read();
        $crud->callback_column('DOMICILIO', array($this, '_domicilio'))->callback_column('TEL', array($this, '_tel'))->callback_column('CEL', array($this, '_cel'))->callback_column('EMAIL', array($this, '_email'));
        $output = $crud->render();

        $this->_example_output($output);
    }

    public function directores() {
        $crud = new grocery_CRUD();

        $crud->set_table('director');
        $crud->set_relation("persona", "persona", "nombre_completo", array("curso_liderazgo" => 1));
        $crud->set_relation("retiro", "retiro", "identificador_retiro");

        $output = $crud->render();

        $this->_example_output($output);
    }

    /**
      Cambios que se pidieron después
     */
    public function taller() {
        $crud = new Grocery_CRUD();
        $crud->set_table("taller_liderazgo")
                ->callback_before_insert(array($this, '_identificador_taller'))
                ->callback_before_update(array($this, "_identificador_taller"))
                ->field_type("identificador_taller", "hidden")
                ->add_action("Agregar Asistente", base_url() . "img/people_icon.png", "", " ui-icon-plus", array($this, '_add_tallerista'));

        $output = $crud->render();

        $this->_example_output($output);
    }

    public function ataller() {
        $id = $this->uri->segment(3);
        $crud = new Grocery_CRUD();
        $crud->set_table("taller_asistente")
                ->set_subject("Tallerista")
                ->where("taller_id", $id)
                ->set_relation("persona_id", "persona", "nombre_completo")
//                ->set_relation("taller_id", "taller_liderazgo", "identificador_taller")                
                ->display_as("persona_id", "ASISTENTE")
                ->display_as("taller_id", "TALLER")
                ->field_type("taller_id", "hidden")
//                ->unset_edit_fields("taller_id")
                ->columns("persona_id", "DOMICILIO", "TEL", "CEL", "EMAIL")
                ->callback_column('DOMICILIO', array($this, '_domicilio'))->callback_column('TEL', array($this, '_tel'))->callback_column('CEL', array($this, '_cel'))->callback_column('EMAIL', array($this, '_email'))
                ->callback_before_insert(array($this, '_persona_taller'));

        $output = $crud->render();

        $this->_example_output($output);
    }

    public function _identificador_taller($post_array) {
        $numero = $post_array["numero_taller"];
        $identificador = "TL-" . $numero;
        $post_array['identificador_taller'] = $identificador;
        return $post_array;
    }

    public function _add_tallerista($primary_key, $row) {
        return site_url('crud/ataller') . "/" . $row->id;
    }

    public function _persona_taller($post_array) {
        $post_array["taller_id"] = $this->uri->segment(3);
        $this->acts_model->updatePersonaTaller($post_array["persona_id"]);
        return $post_array;
    }

    /**

      MIS FREGONOMETRICAS CALLBACKS

     */
    public function _directores($post_array, $primary_key) {
        $data = array(
            "persona" => $post_array["director"],
            "retiro" => $primary_key
        );
        //$this->db->insert('director', $data);
        $this->acts_model->insert_director($data);

        return true;
    }

    public function _add_participante($primary_key, $row) {
        return base_url() . "index.php/crud/add_persona_retiro/" . $row->id;
    }

    public function add_persona_retiro() {
        $id = $this->uri->segment(3);
        $genero = $this->acts_model->get_genero_retiro($id);
        $crud = new grocery_CRUD();
        $crud->where("retiro_id", $id);
        $crud->set_table('participante_retiro_final');
        $crud->set_subject("PARTICIPANTE");
        if ($genero == "M") {
            $crud->set_relation("persona_id", "persona", "nombre_completo", array("sexo" => "M"));
        } else {
            $crud->set_relation("persona_id", "persona", "nombre_completo", array("sexo" => "H"));
        }
        $crud->required_fields("persona_id");

        $crud->unset_columns("retiro_id");
        $crud->display_as("persona_id", "PARTICIPANTE");
        $crud->callback_before_insert(array($this, '_persona_retiro'))->callback_before_update(array($this, '_persona_retiro'));
        $crud->unset_edit()->unset_read()->unset_delete()->field_type("retiro_id", "hidden")->columns("persona_id", "retiro_id", "DOMICILIO", "CEL", "DOMICILIO", "EMAIL");
        $crud->display_as("persona_id", "PARTICIPANTE")->display_as("retiro_id", "RETIRO")->display_as("persona_id", "PARTICIPANTE");
        $crud->callback_column('DOMICILIO', array($this, '_domicilio'))->callback_column('TEL', array($this, '_tel'))->callback_column('CEL', array($this, '_cel'))->callback_column('EMAIL', array($this, '_email'));
        $output = $crud->render();

        $this->_example_output($output);
    }

    public function _persona_retiro($post_array) {

        $id = $post_array["persona_id"];
        $retiro = $this->acts_model->get_retiro($id);
        $this->acts_model->persona_retiro($id, $retiro);

        $post_array["retiro_id"] = $this->uri->segment(3);
        return $post_array;
    }

    public function _persona_retiro_update($post_array) {

        $id = $post_array["persona_id"];
        $retiro = $this->acts_model->get_retiro($id);
        $this->acts_model->persona_retiro($id, $retiro);
        return true;
    }

    public function _add_servidor($primary_key, $row) {
        return base_url() . "index.php/crud/add_servidor/" . $row->id;
    }

    public function add_servidor() {
        $id = $this->uri->segment(3);
        $crud = new grocery_CRUD();
        $crud->set_subject("SERVIDOR");
        $crud->where("servidor_retiro_final.retiro_id", $id);
        $crud->set_table('servidor_retiro_final');
        $crud->set_relation("persona_id", "persona", "nombre_completo");
        $crud->unset_columns("retiro");
        $crud->display_as("persona", "SERVIDOR");
//      $crud->add_action(" Ver detalles participante", base_url() . "img/profile.gif", "", " ui-icon-plus", array($this, '_view_participante'));
        $crud->set_relation("retiro_id", "retiro", "identificador_retiro");
        $crud->callback_before_insert(array($this, '_persona_retiro'));
        $crud->field_type("retiro_id", "hidden");
        $crud->callback_before_insert(array($this, '_persona_retiro'));
        $crud->callback_before_update(array($this, '_persona_retiro'));
        $crud->unset_edit()->unset_read()->unset_export()->unset_print();
        $crud->field_type("retiro_id", "hidden");
        $crud->columns("persona_id", "retiro_id", "DOMICILIO", "TEL", "CEL", "EMAIL");
        $crud->display_as("persona_id", "PARTICIPANTE");
        $crud->display_as("retiro_id", "RETIRO");
        $crud->display_as("persona_id", "PARTICIPANTE");
        $crud->callback_column('DOMICILIO', array($this, '_domicilio'))
                ->callback_column('TEL', array($this, '_tel'))
                ->callback_column('CEL', array($this, '_cel'))
                ->callback_column('EMAIL', array($this, '_email'));
        $output = $crud->render();

        $this->_listado_output($output);
    }

    public function _servidor_retiro($post_array) {
        $post_array["retiro_id"] = $this->uri->segment(3);
        return $post_array;
    }

    public function _identificador($post_array) {
        $parroquia = $this->acts_model->get_parroquia($post_array["parroquia"]);
        $numero = $post_array["numero_retiro"];
        $post_array["identificador_retiro"] = $parroquia . "-" . $numero . "-" . $post_array["grupo"];
        return $post_array;
    }

    public function _update_identificador($post_array, $primary_key) {
        $parroquia = $this->acts_model->get_parroquia($post_array["parroquia"]);
        $numero = $post_array["numero_retiro"];
        $identificador = $parroquia . $numero . $post_array["grupo"];
        $identificador_update = array(
            "identificador_retiro" => $identificador
        );

        $this->db->update('retiro', $identificador_update, array('id' => $primary_key));

        return true;
    }

    public function _view_participante($primary_key, $row) {
        return base_url() . "index.php/crud/persona/read/" . $row->id;
    }

    public function _add_persona_servidor($primary_key, $row) {
        return base_url() . "index.php/crud/add_persona_servidor/" . $row->id;
    }

    /**

      CALLBACK PARA LA CREACIÓN DE EQUIPOS

     */
    public function add_persona_servidor() {
        $id = $this->uri->segment(3);
        $data["retiros"] = $this->acts_model->get_retiros();
        $data["retiros_servidos"] = $this->acts_model->get_persona_servidos($id);
        $data["persona"] = $this->acts_model->get_persona($id);
        $this->load->view("servidores/persona_servidor_view", $data);
    }

    public function save_persona_servidor() {
        if ($this->input->post('save_persona')) {
            $servidor = array(
                "persona_id" => $this->input->post("id"),
                "retiro_id" => $this->input->post("retiro"),
            );

            $this->acts_model->add_servidor($servidor);
            $this->acts_model->update_persona($this->input->post("id"), $this->input->post("retiro"));
            $this->acts_model->updateRetirosServidos($this->input->post("id"));
            redirect("crud/add_persona_servidor/" . $this->input->post("id"));
        }
    }

    /**

      CALLBACKS PARA LA PRESENTACIÓN DE DATOS EN CRUDS DE RETIROS, SERVIDORES, ETC...

     */
    public function _retiro($value, $row) {
        $persona = $this->acts_model->get_persona($row->persona_id);
        $retiro = $this->acts_model->get_retiro($persona->retiro);
        return $retiro;
    }

    public function _total_servidos($value, $row) {
        $persona = $this->acts_model->get_persona($row->persona_id);
        return $persona->n_servidos;
    }

    public function _domicilio($value, $row) {
        $persona = $this->acts_model->get_persona($row->persona_id);
        return $persona->domicilio;
    }

    public function _cel($value, $row) {
        $persona = $this->acts_model->get_persona($row->persona_id);
        return $persona->cel;
    }

    public function _tel($value, $row) {
        $persona = $this->acts_model->get_persona($row->persona_id);
        return $persona->telefono;
    }

    public function _email($value, $row) {
        $persona = $this->acts_model->get_persona($row->persona_id);
        return $persona->email;
    }

    public function delete_servidor($id) {
        $this->acts_model->delete_servidor($id);
        $this->load->view("templates/close");
    }

    public function delete_participante($id) {
        $this->acts_model->delete_participante($id);
        $this->load->view("templates/close");
    }

}
