<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ACTS</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.css">
        <!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/kickstart.css">-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">

        <script src="<?php echo base_url(); ?>css/js/jquery.js"></script>
    </head>
    <body>
        <div id="container_form" class="center">
            <form class="form-horizontal" action="<?php echo base_url() . "index.php/equipo/show_equipo"; ?>" method="post">
                <fieldset width="20px">

                    <!-- Form Name -->
                    <legend>Generador de Equipos</legend>

                    <div class="control-group">
                        <label class="control-label" for="retiro">Seleccione el retiro al que se cargarán los participantes:</label>
                        <div class="controls">
                            <select id="retiro" name="retiro" class="input-xlarge" required>
                                <option value=""> --- SELECCIONE EL RETIRO --- </option>
                                <?php
                                foreach ($retiros as $retiro) {
                                echo "<option value = '" . $retiro["id"] . "'>" . $retiro["identificador_retiro"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?PHP //var_dump($retiros); ?>
                    <center>
                        <p>NUEVOS</p>
                        <!-- Text input-->
                        <p>Todos los que han vivido la experiencia del retiro pero no han servido antes*</p>
                    </center>

                    <!-- Text input-->
                    <div class="control-group">
                        <center>
                            <label>Experiencia Media</label>
                        </center>
                        <label class="control-label" for="exp_med_1">De</label>
                        <div class="controls">
                            <input id="exp_med_1" name="exp_med_1" type="text" placeholder="" class="input-mini" required>

                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="exp_med_2">Hasta</label>
                        <div class="controls">
                            <input id="exp_med_2" name="exp_med_2" type="text" placeholder="" class="input-mini" required>
                            <p class="help-block">Ingrese el rango de retiros de los servidores con experiencia media</p>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="control-group">
                        <center>
                            <p>Experiencia Alta</p>
                        </center>
                        <label class="control-label" for="exp_high">A partir de...</label>
                        <div class="controls">
                            <input id="exp_high_2" name="exp_high_2" type="text" placeholder="" class="input-mini" required>
                            <p class="help-block">Ingrese el número de retiros de los servidores con mayor experiencia</p>
                        </div>
                    </div>

                    <!-- Text input-->
<!--                    <div class="control-group">
                        <label class="control-label" for="retiros_entre">Numeros de retiros entre repeticion de servidores</label>
                        <div class="controls">
                            <input id="retiros_entre" name="retiros_entre" type="text" placeholder="# de retiros" class="input-medium">
                            <p class="help-block">Por default 1</p>
                        </div>
                    </div>-->

                    <!-- Button -->
                    <div class="control-group">
                        <label class="control-label" for="aceptar"></label>
                        <div class="controls">
                            <button id="aceptar" name="aceptar" value="generar" class="btn btn-primary">Generar</button>
                        </div>
                    </div>

                </fieldset>
            </form>                
        </div>
        <!--                <div class="col_1"></div>-->
