<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>%title%</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Financiera San Andrés | Tu mejor opción" name="description" />
    <meta name="author" content="<?php echo HCStudio\Connection::$proyect_name;?> all rights reserved 2022">
    <meta name="HandheldFriendly" content="True" />
    <meta name="theme-color" content="#2D2250">   
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/img/logo-sm.png">

    <!-- plugin css -->
    <link href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body data-sidebar="dark">

    %content%

    <!-- JAVASCRIPT -->
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/js/jquery-3.1.1.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/js/jquery-3.1.1.js" type="text/javascript"></script>
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/js/jquery-ui.js?t=1" type="text/javascript"></script>
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/js/alertCtrl.js?t=1" type="text/javascript"></script>
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/js/loader.js" type="text/javascript"></script>
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/js/boxloader.js?t=1" type="text/javascript"></script>
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/js/http.js?t=1" type="text/javascript"></script>
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/js/translator.js" type="text/javascript"></script>
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/js/general.js?t=3" type="text/javascript"></script>

    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/js/special-alert.js?t=3" type="text/javascript"></script>
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/js/notifications-object.js" type="text/javascript"></script>
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/js/notifications-sm.js" type="text/javascript"></script>
    %js_scripts%

    <link href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/css/general.css" rel="stylesheet">
    <link href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/css/responsive.css" rel="stylesheet">
    <link href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/css/special-alert.css" rel="stylesheet">
    <link href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/css/loader.css" rel="stylesheet">

    %css_scripts%
</body>
</html>