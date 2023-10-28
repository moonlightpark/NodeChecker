<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?=__ENV_ADMIN_TITLE__?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?=__ENV_INCLUDE_URL__?>static/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="<?=__ENV_INCLUDE_URL__?>static/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="<?=__ENV_INCLUDE_URL__?>static/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="<?=__ENV_INCLUDE_URL__?>static/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=__ENV_INCLUDE_URL__?>static/css/sb-admin-2.css?var=<?=__ENV_STATIC_VER__?>" rel="stylesheet">
    <link href="/public/static/css/dev_add_css.css?var=<?=__ENV_STATIC_VER__?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="/public/static/vendor/font-awesome/css/fontawesome-all.css">
	<script defer src="<?=__ENV_INCLUDE_URL__?>static/vendor/svg-with-js/js/fontawesome-all.js"></script>
	
	<!-- Include Bootstrap Datepicker -->
	<link rel="stylesheet" href="<?=__ENV_INCLUDE_URL__?>static/css/datepicker.min.css" />
	<link rel="stylesheet" href="<?=__ENV_INCLUDE_URL__?>static/css/datepicker3.min.css" />
	
    <link rel="apple-touch-icon" sizes="192x192" href="/assets/img/android-chrome-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon-16x16.png">
	<link rel="icon" type="image/png" href="/assets/img/favicon.ico">
	
    
    <!-- jQuery -->
    <script src="<?=__ENV_INCLUDE_URL__?>static/vendor/jquery/jquery.min.js"></script>
 	<script src="/public/jquery-ui-1.12.1/jquery-ui.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="<?=__ENV_INCLUDE_URL__?>static/vendor/bootstrap/js/bootstrap.min.js"></script>
    
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?=__ENV_INCLUDE_URL__?>static/vendor/metisMenu/metisMenu.min.js"></script>
    
    <!-- DataTables JavaScript -->
    <script src="<?=__ENV_INCLUDE_URL__?>static/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?=__ENV_INCLUDE_URL__?>static/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="<?=__ENV_INCLUDE_URL__?>static/vendor/datatables-responsive/dataTables.responsive.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="<?=__ENV_INCLUDE_URL__?>static/js/sb-admin-2.js?var=<?=__ENV_STATIC_VER__?>"></script>
    <script src="/public/js/util.js?var=<?=__ENV_STATIC_VER__?>"></script>
    <script src="<?=__ENV_INCLUDE_URL__?>static/js/bootstrap-datepicker.min.js"></script>

    <?php 
    if (isset($this->js)) 
    {
        foreach ($this->js as $js)
        {
            echo '<script type="text/javascript" src="'.__ENV_URL__.'views/'.$js.'"></script>';
        }
    }
    ?>    
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>


</head>
<body>
    <div id="wrapper">
		
		