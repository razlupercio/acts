<?php

class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("acts_model");
        // Here you should add some sort of user validation
        // to prevent strangers from pulling your table data
    }

    public function index() {
        $this->load->library('phpexcel/PHPExcel');

        $sheet = $this->phpexcel->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('A1', 'First Row');

        $writer = new PHPExcel_Writer_Excel5($this->phpexcel);
        header('Content-type: application/vnd.ms-excel');
        $writer->save('php://output');
    }

    public function servidores() {
        $data["test"] = $this->acts_model->insert_servidores_nuevos(13);
//        $this->acts_model->insert_servidores_media(13, 1, 1, 6, 2);
//        $this->acts_model->insert_servidores_alta(13, 3, 6, 2);
        $this->load->view("test", $data);
    }

}
