<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ACTS</title>
<!--        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/kickstart.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">

        <script src="<?php echo base_url(); ?>css/js/jquery.js"></script>-->
        <!-- DataTables CSS -->
        <!--        //code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css
        //cdn.datatables.net/plug-ins/725b2a2115b/integration/jqueryui/dataTables.jqueryui.css
                <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>DataTables-1.10.2/media/css/jquery.dataTables_themeroller.css">
                <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">-->
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/725b2a2115b/integration/jqueryui/dataTables.jqueryui.css">
        <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
        
        <!-- jQuery -->
        <!--<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>DataTables-1.10.2/media/js/jquery.js"></script>-->
        <script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/725b2a2115b/integration/jqueryui/dataTables.jqueryui.js"></script>

<!--        //code.jquery.com/jquery-1.11.1.min.js
//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js
//cdn.datatables.net/plug-ins/725b2a2115b/integration/jqueryui/dataTables.jqueryui.js-->
        <!-- DataTables -->
        <script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>DataTables-1.10.2/media/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#table_id').dataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "<?php echo base_url(); ?>DataTables-1.10.2/examples/server_side/scripts/server_processing.php",
                    "language": {
                        "url": "<?php echo base_url(); ?>DataTables-1.10.2/media/language/Spanish.json"
                    }
                    , "ColumnDefs": [
                        {
                            "Targets": [5],
                            "Data": null,
                            "Render": function(data, type, full) {
                                return '<a href="#" onclick="alert(\'' + full[0] + '\');">Process</a>';
                            }
                        }
                    ]
                });
            });
        </script>


    </head>
    <body>
        <table id="table_id" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Domicilio</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <!--<th>Añadir</th>-->
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Domicilio</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <!--<th>Añadir</th>-->
                </tr>
            </tfoot>
        </table>
    </body>
</html>