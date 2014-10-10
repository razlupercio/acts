<?php

class Acts_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_persona($id) {
        $query = $this->db->get_where("persona", array("id" => $id));

        if ($query->num_rows > 0) {
            //$row = $query->row();
            return $query->row();
        } else {
            return null;
        }
    }

    function get_parroquia($id) {
        $query = $this->db->get_where("parroquia", array("id" => $id));

        if ($query->num_rows > 0) {
            $row = $query->row();
            return $row->identificador_parroquia;
        } else {
            return null;
        }
    }

    function get_retiro($id) {
        $query = $this->db->get_where("retiro", array("id" => $id));

        if ($query->num_rows > 0) {
            $row = $query->row();
            return $row->identificador_retiro;
        } else {
            return null;
        }
    }

    function get_desc_retiro($id) {
        $query = $this->db->get_where("retiro", array("id" => $id));

        if ($query->num_rows > 0) {
            $row = $query->row();
            return $row->descripcion_retiro;
        } else {
            return null;
        }
    }

    function get_retiros() {

        $this->db->order_by("identificador_retiro", "desc");
        $query = $this->db->get("retiro");
        if ($query->num_rows > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    function insert_director($data) {
        $this->db->insert('director', $data);
        return true;
    }

    // FUNCIONES DE OBTENCIÓN DE SERVIDORES

    function get_servidores_nuevos($id) {
        $this->db->select("p.*, r.identificador_retiro ")
                ->from("servidor_retiro_final sr")
                ->join("persona p", "p.id = sr.persona_id", "inner")
                ->join("retiro r", "r.id = p.retiro", "inner")
                ->where("sr.retiro_id", $id)
                ->where("sr.exp", 1)
                ->order_by("n_servidos", "asc");
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            return $query->result_array();
            //return $row->identificador_retiro;
        } else {
            return null;
        }
    }

    function get_servidores($id) {
        $this->db->select("p.*, r.identificador_retiro ")
                ->from("servidor_retiro_final sr")
                ->join("persona p", "p.id = sr.persona_id", "inner")
                ->join("retiro r", "r.id = p.retiro", "inner")
                ->where("sr.retiro_id", $id)
//                ->where("p.n_servidos >= $exp_inicial")
//                ->where("p.n_servidos <= $exp_final")
                ->where("sr.exp", 2)
                ->order_by("n_servidos", "asc");
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            return $query->result_array();
            //return $row->identificador_retiro;
        } else {
            return null;
        }
    }

    function get_servidores_alta($id) {
        $this->db->select("p.*, r.identificador_retiro ")
                ->from("servidor_retiro_final sr")
                ->join("persona p", "p.id = sr.persona_id", "inner")
                ->join("retiro r", "r.id = p.retiro", "inner")
                ->where("sr.retiro_id", $id)
                //->where("p.n_servidos >= $exp")
                ->where("sr.exp", 3)
                ->order_by("n_servidos", "asc");
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            return $query->result_array();
            //return $row->identificador_retiro;
        } else {
            return null;
        }
    }

    function insert_servidores_nuevos($id) {
        $genero = $this->get_genero_retiro($id);
        $query = $this->db->query("SELECT  p.id as persona_id, $id AS retiro_id, 1 as exp
                                    FROM persona p
                                    WHERE p.`n_servidos` = 0
                                    AND  p.sexo = '$genero'
                                    ORDER BY RAND()                                    
                                    LIMIT 15");

        if ($query->num_rows()) {
            $new_servidor = $query->result_array();

            foreach ($new_servidor as $row => $persona) {
                if ($this->check_sevidor_retiro($persona)) {
                    $this->db->insert("servidor_retiro_final", $persona);
                }
            }
        }
    }

    function insert_servidores_media($id, $exp_inicial, $exp_final, $numero_retiro, $salto) {
        $numero_retiro = $numero_retiro - 2;
        $genero = $this->get_genero_retiro($id);
        $query = $this->db->query("SELECT p.id as persona_id, $id AS retiro_id, 2 as exp
                                    FROM persona p
                                    INNER JOIN retiro r ON r.id = p.servido
                                    WHERE p.`n_servidos` >= $exp_inicial
                                    AND p.`n_servidos` <= $exp_final
                                    AND r.numero_retiro <=$numero_retiro
                                    AND  p.sexo = '$genero'
                                    ORDER BY RAND()
                                    LIMIT 15");

        if ($query->num_rows()) {
            $new_servidor = $query->result_array();

            foreach ($new_servidor as $row => $persona) {
                if ($this->check_sevidor_retiro($persona)) {
                    $this->db->insert("servidor_retiro_final", $persona);
                }
            }
        }
    }

    function insert_servidores_alta($id, $exp, $numero_retiro, $salto) {
        $numero_retiro = $numero_retiro - 2;
        $genero = $this->get_genero_retiro($id);
        $query = $this->db->query("SELECT p.id as persona_id, $id AS retiro_id, 3 as exp
                                    FROM persona p
                                    INNER JOIN retiro r ON r.id = p.servido
                                    WHERE p.`n_servidos` >= $exp
                                    AND r.numero_retiro <=$salto
                                    AND  p.sexo = '$genero'
                                    ORDER BY RAND()
                                    LIMIT 15");

        if ($query->num_rows()) {
            $new_servidor = $query->result_array();

            foreach ($new_servidor as $row => $persona) {
                if ($this->check_sevidor_retiro($persona)) {
                    $this->db->insert("servidor_retiro_final", $persona);
                }
            }
        }
    }

    function get_genero_retiro($id) {
        $this->db->select("grupo");
        $this->db->from("retiro");
        $this->db->where("id", $id);
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            $row = $query->row();
            return $row->grupo;
        } else {
            return null;
        }
    }

    function get_numero_retiro($id) {
        $this->db->select("numero_retiro");
        $this->db->from("retiro");
        $this->db->where("id", $id);
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            $row = $query->row();
            return $row->numero_retiro;
        } else {
            return null;
        }
    }

    function get_director_retiro($id) {
        $this->db->select(" p.id, p.nombre_completo")
                ->from("retiro r")
                ->join("persona p ", " p.id = r.director", "inner")
                ->where("r.id", $id);
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            $row = $query->row();
            return $row->nombre_completo;
            //$row = $query->row();
        } else {
            return null;
        }
    }

    function get_subdirector_espiritual($id) {
        $this->db->select(" p.id, p.nombre_completo")
                ->from("retiro r")
                ->join("persona p ", " p.id = r.subdirector_espiritual", "inner")
                ->where("r.id", $id);
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            $row = $query->row();
            return $row->nombre_completo;
            //$row = $query->row();
        } else {
            return null;
        }
    }

    function get_subdirector_administrativo($id) {
        $this->db->select(" p.id, p.nombre_completo")
                ->from("retiro r")
                ->join("persona p ", " p.id = r.subdirector_administrativo", "inner")
                ->where("r.id", $id);
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            $row = $query->row();
            return $row->nombre_completo;
            //$row = $query->row();
        } else {
            return null;
        }
    }

    function persona_retiro($id, $retiro) {

        $data = array(
            "retiro" => $retiro
        );

        $this->db->where('id', $id);
        $this->db->update('persona', $data);
        return true;
    }

