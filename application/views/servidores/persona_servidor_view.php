
<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>ACTS</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.css">
        <!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/kickstart.css">-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">

        <script src="<?php echo base_url(); ?>css/js/jquery.js"></script>
    </head>
    <?php
    $attributes = array('class' => 'form-horizontal');
//echo form_open(base_url() . 'index.php/cotizacion/nuevo_concepto', $attributes);
//echo form_open("http://201.155.232.235:82/restserver/index.php/api/articulos/update/id/$id", $attributes);
    echo form_open(base_url() . 'index.php/crud/save_persona_servidor', $attributes);
    ?>
    <div id="container">
        <table width="100%" style="margin: 20px">

            <fieldset>

                <!-- Form Name -->
                <legend>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Añadir Servidor a retiro   <a href="http://localhost/index.php/crud/persona"><em>Volver</em></a></legend>

                <!-- Persona-->
                <div class="control-group">
                    <label class="control-label" for="textinput">Persona</label>
                    <div class="controls">
                        <p id="textinput" name="textinput" placeholder="" class="input-xlarge">
                            <strong><?php echo $persona->nombre_completo; ?></strong>
                        </p>

                    </div>
                </div>

                <!-- Select Retiros -->
                <div class="control-group">
                    <label class="control-label" for="retiro">Retiro</label>
                    <div class="controls">
                        <select id="retiro" name="retiro" class="input-xlarge" required>
                            <option value="">-- SELECCIONE EL RETIRO --</option>
                            <?php
                            foreach ($retiros as $retiro) {
                                echo "<option value=" . $retiro["id"] . ">" . $retiro["identificador_retiro"] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Retiros servidos -->
                <div class="control-group">
                    <label class="control-label" for="textinput">Retiros en los que ha servido:</label>
                    <div class="controls">
                        <p id="textinput" name="textinput" placeholder="" class="input-xlarge">
                            <?php
                            if ($retiros_servidos == null) {
                                echo "No ha servido anteriormente";
                            } else {
                                foreach ($retiros_servidos as $retiro) {
                                    echo "<strong>" . $retiro["identificador_retiro"] . "</strong><br/ >";
                                }
                            }
                            ?>   
                        </p>

                    </div>
                </div>

                <!-- Botón Aceptar -->
                <div class="control-group">
                    <label class="control-label" for="aceptar"></label>
                    <div class="controls">
                        <?php
                        $submit = array(
                            'value' => 'Aceptar',
                            'name' => 'save_persona',
                            'id' => 'save_persona',
                            'class' => 'btn btn-primary'
                        );
                        echo form_submit($submit)
                        ?>
                    </div>
                    <input id="id" name="id" type="hidden" class="hidden" value="<?php echo $persona->id; ?>"/>

            </fieldset>
            <?php echo form_close(); ?>