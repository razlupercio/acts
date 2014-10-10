<?php
require('fpdf.php');
include("connect.php");

$action = $HTTP_GET_VARS["action"];
$id = $HTTP_GET_VARS["id"];

//orden compra

$sqlObtieneOrden = " SELECT pe.id_Pedido, p.nom_Proyecto, u.nom_Usuario, pe.dsc_Pedido,e.id_Estado, e.nom_Estado 
        FROM nrt_Pedido pe 
        INNER JOIN nrt_Proyecto p ON pe.nrt_Proyecto_id_Proyecto = p.id_Proyecto 
        INNER JOIN nrt_Usuario u ON pe.nrt_Usuario_id_Usuario= u.id_Usuario 
        INNER JOIN nrt_Estado e ON pe.nrt_Estado_id_Estado = e.id_Estado 
         WHERE pe.id_Pedido = ".$id."";

$rsObtiene = mysql_query($sqlObtieneOrden);
$rwDatos = mysql_fetch_row($rsObtiene);

$proyecto = $rwDatos[1];
$usuario = $rwDatos[2];
$dsc_Pedido = $rwDatos[3];
$nom_Estado = $rwDatos[5];

class PDF extends FPDF {

    //Cabecera de página

    function Header() {
        $this->Image('logo.jpg', 130, 8, 55); //logo de la empresa
        $this->SetFont('Arial', '', 12); // situamos la tipografía
        $this->Cell(0, 0, 'Nanoresonance Technology S.A. de C.V.', 0, 10, 'L'); //datos de la empresa
        $this->Cell(0, 10, 'RFC: NTE-061220-C10', 0, 5, 'L');
        $this->Cell(0, 0, 'Mahatma Gandi 709', 0, 10, 'L');
        $this->Cell(0, 10, 'Col. San Pedro', 0, 5, 'L');
        $this->Cell(0, 0, 'Aguascalientes, Ags.', 0, 10, 'L');
        $this->Cell(0, 10, 'Tels. (449) 9786787 y (449) 9782187', 0, 5, 'L');
        $this->Ln(10);
    }



    // Page footer

    function Footer() {

        // Go to 1.5 cm from bottom

        $this->SetY(-15);

        // Select Arial italic 8

        $this->SetFont('Arial', 'I', 8);

        // Print centered page number

        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');

    }



}

//Creación del objeto de la clase heredada

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

//Primer Renglón

$pdf->SetFont('Arial', 'B', 16); //Formato de encabezado

//Encabezados

$pdf->Cell(100, 0, 'Pedido', 0, 0, 'C');

$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12); //Formato de encabezado

//Encabezados

$pdf->Cell(60, 7, 'proyecto', 1, 0, 'C');
$pdf->Cell(60, 7, 'usuario', 1, 0, 'C');
$pdf->Cell(60, 7, 'estado', 1, 1, 'C');

$pdf->SetFont('Arial', '', 12); //Formato de resultados

$pdf->Cell(60, 7, $proyecto, 1, 0, 'C');
$pdf->Cell(60, 7, $usuario, 1, 0, 'C');
$pdf->Cell(60, 7, $nom_Estado, 1, 1, 'C');


$pdf->SetFont('Arial', 'B', 12); //Formato de encabezado
$pdf->Cell(180, 7, 'descripcion', 1, 1, 'C');
//$pdf->Cell(40, 7, '# Factura', 1, 0, 'C');
//$pdf->Cell(40, 7, '# Orden', 1, 1, 'C');

//resultados

$pdf->SetFont('Arial', '', 12); //Formato de resultados

$pdf->Cell(180, 7, $dsc_Pedido, 1, 1, 'C');

//$pdf->Cell(40, 7, $factura, 1, 0, 'C');
//$pdf->Cell(40, 7, $id_, 1, 1, 'C');

//Encabezados



$pdf->Ln(10);



//DETALLE ORDEN DE COMPRA

$pdf->SetFont('Arial', 'B', 10); //Formato de encabezado
$pdf->Cell(10, 7, 'ctd', 1, 0, 'C');
$pdf->Cell(140, 7, 'material', 1, 0, 'C');
$pdf->Cell(15, 7, 'precio', 1, 0, 'C');
$pdf->Cell(15, 7, 'importe', 1, 1, 'C');

