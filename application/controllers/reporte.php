<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class reporte extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function xls() {
// get data
        $this->load->model("acts_model");
        $retiro_id = $this->uri->segment(3);
//        $exp = $this->acts_model->get_limitadores_retiro($retiro_id);
        $retiro = $this->acts_model->get_desc_retiro($retiro_id);
        $director = $this->acts_model->get_director_retiro($retiro_id);
        $sub_espiritual = $this->acts_model->get_subdirector_espiritual($retiro_id);
        $sub_administrativo = $this->acts_model->get_subdirector_administrativo($retiro_id);
        $nuevos = $this->acts_model->get_servidores_nuevos($retiro_id);
        $medios = $this->acts_model->get_servidores($retiro_id);
        $alta = $this->acts_model->get_servidores_alta($retiro_id);
        $servidores = $this->acts_model->get_servidores_all($retiro_id);
//load our new PHPExcel library
        $this->load->library('excel');
//activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
    $this->excel->getDefaultStyle()
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
for($col = 'A'; $col !== 'G'; $col++) {
        $this->excel->getActiveSheet()->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}
//name the worksheet
        $this->excel->getActiveSheet()->setTitle('test worksheet');
//set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'SUGERENCIA DE SERVIDORES PARA ' . $retiro);
//change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
//make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
//merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:H1');
//set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //      IMPRIMIMOS DATOS DE DIRECTORES

        $this->excel->getActiveSheet()->setCellValue('A3', 'DIRECTOR ');
        $this->excel->getActiveSheet()->setCellValue('A4', 'SUBDIRECTOR ESPIRITUAL');
        $this->excel->getActiveSheet()->setCellValue('A5', 'SUBDIRECTOR ADMINISTRATIVO');
        $this->excel->getActiveSheet()->setCellValue('C3', $director);
        $this->excel->getActiveSheet()->setCellValue('C4', $sub_espiritual);
        $this->excel->getActiveSheet()->setCellValue('C5', $sub_administrativo);
        $this->excel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->mergeCells('A2:O2');
        $this->excel->getActiveSheet()->mergeCells('A3:B3');
        $this->excel->getActiveSheet()->mergeCells('A4:B4');
        $this->excel->getActiveSheet()->mergeCells('A5:B5');
        $this->excel->getActiveSheet()->mergeCells('C3:P3');
        $this->excel->getActiveSheet()->mergeCells('C4:P4');
        $this->excel->getActiveSheet()->mergeCells('C5:P5');
        $this->excel->getActiveSheet()->mergeCells('A6:O6');
        
        if ($alta != null) {



//      COLUMNAS
            $this->excel->getActiveSheet()->setCellValue('A7', "NUEVOS SERVIDORES");
            $this->excel->getActiveSheet()->getStyle('A7')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->mergeCells('A7:P7');
            $this->excel->getActiveSheet()->setCellValue('A8', 'NOMBRE COMPLETO ');
            $this->excel->getActiveSheet()->setCellValue('B8', 'DOMICILIO');
            $this->excel->getActiveSheet()->setCellValue('C8', 'TELEFONO CASA');
            $this->excel->getActiveSheet()->setCellValue('D8', 'TELEFONO OFICINA');
            $this->excel->getActiveSheet()->setCellValue('E8', 'CELULAR');
            $this->excel->getActiveSheet()->setCellValue('F8', 'EMAIL');
            $this->excel->getActiveSheet()->setCellValue('G8', 'RETIRO QUE VIVIÓ');
            $this->excel->getActiveSheet()->setCellValue('H8', '# RETIROS SERVIDOS');
            $this->excel->getActiveSheet()->setCellValue('I8', 'RETIROS SERVIDOS');
            $this->excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('E8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('F8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('G8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('H8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('I8')->getFont()->setBold(true);

            $row = 9;
            foreach ($nuevos as $servidor) {
                $retiros = $this->acts_model->get_retiros_servidos($servidor["id"], $retiro_id);
                $n_servidos = $this->acts_model->numero_retiros_servidos($servidor["id"], $retiro_id);
                $this->excel->getActiveSheet()->setCellValue('A' . $row, $servidor["nombre_completo"]);
                $this->excel->getActiveSheet()->setCellValue('B' . $row, $servidor["domicilio"]);
                $this->excel->getActiveSheet()->setCellValue('C' . $row, $servidor["telefono"]);
                $this->excel->getActiveSheet()->setCellValue('D' . $row, $servidor["telefono_oficina"]);
                $this->excel->getActiveSheet()->setCellValue('E' . $row, $servidor["cel"]);
                $this->excel->getActiveSheet()->setCellValue('F' . $row, $servidor["email"]);
                $this->excel->getActiveSheet()->setCellValue('G' . $row, $servidor["identificador_retiro"]);
                $this->excel->getActiveSheet()->setCellValue('H' . $row, $n_servidos);
                $this->excel->getActiveSheet()->setCellValue('I' . $row, $retiros);
                $row++;
            }
            $this->excel->getActiveSheet()->setCellValue('A' . $row, "SERVIDORES CON EXPERIENCIA MEDIA");
            $this->excel->getActiveSheet()->getStyle('A' . $row)->getFont()->setSize(14);
            $this->excel->getActiveSheet()->getStyle('A' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->mergeCells('A' . $row . ':P' . $row);
            $row++;

            $this->excel->getActiveSheet()->setCellValue('A' . $row, 'NOMBRE COMPLETO ');
            $this->excel->getActiveSheet()->setCellValue('B' . $row, 'DOMICILIO');
            $this->excel->getActiveSheet()->setCellValue('C' . $row, 'TELEFONO CASA');
            $this->excel->getActiveSheet()->setCellValue('D' . $row, 'TELEFONO OFICINA');
            $this->excel->getActiveSheet()->setCellValue('E' . $row, 'CELULAR');
            $this->excel->getActiveSheet()->setCellValue('F' . $row, 'EMAIL');
            $this->excel->getActiveSheet()->setCellValue('G' . $row, 'RETIRO QUE VIVIÓ');
            $this->excel->getActiveSheet()->setCellValue('H' . $row, '# RETIROS SERVIDOS');
            $this->excel->getActiveSheet()->setCellValue('I' . $row, 'RETIROS SERVIDOS');
            $this->excel->getActiveSheet()->getStyle('A' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('E' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('F' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('G' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('H' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('I' . $row)->getFont()->setBold(true);
            $row++;


            foreach ($medios as $servidor) {
                $retiros = $this->acts_model->get_retiros_servidos($servidor["id"], $retiro_id);
                $n_servidos = $this->acts_model->numero_retiros_servidos($servidor["id"], $retiro_id);
                $this->excel->getActiveSheet()->setCellValue('A' . $row, $servidor["nombre_completo"]);
                $this->excel->getActiveSheet()->setCellValue('B' . $row, $servidor["domicilio"]);
                $this->excel->getActiveSheet()->setCellValue('C' . $row, $servidor["telefono"]);
                $this->excel->getActiveSheet()->setCellValue('D' . $row, $servidor["telefono_oficina"]);
                $this->excel->getActiveSheet()->setCellValue('E' . $row, $servidor["cel"]);
                $this->excel->getActiveSheet()->setCellValue('F' . $row, $servidor["email"]);
                $this->excel->getActiveSheet()->setCellValue('G' . $row, $servidor["identificador_retiro"]);
                $this->excel->getActiveSheet()->setCellValue('H' . $row, $n_servidos);
                $this->excel->getActiveSheet()->setCellValue('I' . $row, $retiros);
                $row++;
            }

            $this->excel->getActiveSheet()->setCellValue('A' . $row, "SERVIDORES CON EXPERIENCIA ALTA");
            $this->excel->getActiveSheet()->getStyle('A' . $row)->getFont()->setSize(14);
            $this->excel->getActiveSheet()->getStyle('A' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->mergeCells('A' . $row . ':H' . $row);
            $row++;
            $this->excel->getActiveSheet()->setCellValue('A' . $row, 'NOMBRE COMPLETO ');
            $this->excel->getActiveSheet()->setCellValue('B' . $row, 'DOMICILIO');
            $this->excel->getActiveSheet()->setCellValue('C' . $row, 'TELEFONO CASA');
            $this->excel->getActiveSheet()->setCellValue('D' . $row, 'TELEFONO OFICINA');
            $this->excel->getActiveSheet()->setCellValue('E' . $row, 'CELULAR');
            $this->excel->getActiveSheet()->setCellValue('F' . $row, 'EMAIL');
            $this->excel->getActiveSheet()->setCellValue('G' . $row, 'RETIRO QUE VIVIÓ');
            $this->excel->getActiveSheet()->setCellValue('H' . $row, '# RETIROS SERVIDOS');
            $this->excel->getActiveSheet()->getStyle('A' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('E' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('F' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('G' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('H' . $row)->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('I' . $row)->getFont()->setBold(true);
            $row++;
            foreach ($alta as $servidor) {
                $retiros = $this->acts_model->get_retiros_servidos($servidor["id"], $retiro_id);
                $n_servidos = $this->acts_model->numero_retiros_servidos($servidor["id"], $retiro_id);
                $this->excel->getActiveSheet()->setCellValue('A' . $row, $servidor["nombre_completo"]);
                $this->excel->getActiveSheet()->setCellValue('B' . $row, $servidor["domicilio"]);
                $this->excel->getActiveSheet()->setCellValue('C' . $row, $servidor["telefono"]);
                $this->excel->getActiveSheet()->setCellValue('D' . $row, $servidor["telefono_oficina"]);
                $this->excel->getActiveSheet()->setCellValue('E' . $row, $servidor["cel"]);
                $this->excel->getActiveSheet()->setCellValue('F' . $row, $servidor["email"]);
                $this->excel->getActiveSheet()->setCellValue('G' . $row, $servidor["identificador_retiro"]);
                $this->excel->getActiveSheet()->setCellValue('H' . $row, $n_servidos);
                $this->excel->getActiveSheet()->setCellValue('I' . $row, $retiros);
                $row++;
            }
//make the font become bold
            $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        } else {

            $this->excel->getActiveSheet()->setCellValue('A7', "SERVIDORES (NO HAY DATOS SOBRE LA EXPERIENCIA DEL EQUIPO)");
            $this->excel->getActiveSheet()->getStyle('A7')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->mergeCells('A7:P7');
            $this->excel->getActiveSheet()->setCellValue('A8', 'NOMBRE COMPLETO ');
            $this->excel->getActiveSheet()->setCellValue('B8', 'DOMICILIO');
            $this->excel->getActiveSheet()->setCellValue('C8', 'TELEFONO CASA');
            $this->excel->getActiveSheet()->setCellValue('D8', 'TELEFONO OFICINA');
            $this->excel->getActiveSheet()->setCellValue('E8', 'CELULAR');
            $this->excel->getActiveSheet()->setCellValue('F8', 'EMAIL');
            $this->excel->getActiveSheet()->setCellValue('G8', 'RETIRO QUE VIVIÓ');
            $this->excel->getActiveSheet()->setCellValue('H8', '# RETIROS SERVIDOS');
            $this->excel->getActiveSheet()->setCellValue('I8', 'RETIROS SERVIDOS');
            $this->excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('E8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('F8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('G8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('H8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('I8')->getFont()->setBold(true);
            $row = 9;
            foreach ($servidores as $servidor) {
                $retiros = $this->acts_model->get_retiros_servidos($servidor["id"], $retiro_id);
                $n_servidos = $this->acts_model->numero_retiros_servidos($servidor["id"], $retiro_id);
                $retiros = $this->acts_model->get_retiros_servidos($servidor["id"], $retiro_id);
                $n_servidos = $this->acts_model->numero_retiros_servidos($servidor["id"], $retiro_id);
                $this->excel->getActiveSheet()->setCellValue('A' . $row, $servidor["nombre_completo"]);
                $this->excel->getActiveSheet()->setCellValue('B' . $row, $servidor["domicilio"]);
                $this->excel->getActiveSheet()->setCellValue('C' . $row, $servidor["telefono"]);
                $this->excel->getActiveSheet()->setCellValue('D' . $row, $servidor["telefono_oficina"]);
                $this->excel->getActiveSheet()->setCellValue('E' . $row, $servidor["cel"]);
                $this->excel->getActiveSheet()->setCellValue('F' . $row, $servidor["email"]);
                $this->excel->getActiveSheet()->setCellValue('G' . $row, $servidor["identificador_retiro"]);
                $this->excel->getActiveSheet()->setCellValue('H' . $row, $n_servidos);
                $this->excel->getActiveSheet()->setCellValue('I' . $row, $retiros);
                $row++;
            }
        }



        $filename = "SERVIDORES_$retiro.xls"; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
//force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
    
    public function xls_participantes() {
// get data
        $this->load->model("acts_model");
        $retiro_id = $this->uri->segment(3);
//        $exp = $this->acts_model->get_limitadores_retiro($retiro_id);
        $retiro = $this->acts_model->get_desc_retiro($retiro_id);
        $director = $this->acts_model->get_director_retiro($retiro_id);
        $sub_espiritual = $this->acts_model->get_subdirector_espiritual($retiro_id);
        $sub_administrativo = $this->acts_model->get_subdirector_administrativo($retiro_id);
        $participantes = $this->acts_model->get_participantes_all($retiro_id);
//load our new PHPExcel library
        $this->load->library('excel');
//activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getDefaultStyle()
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        for($col = 'A'; $col !== 'G'; $col++) {
        $this->excel->getActiveSheet()->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
        }    
//name the worksheet
        $this->excel->getActiveSheet()->setTitle('test worksheet');
//set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'PARTICIPANTES ' . $retiro);
//change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
//make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
//merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:H1');
//set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //      IMPRIMIMOS DATOS DE DIRECTORES

        $this->excel->getActiveSheet()->setCellValue('A3', 'DIRECTOR ');
        $this->excel->getActiveSheet()->setCellValue('A4', 'SUBDIRECTOR ESPIRITUAL');
        $this->excel->getActiveSheet()->setCellValue('A5', 'SUBDIRECTOR ADMINISTRATIVO');
        $this->excel->getActiveSheet()->setCellValue('C3', $director);
        $this->excel->getActiveSheet()->setCellValue('C4', $sub_espiritual);
        $this->excel->getActiveSheet()->setCellValue('C5', $sub_administrativo);
        $this->excel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->mergeCells('A2:O2');
        $this->excel->getActiveSheet()->mergeCells('A3:B3');
        $this->excel->getActiveSheet()->mergeCells('A4:B4');
        $this->excel->getActiveSheet()->mergeCells('A5:B5');
        $this->excel->getActiveSheet()->mergeCells('C3:P3');
        $this->excel->getActiveSheet()->mergeCells('C4:P4');
        $this->excel->getActiveSheet()->mergeCells('C5:P5');
        $this->excel->getActiveSheet()->mergeCells('A6:O6');

//      COLUMNAS
            $this->excel->getActiveSheet()->setCellValue('A7', "NUEVOS SERVIDORES");
            $this->excel->getActiveSheet()->getStyle('A7')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->mergeCells('A7:P7');
            $this->excel->getActiveSheet()->setCellValue('A8', 'NOMBRE COMPLETO ');
            $this->excel->getActiveSheet()->setCellValue('B8', 'DOMICILIO');
            $this->excel->getActiveSheet()->setCellValue('C8', 'TELEFONO CASA');
            $this->excel->getActiveSheet()->setCellValue('D8', 'TELEFONO OFICINA');
            $this->excel->getActiveSheet()->setCellValue('E8', 'CELULAR');
            $this->excel->getActiveSheet()->setCellValue('F8', 'EMAIL');
            $this->excel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('E8')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('F8')->getFont()->setBold(true);

            $row = 9;
            foreach ($participantes as $p) {
                $this->excel->getActiveSheet()->setCellValue('A' . $row, $p["nombre_completo"]);
                $this->excel->getActiveSheet()->setCellValue('B' . $row, $p["domicilio"]);
                $this->excel->getActiveSheet()->setCellValue('C' . $row, $p["telefono"]);
                $this->excel->getActiveSheet()->setCellValue('D' . $row, $p["telefono_oficina"]);
                $this->excel->getActiveSheet()->setCellValue('E' . $row, $p["cel"]);
                $this->excel->getActiveSheet()->setCellValue('F' . $row, $p["email"]);
                $row++;
            }
//make the font become bold
            $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);

        $filename = "PARTICIPANTES_$retiro.xls"; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
//force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

}
