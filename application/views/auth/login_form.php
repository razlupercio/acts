<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ACTS</title>

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
    </head>
    <body>

        <div id="container">
            <h1></h1>

            <div id="body">
                <center>
                    <?php
                    $login = array(
                        'name' => 'login',
                        'id' => 'login',
                        'value' => set_value('login'),
                        'maxlength' => 80,
                        'size' => 30,
                    );
                    if ($login_by_username AND $login_by_email) {
                        $login_label = 'Email or login';
                    } else if ($login_by_username) {
                        $login_label = 'Login';
                    } else {
                        $login_label = 'Email';
                    }
                    $password = array(
                        'name' => 'password',
                        'id' => 'password',
                        'size' => 30,
                    );
                    $remember = array(
                        'name' => 'remember',
                        'id' => 'remember',
                        'value' => 1,
                        'checked' => set_value('remember'),
                        'style' => 'margin:0;padding:0',
                    );
                    $captcha = array(
                        'name' => 'captcha',
                        'id' => 'captcha',
                        'maxlength' => 8,
                    );
                    ?>
                    <?php echo form_open($this->uri->uri_string()); ?>
                    <table>
                        <tr>
                            <td><?php echo form_label($login_label, $login['id']); ?></td>
                            <td><?php echo form_input($login); ?></td>
                            <td style="color: red;"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']]) ? $errors[$login['name']] : ''; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo form_label('Password', $password['id']); ?></td>
                            <td><?php echo form_password($password); ?></td>
                            <td style="color: red;"><?php echo form_error($password['name']); ?><?php echo isset($errors[$password['name']]) ? $errors[$password['name']] : ''; ?></td>
                        </tr>

                        <?php
                        if ($show_captcha) {
                            if ($use_recaptcha) {
                                ?>
                                <tr>
                                    <td colspan="2">
                                        <div id="recaptcha_image"></div>
                                    </td>
                                    <td>
                                        <a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
                                        <div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
                                        <div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="recaptcha_only_if_image">Enter the words above</div>
                                        <div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
                                    </td>
                                    <td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
                                    <td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
                                    <?php echo $recaptcha_html; ?>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="3">
                                        <p>Enter the code exactly as it appears:</p>
                                        <?php echo $captcha_html; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
                                    <td><?php echo form_input($captcha); ?></td>
                                    <td style="color: red;"><?php echo form_error($captcha['name']); ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>

                        <tr>
                            <td colspan="3">
                                <?php echo form_checkbox($remember); ?>
                                <?php echo form_label('Recordarme ', $remember['id']); ?>
                                <?php echo anchor('/auth/forgot_password/', 'Olvide mi contraseña'); ?>
                                <?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Register'); ?>
                                <?php echo form_submit('submit', 'Entrar'); ?>
<?php echo form_close(); ?>
                            </td>
                        </tr>
                    </table>
                    <a href="<?php echo base_url(); ?>index.php/acts"><img src="<?php echo base_url(); ?>img/logo.jpg">
                    </a>
                </center>
            </div>

            <p class="footer">2014 - raziel.lupercio@hotmail.com</strong></p>
        </div>

    </body>
</html>