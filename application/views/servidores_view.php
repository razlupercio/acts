<?php
$retiro_id = $this->uri->segment(3);
$exp1 = $this->uri->segment(4);
$exp2 = $this->uri->segment(5);
$exp = $this->uri->segment(6);
$retiro = $this->acts_model->get_desc_retiro($retiro_id);
$director = $this->acts_model->get_director_retiro($retiro_id);
$sub_espiritual = $this->acts_model->get_subdirector_espiritual($retiro_id);
$sub_administrativo = $this->acts_model->get_subdirector_administrativo($retiro_id);
$es_terminado = $this->acts_model->get_estatus_retiro($retiro_id);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.css">
        <!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/kickstart.css">-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
        <title>ACTS</title>
        <script src="<?php echo base_url(); ?>js/jquery-1.9.1.js"></script>
        <style type="text/css">

            ::selection{ background-color: #E13300; color: white; }
            ::moz-selection{ background-color: #E13300; color: white; }
            ::webkit-selection{ background-color: #E13300; color: white; }

            body {
                background-color: #C2CBE0;
                margin: 40px;
                font: 13px/20px normal Helvetica, Arial, sans-serif;
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
                font-size: 19px;
                font-weight: normal;
                margin: 0 0 14px 0;
                padding: 14px 15px 10px 15px;
            }

            code {
                font-family: Consolas, Monaco, Courier New, Courier, monospace;
                font-size: 12px;
                background-color: #f9f9f9;
                border: 1px solid #D0D0D0;
                color: #002166;
                display: block;
                margin: 14px 0 14px 0;
                padding: 12px 10px 12px 10px;
            }

            #body{
                margin: 0 15px 0 15px;
            }
            p.body{
                font-weight: bold;
            }

            p.footer{
                text-align: right;
                font-size: 11px;
                border-top: 1px solid #D0D0D0;
                line-height: 32px;
                padding: 0 10px 0 10px;
                margin: 20px 0 0 0;
            }

            #container{
                margin: 10px;
                border: 1px solid;
                background-color: #fff;
                -webkit-box-shadow: 0 0 8px #D0D0D0;
            }

            li.inline {
                display: inline;
                padding-left: 3px;
                padding-right: 7px;
                border-right: 1px dotted #066;
            }li.last {
                display: inline;
                padding-left: 3px;
                padding-right: 3px;
                border-right: 0px;
            } 
        </style>
        <style type='text/css'>
            body
            {
                font-family: Arial;
                font-size: 14px;
            }
            a {
                color: blue;
                text-decoration: none;
                font-size: 14px;
            }
            a:hover
            {
                text-decoration: underline;
            }
        </style>
<!--        <script src="<?php echo base_url() . "index.php/js/jquery.easy-confirm-dialog.js"; ?>"></script>-->
<!--        <script>
            $("#dialog").dialog({
                autoOpen: false,
                modal: true
            });


            $("#alert").click(function(e) {
                e.preventDefault();
                var targetUrl = $(this).attr("href");

                $("#dialog").dialog({
                    buttons: {
                        "Confirm": function() {
                            window.location.href = targetUrl;
                        },
                        "Cancel": function() {
                            $(this).dialog("close");
                        }
                    }
                });

                $("#dialog").dialog("open");
            });
        </script>-->

    </head>
    <body>

        <div id="container">
            <h1>ACTS </h1>
            <div id="body">

                <div style='height:20px;'>
                    <div>
                        <a href='<?php echo site_url('acts') ?>'>Portada</a> |                
                        <br />
                        RETIRO: <strong><?php echo $retiro; ?></strong><br />
                        DIRECTOR: <strong><?php echo $director; ?></strong><br />
                        SUBDIRECTOR ESPIRITUAL: <strong><?php echo $sub_espiritual; ?></strong><br />
                        SUBDIRECTOR ADMINISTRATIVO: <strong><?php echo $sub_administrativo; ?> </strong><br /><br />
                        <strong>FILTRAR:</strong> <input id="searchInput" value="">
                        <!-- Button (Double) -->
                        <div class="control-group">
                            <label class="control-label" for="button1id"></label>
                            <div class="controls">
                                <?php
                                if ($exp == null) {
                                    ?>
                                    <a href="<?php echo base_url() . "index.php/reporte/xls/$retiro_id/"; ?>" target="_blank"><button id="button1id" name="button1id" class="btn btn-success">EXCEL</button></a>
                                    <a href="<?php echo base_url() . "index.php/pdf/create/$retiro_id/"; ?>" target="_blank"><button id="PDF" name="PDF" class="btn btn-danger">PDF</button></a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="<?php echo base_url() . "index.php/reporte/xls/$retiro_id/$exp1/$exp2/$exp"; ?>" target="_blank"><button id="button1id" name="button1id" class="btn btn-success">EXCEL</button></a>
                                    <a href="<?php echo base_url() . "index.php/pdf/create/$retiro_id/$exp1/$exp2/$exp"; ?>" target="_blank"><button id="PDF" name="PDF" class="btn btn-danger">PDF</button></a>
                                    <?php
                                }

                                if ($es_terminado->terminado == 0) {
                                    ?>
                                    <a href="<?php echo base_url() . "index.php/equipo/confirmar/$retiro_id/"; ?>" target="_blank"  onclick="return confirm('¿DESEA CONFIRMAR LA ASISTENCIA DE TODOS LOS SERVIDORES DE ESTE RETIRO?')">
                                        <button id="singlebutton" name="singlebutton" class="btn btn-primary right">Confirmar Servidores</button>
                                    </a>
                                    <?php
                                } else {
                                    
                                }
                                ?>



                            </div>
                        </div>
                    </div>
                </div>  
                <br />
                <br />              
                <br />
                <br />
                <br />
                <br />

                <br />
                <br />              
                <br />
                <br />
                <br />
                <div>
                    <table class="table table-bordered">
                        <thead>
                        <th>PARTICIPANTE</th>
                        <th>RETIRO QUE VIVIO</th>
                        <th>DOMICILIO</th>
                        <th>TEL</th>
                        <th>CEL</th>
                        <th>EMAIL</th>
                        <th>ELIMINAR</th>
                        </thead>
                        <tbody  id="fbody">
                            <?php
                            foreach ($participantes as $participante) {
                                ?>
                                <tr>
                                    <td><?php echo $participante["nombre_completo"]; ?></td>
                                    <td><?php echo $participante["identificador_retiro"]; ?></td>
                                    <td><?php echo $participante["domicilio"]; ?></td>
                                    <td><?php echo $participante["telefono"]; ?></td>
                                    <td><?php echo $participante["cel"]; ?></td>
                                    <td><?php echo $participante["email"]; ?></td>
                                    <td><a href='<?php echo base_url()."index.php/crud/delete_servidor/".$participante["servidor_retiro"];?>' target="_blank">
                                            <img src="<?php echo base_url(); ?>img/delete.png">
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <br>
            </div>
            <p class="footer">contacto - raziel.lupercio@hotmail.com - 2014</strong></p>
            <script>
                $("#searchInput").keyup(function() {
                    //split the current value of searchInput
                    var data = this.value.split(" ");
                    //create a jquery object of the rows
                    var jo = $("#fbody").find("tr");
                    if (this.value == "") {
                        jo.show();
                        return;
                    }
                    //hide all the rows
                    jo.hide();

                    //Recusively filter the jquery object to get results.
                    jo.filter(function(i, v) {
                        var $t = $(this);
                        for (var d = 0; d < data.length; ++d) {
                            if ($t.is(":contains('" + data[d] + "')")) {
                                return true;
                            }
                        }
                        return false;
                    })
                            //show the rows that match.
                            .show();
                }).focus(function() {
                    this.value = "";
                    $(this).css({
                        "color": "black"
                    });
                    $(this).unbind('focus');
                }).css({
                    "color": "#C0C0C0"
                });
            </script>
    </body>
</html>
