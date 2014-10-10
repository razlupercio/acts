<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <?php foreach ($css_files as $file): ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach; ?>
        <?php foreach ($js_files as $file): ?>
            <script src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>
        <title>ACTS</title>
        <?php
        $link = "";
        $retiro = "";
        if ($this->uri->segment(2) == "add_persona_retiro" OR $this->uri->segment(2) == "add_servidor") {
            $retiro = " - " . $this->acts_model->get_retiro($this->uri->segment(3));
        } else {
            $retiro = "";
        }
        ?>
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
    </head>
    <body>

        <div id="container">
            <h1>ACTS <?php echo $retiro; ?></h1>
            <div id="body">

                <div style='height:20px;'>                <div>
                        <a href='<?php echo site_url('acts') ?>'>Portada</a> |

                    </div></div>  
                <div>
                    <?php echo $output; ?>
                </div>
                <br>
            </div>
            <p class="footer">contacto - raziel.lupercio@hotmail.com - 2014</strong></p>
    </body>
</html>
