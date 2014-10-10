<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ACTS</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.css">
        <!--           <link rel="stylesheet" type="text/css" href="http://201.155.232.235:82/jasa/css/kickstart.css">-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css">
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
                        <a href="<?php echo base_url();?>index.php/auth/logout"><em class="text-right">Salir</em></a>
                        <img src="<?php echo base_url();?>img/logo.jpg" width="55" class="text-right" style="margin: 5px">
                    </td>
                </tr>
            </table>
            <center>
            <div id="body">
                <p class="title"></p>
                <div class="menu">
                    <div class="barra">
                        <ul>
                            <br />
                            <select onchange="if (this.value) window.location.href=this.value">
                                <option value="">- SELECCIONE UN RETIRO -</option>
                                <?php
                                foreach ($retiros as $r) {
                                    echo "<option value=".base_url()."index.php/crud/persona_retiro_confirmar_id/".$r["id"].">".$r["identificador_retiro"]."</option>";
                                }
                                ?>
                            </select>
                        </ul>
                    </div>
                </div>

                </body>
                </html>