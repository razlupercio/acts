<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ACTS</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.css">
        <!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/kickstart.css">-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">

<!--        <script src="<?php echo base_url(); ?>css/js/jquery.js"></script>-->
    </head>
    <body>
        <div id="container">
            <table width="100%" style="margin: 20px">
                <tr>
                    <td>
                        <h4 class="align-right"><a href="<?php echo base_url(); ?>">Portada</a></h4> 
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
                        <a href="<?php echo base_url(); ?>index.php/auth/logout"><em class="text-right">Salir</em></a>
                        <img src="<?php echo base_url(); ?>img/logo.jpg" width="55" class="text-right" style="margin: 5px">
                    </td>
                </tr>
            </table>
<center>
    <h1>Listado suguerido </h1><a href="<?php echo base_url() . "index.php/crud/add_servidor/" . $retiro ?>" target="_blank">Ver servidores agregados</a>
    <br />
    <h1>NUEVOS</h1>
    <table class="table table-bordered" width="60%">
        <thead>
            <tr>
                <th>NOMBRE</th>
                <th>TEL</th>
                <th>CEL</th>
                <th>EMAIL</th>
                <th># SERVIDOS</th>
                <th>AÑADIR</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($baja as $b) {
                ?>
                <tr>
                    <td><?php echo $b["nombre_completo"] ?></td>
                    <td><?php echo $b["telefono"] ?></td>
                    <td><?php echo $b["cel"] ?></td>
                    <td><?php echo $b["email"] ?></td>
                    <td><?php echo $b["n_servidos"] ?></td>
                    <td><a href="<?php echo base_url() . "index.php/equipo/add_servidor/" . $retiro . "/" . $b["id"]; ?>"  target="_blank">Añadir</a></td>
                </tr>

            <?php } ?>

        </tbody>
    </table>
    <h1>EXPERIENCIA MEDIA</h1>
    <table class="table table-bordered"  width="60%">
        <thead>
            <tr>
                <th>NOMBRE</th>
                <th>TEL</th>
                <th>CEL</th>
                <th>EMAIL</th>
                <th># SERVIDOS</th>
                <th>ÚLTIMO RETIRO SERVIDO</th>
                <th>AÑADIR</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($media as $m) {
                ?>
                <tr>
                    <td>
                        <?php echo $m["nombre_completo"] ?>
                    </td>
                    <td><?php echo $m["telefono"] ?></td>
                    <td><?php echo $m["cel"] ?></td>
                    <td><?php echo $m["email"] ?></td>
                    <td>
                        <?php echo $m["n_servidos"] ?>
                    </td>
                    <td>
                        <?php echo $m["identificador_retiro"] ?>
                    </td>
                    <td>
                        <a href="<?php echo base_url() . "index.php/equipo/add_servidor/" . $retiro . "/" . $m["id"]; ?>" target="_blank">Añadir</a>
                    </td>

                </tr>

            <?php } ?>

        </tbody>
    </table>
    <h1>EXPERIENCIA ALTA</h1>
    <table class="table table-bordered" width="60%">
        <thead>
            <tr>
                <th>NOMBRE</th>
                <th>TEL</th>
                <th>CEL</th>
                <th>EMAIL</th>
                <th># SERVIDOS</th>
                <th>ÚLTIMO RETIRO SERVIO</th>
                <th>AÑADIR</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($alta as $a) {
                ?>
                <tr>
                    <td>
                        <?php echo $a["nombre_completo"] ?>
                    </td>
                    <td><?php echo $a["telefono"] ?></td>
                    <td><?php echo $a["cel"] ?></td>
                    <td><?php echo $a["email"] ?></td>
                    <td>
                        <?php echo $a["n_servidos"] ?>
                    </td>
                    <td>
                        <?php echo $a["identificador_retiro"] ?>
                    </td>
                    <td>
                        <a href="<?php echo base_url() . "index.php/equipo/add_servidor/" . $retiro . "/" . $a["id"]; ?>" target="_blank">Añadir</a>
                    </td>
                </tr>

            <?php } ?>

        </tbody>
    </table>
<?php 
//echo $this->db->last_query();
/*
SELECT p.*, r.identificador_retiro FROM persona p
INNER JOIN persona_retiro pr ON p.id = persona_retiro.persona
INNER JOIN retiro r ON r.id = pr.retiro
WHERE `servido` >= 1 AND `servido` <= 10
ORDER BY RAND()
LIMIT 10
 */