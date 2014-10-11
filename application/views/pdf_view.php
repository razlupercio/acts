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
        <link rel="stylesheet" href="http://201.155.232.235:82/gray/css/bootstrap.css" type="text/css" media="screen" />
        <meta charset="utf-8">
        <title>Vale Almacén Graycomm</title>
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
    <center><p class="head">PROPUESTA SERVIDORES <?php echo $retiro; ?></p>
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
                <th align='center'>NOMBRE</th>
                <td align='center'>DOMICILIO</th>                
                <td align='center'>TELEFONO</th>
                <td align='center'>CELULAR</th>
                <td align='center'>EMAIL</th>
                <td align='center'>RETIRO VIVIÓ</th>
                <td align='center'>ÚLTIMO RETIRO SIRVIO</th>
                <td align='center'>RETIRO SERVIDOS</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($servidores as $servidor) {
                $ultimo = $this->acts_model->get_retiro($servidor["servido"]);
                echo "<tr>"
                . "<td align='center'>" . $i . "</td>"
                . "<td align='center'>" . $servidor["nombre_completo"] . "</td>"
                . "<td align='center'>" . $servidor["domicilio"] . "</td>"
                . "<td align='center'>" . $servidor["telefono"] . "</td>"
                . "<td align='center'>" . $servidor["cel"] . "</td>"
                . "<td align='center'>" . $servidor["email"] . "</td>"
                . "<td align='center'>" . $servidor["identificador_retiro"] . "</td>"
                . "<td align='center'>" . $ultimo. "</td>"
                . "<td align='center'>" . $servidor["n_servidos"] . "</td>"
                . "</tr>";
                $i++;
            }
            ?>
        </tbody>
    </table>
    </center>
</body>
</html>