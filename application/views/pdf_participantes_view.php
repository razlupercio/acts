<?php

function truncate($string, $length = 50, $append = "&hellip;") {
    $string = trim($string);

    if (strlen($string) > $length) {
        $string = wordwrap($string, $length);
        $string = explode("\n", $string);
        $string = array_shift($string) . $append;
    }

    return $string;
}

function split_nserie($string) {
    $nserie = "";
    $array = explode(',', $string);
    foreach ($array as $key => $value) {
        $nserie.= $value . "<br/>";
    }

    return $nserie;
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title></title>
        <style type="text/css">
            body {
                background-color: #fff;
                //margin: 40px;
                font-family: Lucida Grande, Verdana, Sans-serif;
                font-size: 10px;
                color: #4F5155;
            }

            a {
                color: #003399;
                background-color: transparent;
                font-weight: normal;
            }

            h1 {
                color: #444;
                background-color: transparent;
                border-bottom: 1px solid #D0D0D0;
                font-size: 16px;
                font-weight: bold;
                //margin: 24px 0 2px 0;
                padding: 5px 0 6px 0;
            }

            h2 {
                color: #444;
                background-color: transparent;
                border-bottom: 1px solid #D0D0D0;
                font-size: 16px;
                font-weight: bold;
                //margin: 24px 0 2px 0;
                padding: 5px 0 6px 0;
                text-align: center;
            }

            th{
                text-align: left;
            }
            tfoot{
                font-weight: bold;
            }

            table{
                border-collapse: collapse;
            }

            /* estilos para el footer y el numero de pagina */
            @page { margin: 30px 60px; }
            #header { 
                position: fixed; 
                left: 0px; top: -50px; 
                right: 0px; 
                height: 80px; 
                background-color: #ccc; 
                color: #fff;
                text-align: center;
            }
            #footer { 
                //position: fixed; 
                left: 0px; 
                //bottom: -180px; 
                right: 0px; 
                height: 50px; 
                background-color: #ccc; 
                color: #fff;
            }
            table, td, th {
                border: 1.5px solid black;
                font-size: 8px;

            }
            .underline {
                text-decoration: underline;
            }
            /*
            #footer .page:after { 
                content: counter(page, upper-roman); 
            }
            */
        </style>
    </head>
    <body>
        <?php
//        echo $this->db->last_query();
//        echo var_dump($results);
//        echo "<br>";
//        echo var_dump($items_id);
        ?>
    <center><p class="head">PARTICIPANTES <?php echo $retiro; ?></p></center>
    <table width="100%">
        <tr>
            <td>DIRECTOR: <strong><?php echo $director; ?></strong></td>
        </tr>
        <tr>
            <td>SUBDIRECTOR ADMINISTRATIVO: <strong><?php echo $sub_espiritual; ?></strong></td>
        </tr>
        <tr>
            <td>SUBDIRECTOR ESPIRITUAL: <strong><?php echo $sub_administrativo; ?></strong></td>
        </tr>
    </table>
    <table class="table-vale" width="100%"> 
        <thead>
            <tr>
                <th></th>
                <th>NOMBRE</th>
                <th>DOMICILIO</th>                
                <th>TELEFONO</th>
                <th>CELULAR</th>
                <th>EMAIL</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($participantes as $participante) {
                $ultimo = $this->acts_model->get_retiro($participante["servido"]);
                echo "<tr>"
                . "<td>" . $i . "</td>"
                . "<td>" . $participante["nombre_completo"] . "</td>"
                . "<td>" . $participante["domicilio"] . "</td>"
                . "<td>" . $participante["telefono"] . "</td>"
                . "<td>" . $participante["cel"] . "</td>"
                . "<td>" . $participante["email"] . "</td>"
                . "</tr>";
                $i++;
            }
            ?>
        </tbody>
    </table>
</body>
</html>