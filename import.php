<?php
require_once("Classes/acts.php");
$conn = dbConnect("write");
$retiros = "SELECT id, identificador_retiro FROM  `retiro` "
        . "ORDER BY  `retiro`.`identificador_retiro` ASC ";
$result = $conn->query($retiros) or die(mysqli_error($conn));

function get_retiro($array, $objPHPExcel, $i) {
    foreach ($array as $key => $value) {
        $retiro_vivido = $objPHPExcel->getActiveSheet()->getCell($value . $i)->getCalculatedValue();
        if ($retiro_vivido == NULL) {
            //return $retiro_vivido;
        } else {
            return $retiro_vivido;
        }
    }
}

function getBool($data) {
    if ( $data == "SI") {
        return 1;
    }
    elseif($data === "NO") {
        return 0;
    }
    else{
        return 0;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ACTS</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <!--           <link rel="stylesheet" type="text/css" href="http://201.155.232.235:82/jasa/css/kickstart.css">-->
        <link rel="stylesheet" type="text/css" href="css/style.css">

        <script src="js/jquery.snippet.min.js"></script>
        <script>
            function validate_file_format(field_name, allowed_ext) {
                obj1 = document.req_form;
                var temp_field = 'obj1.' + field_name + '.value';
                field_value = eval(temp_field);
                if (field_value != "") {
                    var file_ext = (field_value.substring((field_value.lastIndexOf('.') + 1)).toLowerCase());
                    ext = allowed_ext.split(',');
                    var allow = 0;
                    for (var i = 0; i < ext.length; i++) {
                        if (ext[i] == file_ext) {
                            allow = 1;
                        }
                    }
                    if (!allow) {
                        alert('Invalid File format. Please upload file in ' + allowed_ext + ' format');
                        return false;
                    }
                }
                return false;
            }
        </script>
    </head>
    <body>
        <div id="container">
            <table width="100%" style="margin: 20px">
                <tr>
                    <td>
                        <h4 class="align-right"><a href="/">Portada</a></h4> 
                    </td>
                    <td>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td>
                        <a href="index.php/auth/logout"><em class="text-right">Salir</em></a>
                        <img src="img/logo.jpg" width="55" class="text-right" style="margin: 5px">
                    </td>
                </tr>
            </table>
            <div id="body">
                <center>
                    <div id="body">
                        <h1>PARTICIPANTES</h1>

                        <!--<form name="importa" method="post" action="" enctype="multipart/form-data" >-->
                        <form name="importa" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
                            Seleccione el retiro al que se cargarán los participantes: <br />
                            <select name="retiro_personas" required>
                                <option value=""> --- SELECCIONE EL RETIRO --- </option>
                                <?php
                                if ($result->num_rows > 0) { //si la variable tiene al menos 1 fila entonces seguimos con el codigo
                                    while ($row = $result->fetch_array()) {
                                        echo "<option value = '" . $row["id"] . "'>" . $row["identificador_retiro"] . "</option>";
                                    }
                                } else
                                    
                                    ?>
                                <br />
                            </select><br /><br />
                            Seleccione el archivo a importar:
                            <input type="file" name="excel" required onchange="validate_file_format('excel', 'xls')"/>
                            <input type='submit' name='enviar'  value="Importar"  />
                            <input type="hidden" value="upload" name="action" />
                        </form>
                        <p class="footer">Contacto: raziel.lupercio@hotmail.com - 2014</strong></p>
                    </div>

                    </body>
                    </html>
                    <?php
                    $action = "";
                    extract($_POST);
                    if ($action == "upload") { //si action tiene como valor UPLOAD haga algo (el value de este hidden es es UPLOAD iniciado desde el value
//cargamos el archivo al servidor con el mismo nombre(solo le agregue el sufijo bak_)
                        $archivo = $_FILES['excel']['name']; //captura el nombre del archivo
                        $tipo = $_FILES['excel']['type']; //captura el tipo de archivo (2003 o 2007)

                        $destino = "bak_" . $archivo; //lugar donde se copiara el archivo

                        if (copy($_FILES['excel']['tmp_name'], $destino)) { //si dese copiar la variable excel (archivo).nombreTemporal a destino (bak_.archivo) (si se ha dejado copiar)
                            //echo "Archivo Cargado Con Exito".$retiro_personas;
                        } else {
                            echo "Error Al Cargar el Archivo";
                        }

////////////////////////////////////////////////////////
                        if (file_exists("bak_" . $archivo)) { //validacion para saber si el archivo ya existe previamente
                            /* INVOCACION DE CLASES Y CONEXION A BASE DE DATOS */
                            /** Invocacion de Clases necesarias */
                            require_once("Classes/PHPExcel.php");
                            require_once("Classes/PHPExcel/Reader/Excel2007.php");
//DATOS DE CONEXION A LA BASE DE DATOS
                            $cn = mysql_connect("localhost", "root", "jasa") or die("ERROR EN LA CONEXION");
                            //$cn = mysql_connect("localhost", "root", "tecno13#.") or die("ERROR EN LA CONEXION");
                            $db = mysql_select_db("jasa", $cn) or die("ERROR AL CONECTAR A LA BD");

// Cargando la hoja de calculo
                            $objReader = new PHPExcel_Reader_Excel2007(); //instancio un objeto como PHPExcelReader(objeto de captura de datos de excel)
                            $objPHPExcel = $objReader->load("bak_" . $archivo); //carga en objphpExcel por medio de objReader,el nombre del archivo
                            $objFecha = new PHPExcel_Shared_Date();

// Asignar hoja de excel activa
                            $objPHPExcel->setActiveSheetIndex(0); //objPHPExcel tomara la posicion de hoja (en esta caso 0 o 1) con el setActiveSheetIndex(numeroHoja)
// Llenamos un arreglo con los datos del archivo xlsx
                            $i = 2; //celda inicial en la cual empezara a realizar el barrido de la grilla de excel
                            $param = 0;
                            $contador = 0;
                            $retiro_id = $_POST["retiro_personas"];

                            while ($param == 0) { //mientras el parametro siga en 0 (iniciado antes) que quiere decir que no ha encontrado un NULL entonces siga metiendo datos
                                $nombre_completo = strtoupper($objPHPExcel->getActiveSheet()->getCell("B" . $i)->getCalculatedValue());
                                $domicilio = strtoupper($objPHPExcel->getActiveSheet()->getCell("C" . $i)->getCalculatedValue());
                                $fraccionamiento = strtoupper($objPHPExcel->getActiveSheet()->getCell("D" . $i)->getCalculatedValue());
                                $tel_casa = $objPHPExcel->getActiveSheet()->getCell("E" . $i)->getCalculatedValue();
                                $tel_oficina = $objPHPExcel->getActiveSheet()->getCell("F" . $i)->getCalculatedValue();
                                $cel = $objPHPExcel->getActiveSheet()->getCell("G" . $i)->getCalculatedValue();
                                $email = $objPHPExcel->getActiveSheet()->getCell("H" . $i)->getCalculatedValue();
                                $estado = $objPHPExcel->getActiveSheet()->getCell("I" . $i)->getCalculatedValue();
                                $municipio = $objPHPExcel->getActiveSheet()->getCell("J" . $i)->getCalculatedValue();
                                $fecha_nacimiento = $objPHPExcel->getActiveSheet()->getCell("K" . $i)->getCalculatedValue();
                                $sexo = $objPHPExcel->getActiveSheet()->getCell("L" . $i)->getCalculatedValue();
                                $parroquia = $objPHPExcel->getActiveSheet()->getCell("M" . $i)->getCalculatedValue();
                                $requiere_dieta = getBool($objPHPExcel->getActiveSheet()->getCell("N" . $i)->getCalculatedValue());
                                $desc_dieta = $objPHPExcel->getActiveSheet()->getCell("O" . $i)->getCalculatedValue();
                                $requiere_medicamento = getBool($objPHPExcel->getActiveSheet()->getCell("P" . $i)->getCalculatedValue());
                                $desc_medicamento = $objPHPExcel->getActiveSheet()->getCell("Q" . $i)->getCalculatedValue();
                                $tiene_discapacidad = getBool($objPHPExcel->getActiveSheet()->getCell("R" . $i)->getCalculatedValue());
                                $desc_discapacidad = $objPHPExcel->getActiveSheet()->getCell("S" . $i)->getCalculatedValue();
                                $contacto = $objPHPExcel->getActiveSheet()->getCell("T" . $i)->getCalculatedValue();
                                $contacto_tel_casa = $objPHPExcel->getActiveSheet()->getCell("U" . $i)->getCalculatedValue();
                                $contacto_tel_oficina = $objPHPExcel->getActiveSheet()->getCell("V" . $i)->getCalculatedValue();
                                $contacto_cel = $objPHPExcel->getActiveSheet()->getCell("W" . $i)->getCalculatedValue();
                                $parentezco = $objPHPExcel->getActiveSheet()->getCell("X" . $i)->getCalculatedValue();
                                $invitado_por = $objPHPExcel->getActiveSheet()->getCell("Y" . $i)->getCalculatedValue();
                                $invita_cel = $objPHPExcel->getActiveSheet()->getCell("Z" . $i)->getCalculatedValue();
                                $taller_liderazgo = getBool($objPHPExcel->getActiveSheet()->getCell("AA" . $i)->getCalculatedValue());
                                $c = "INSERT INTO `persona`
                                    (`nombre_completo`, `fecha_nacimiento`, `retiro`, `domicilio`, `fraccionamiento`, `municipio`, `estado`, `telefono`, `telefono_oficina`, `cel`, `email`, `parroquia`, `requiere_dieta`, `descipcion_dieta`, `requiere_medicamento`, `descipcion_medicamento`, `tiene_capacidad_diferente`, `descripcion_capacidad_diferente`, `nombre_contacto`, `parentezco`, `tel_contacto`, `tel_oficina_contacto`, `cel_contacto`, `invitado_por`, `cel_de_quien_invita`, `curso_liderazgo`, `sexo`) 
                                    VALUES (
    '$nombre_completo', '$fecha_nacimiento', $retiro_id, '$domicilio', '$fraccionamiento', '$municipio', '$estado', '$tel_casa', '$tel_oficina', '$cel', '$email', '$parroquia', 
        '$requiere_dieta', '$desc_dieta', '$requiere_medicamento', '$desc_medicamento', '$tiene_discapacidad', '$desc_discapacidad', 
            '$contacto', '$parentezco', '$contacto_tel_casa', '$contacto_tel_oficina', '$contacto_cel', '$invitado_por', '$invita_cel', $taller_liderazgo, '$sexo')";
//                                $c = ("insert into persona"
//                                        //  . "(`nombre_completo`, `apellido_paterno`, `apellido_materno`, `nombre`, `fecha_nacimiento`, `retiro`, `domicilio`, `telefono`, `cel`, `email`)"
//                                        . "(`nombre_completo`, `domicilio`,`retiro`, `telefono`, `cel`,`fecha_nacimiento`, `email`, `sexo`)"
//                                        . "  values('$nombre_completo','$domicilio', $retiro_id,"
//                                        . "'$telefono', '$cel', '$fecha_nacimiento', '$email', '$sexo');");

                                if (strlen($nombre_completo) > 1) {
                                    mysql_query($c);
                                    $persona_id = mysql_insert_id();
                                    if ($persona_id > 0) {
                                        $insert_persona_retiro = "INSERT INTO `persona_retiro`(`persona_id`, `retiro_id`) VALUES ($persona_id, $retiro_id)";
                                        mysql_query($insert_persona_retiro);

                                        $insert_persona_retiro_final = "INSERT INTO `participante_retiro_final`(`persona_id`, `retiro_id`) VALUES ($persona_id, $retiro_id)";
                                        mysql_query($insert_persona_retiro_final);
                                    }
                                }

                                if ($objPHPExcel->getActiveSheet()->getCell("A" . $i)->getCalculatedValue() == NULL) { //pregunto que si ha encontrado un valor null en una columna inicie un parametro en 1 que indicaria el fin del ciclo while
                                    $param = 1; //para detener el ciclo cuando haya encontrado un valor NULL
                                }
                                $i++;
                                $contador = $contador + 1;
                            }
                            $totalIngresados = $contador - 1; //(porque se se para con un NULL y le esta registrando como que tambien un dato)
                            echo "Total elementos subidos: $totalIngresados";
                        } else {//si no se ha cargado el bak
                            echo "Necesitas primero importar el archivo";
                        }
                        unlink($destino); //desenlazar a destino el lugar donde salen los datos(archivo)
                    }