//SELECT * FROM `persona` WHERE `servido` >= 3 AND `servido` <= 5 ORDER BY RAND() LIMIT 10

    function get_persona_servidos($id) {
        $n = $this->get_numero_retiro($id);
        $this->db->select("r.id, r.identificador_retiro")
                ->from("retiro r")
                ->join("servidor_retiro_final s", "r.id = s.retiro_id", "inner")
                ->where("s.persona_id", $id)
                ->where("numero_retiro <", $n);
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            //$row = $query->row();
            return $query->result_array();
        } else {
            return null;
        }
    }

    function add_servidor($data) {
        $this->db->insert("persona_retiro_servidor", $data);
        $this->db->insert("servidor_retiro_final", $data);
    }

    function check_sevidor($id, $retiro) {
        $this->db->where('persona_id', $id)->where('retiro_id', $retiro);
        $query = $this->db->get('servidor_retiro_final');
        if ($query->num_rows() === 0) {
            return true;
        } else {
            return false;
        }
    }

    function check_sevidor_retiro($servidor) {
        //extract($servidor);

        $this->db->where($servidor);
        $query = $this->db->get('servidor_retiro_final');
        if ($query->num_rows() === 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_persona($id, $retiro) {
        $this->db->update('persona', array('servido' => $retiro), "id = $id");
        return true;
    }

    public function getRetirosServidos($id) {
        $this->db->select('n_servidos')->from('persona')->where("id", $id);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        } else {
            return null;
        }
    }

    public function updateRetirosServidos($id) {

        $this->db->update('persona', array('n_servidos' => $this->getRetirosServidos($id)->n_servidos + 1), array('id' => $id));
        return true;
    }

    public function updatePersonaTaller($id) {

        $this->db->update('persona', array('curso_liderazgo' => 1), array('id' => $id));
        return true;
    }

    public function get_servidores_all($id) {
        $this->db->select("p.*, r.identificador_retiro, sr.id as servidor_retiro ")
                ->from("servidor_retiro_final sr")
                ->join("persona p", "p.id = sr.persona_id", "inner")
                ->join("retiro r", "r.id = p.retiro", "inner")
                ->where("sr.retiro_id", $id)
                ->order_by("n_servidos", "asc");
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function get_participantes_all($id) {
        $this->db->select("p.*, r.identificador_retiro, sr.id as participante_retiro ")
                ->from("participante_retiro_final sr")
                ->join("persona p", "p.id = sr.persona_id", "inner")
                ->join("retiro r", "r.id = p.retiro", "inner")
                ->where("sr.retiro_id", $id);
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function get_retiros_servidos($id, $retiro_id) {
        $n = $this->get_numero_retiro($retiro_id);
        $query = $this->db->query(
                " SELECT GROUP_CONCAT(identificador_retiro SEPARATOR ', ') as retiros"
                . " FROM servidor_retiro_final sr "
                . " INNER JOIN retiro r ON r.id = sr.retiro_id"
                . " WHERE persona_id = $id"
                . " AND r.numero_retiro < $n"
                . " GROUP BY persona_id"
        );

        if ($query->num_rows > 0) {
            $row = $query->row();
            return $row->retiros;
            //$row = $query->row();
        } else {
            return null;
        }
    }

    public function get_servidores_retiro($id) {
        $this->db->select("sr.persona_id, sr.retiro_id")
                ->from("servidor_retiro_final sr")
                ->where("sr.retiro_id", $id);
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    public function updateServidor($id, $retiro) {
        $this->db->update('persona', array('servido' => $retiro), "id = $id");
        $this->db->update('persona', array('n_servidos' => $this->getRetirosServidos($id)->n_servidos + 1), array('id' => $id));
    }

    public function confirm_servidores_all($id) {
        $servidores = $this->get_servidores_retiro($id);

        foreach ($servidores as $row => $servidor) {
            $this->updateServidor($servidor["persona_id"], $servidor["retiro_id"]);
        }
    }

    public function add_limitadores_retiro($id, $data) {
        $this->db->update('retiro', $data, array('id' => $id));
    }

    public function get_limitadores_retiro($id) {
        $this->db->select("exp1, exp2, exp")
                ->from("retiro r")
                ->where("r.id", $id);
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    public function get_estatus_retiro($id) {
        $this->db->select("terminado")
                ->from("retiro r")
                ->where("r.id", $id);
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    public function update_estatus_retiro($id) {
        $this->db->update('retiro', array('terminado' => 1), array('id' => $id));
    }

    public function numero_retiros_servidos($persona_id, $retiro_id) {
        $n = $this->get_numero_retiro($retiro_id);
        $query = $this->db->query("SELECT * "
                . " FROM servidor_retiro_final sr "
                . " INNER JOIN retiro r ON sr.retiro_id = r.id"
                . " WHERE persona_id = $persona_id "
                . " AND r.numero_retiro < $n "
                . " ORDER BY `sr`.`retiro_id` DESC");
        if ($query->num_rows > 0) {
            return $query->num_rows();
        } else {
            return null;
        }
    }

    public function last_retiro_servido($persona_id, $retiro_id) {
        $query = $this->db->query("SELECT * "
                . " FROM servidor_retiro_final sr "
                . " INNER JOIN retiro r ON sr.retiro_id = r.id"
                . " WHERE persona_id = $persona_id "
                . " AND r.numero_retiro < $retiro_id "
                . " ORDER BY `sr`.`retiro_id` DESC");
        if ($query->num_rows > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function delete_servidor($id) {
        $this->db->delete('servidor_retiro_final', array('id' => $id));
        return true;
    }

    function delete_participante($id) {
        $this->db->delete('participante_retiro_final', array('id' => $id));
        return true;
    }

}