//detalle orden

$pdf->SetFont('Arial', '', 12); //Formato de resultado
$consulta = mysql_query('SELECT d.id_DetallePedido, d.nrt_Pedido_id_Pedido, p.id_Proveedor, p.nom_Proveedor, m.id_Material, m.nom_Material, ROUND(d.cui_Material) as cui, d.ctd_Material
FROM nrt_detallePedido d
INNER JOIN nrt_Proveedor p ON p.id_Proveedor = d.nrt_Proveedor_id_Proveedor
INNER JOIN nrt_Material m ON m.id_Material = d.nrt_Material_id_Material
WHERE d.nrt_Pedido_id_Pedido ='.$id.'');

while ($row = mysql_fetch_array($consulta)) {

     $proveedor = $row['nom_Proveedor'];
     $material = $row['nom_Material'];
     $precio = $row['cui'];
     $cantidad = $row['ctd_Material'];
     $importe = $cantidad * $precio;

    $pdf->Cell(10, 7, $cantidad, 1, 0, 'C');
    $pdf->Cell(140, 7, $material, 1, 0, 'C');
    $pdf->Cell(15, 7, $precio, 1, 0, 'C');
    $pdf->Cell(15, 7, $importe, 1, 1, 'C');

    $pdf->Ln(0);

}

$qT = 'SELECT ROUND(SUM( cui_Material * ctd_Material), 2 ) AS TOTAL ';

$qT.= ' FROM nrt_detallePedido ';

$qT.= ' WHERE nrt_Pedido_id_Pedido ='.$id;

$rsT = mysql_query($qT);

$rwT = mysql_fetch_assoc($rsT);

$total = $rwT['TOTAL'];

/*

//suma

$pdf->SetFont('Arial', 'B', 12); //Formato de encabezado

$pdf->Cell(160, 7, 'SUMA', 1, 0, 'R');



$pdf->SetFont('Arial', '', 12); //Formato de resultados

$pdf->Cell(20, 7, '10.00 $', 1, 1, 'C');

$pdf->Ln(0);

//iva

$pdf->SetFont('Arial', 'B', 12); //Formato de encabezado

$pdf->Cell(160, 7, 'IVA', 1, 0, 'R');



$pdf->SetFont('Arial', '', 12); //Formato de resultados

$pdf->Cell(20, 7, '2.00 $', 1, 1, 'C');

$pdf->Ln(0);

 * 

 */

//total

$pdf->SetFont('Arial', 'B', 12); //Formato de encabezado

$pdf->Cell(150, 7, 'TOTAL', 1, 0, 'R');



$pdf->SetFont('Arial', '', 12); //Formato de resultados

$pdf->Cell(30, 7,$total , 1, 1, 'C');

$pdf->Ln(10);

//importe con letra

/*
$pdf->SetFont('Arial', 'B', 12); //Formato de encabezado

$pdf->Cell(90, 7, 'total con letra', 1, 0, 'C');



$pdf->SetFont('Arial', '', 12); //Formato de resultados

$pdf->Cell(90, 7, $importeletra, 1, 1, 'C');

$pdf->Ln(10);

//firmas

$pdf->SetFont('Arial', 'B', 12); //Formato de encabezado

$pdf->Cell(80, 7, 'FIRMA RESPONSABLE COMPRAS', 1, 0, 'C');

$pdf->Cell(20, 7, '', 0, 0, 'C');

$pdf->Cell(80, 7, 'FIRMA RESPONSABLE ALMACEN', 1, 1, 'C');



$pdf->SetFont('Arial', '', 12); //Formato de resultados

$pdf->Cell(80, 15, 'T.S.U. Verenice Ruiz', 1, 0, 'C');

$pdf->Cell(20, 15, '', 0, 0, 'C');

$pdf->Cell(80, 15, 'T.S.U. Ahtziri Torres      ', 1, 1, 'C');
*/




//mysql_connect('localhost','nano5843','');

//mysql_select_db('nano5843_plataforma'); 

//$consulta=mysql_query('SELECT * FROM nrt_Proveedor');

//while ($row= mysql_fetch_array($consulta)){

//  $res=$row[1];

//$pdf->Cell(90,5,$res,1,1);

//$pdf->Ln(0);

//}



$pdf->Output();



?>