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


    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">

                       <!-- LOGO -->
                 <div class="navbar-brand-box text-white">
                    <a href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            FSA
                        </span>
                        <span class="logo-lg">
                            Financiera San Andrés
                        </span>
                    </a>

                    <a href="../../apps/backoffice" class="logo text-white logo-light">
                        <span class="logo-sm">
                            FSA
                        </span>
                        <span class="logo-lg">
                            Financiera San Andrés
                        </span>
                    </a>
                </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="mdi mdi-menu"></i>
                    </button>


                    <div class="topbar-social-icon me-3 d-none d-md-block">
                        <ul class="list-inline title-tooltip m-0">
                            <li class="list-inline-item">
                                <a href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/email-inbox.html" data-bs-toggle="tooltip" data-placement="top" title="Correo">
                                 <i class="mdi mdi-email-outline"></i>
                                </a>
                            </li>
                        
                            <li class="list-inline-item">
                                <a href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/chat.html" data-bs-toggle="tooltip" data-placement="top" title="Chat">
                                 <i class="mdi mdi-tooltip-outline"></i>
                                </a>
                            </li>

                            <li class="list-inline-item">
                                <a href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/calendar.html" data-bs-toggle="tooltip" data-placement="top" title="Calendario">
                                 <i class="mdi mdi-calendar"></i>
                                </a>
                            </li>

                            <li class="list-inline-item">
                                <a href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/pages-invoice.html" data-bs-toggle="tooltip" data-placement="top" title="Imprimir">
                                 <i class="mdi mdi-printer"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
            
                </div>

                 <!-- Search input -->
                 <div class="search-wrap" id="search-wrap">
                    <div class="search-bar">
                        <input class="search-input form-control" placeholder="Buscar" />
                        <a class="close-search toggle-search" data-target="#search-wrap">
                            <i class="mdi mdi-close-circle"></i>
                        </a>
                    </div>
                </div>

                <div class="d-flex">
                    <div class="dropdown d-none d-lg-inline-block">
                        <button type="button" class="btn header-item toggle-search noti-icon waves-effect" data-target="#search-wrap">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>

                    <div class="dropdown d-none d-md-block ms-2">
                        <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="me-2" src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/images/flags/spain.jpg" alt="Header Language" height="16"> Español <span class="mdi mdi-chevron-down"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <button onclick="changeLanguage('en')" class="dropdown-item notify-item">
                              <img src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle"> Ingles </span>
                            </button>

                            <!-- item-->
                            <button onclick="changeLanguage('en')" class="dropdown-item notify-item">
                                <img src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle"> German </span>
                            </button>

                            <!-- item-->
                            <button onclick="changeLanguage('en')" class="dropdown-item notify-item">
                                <img src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle"> Italian </span>
                            </button>

                            <!-- item-->
                            <button onclick="changeLanguage('en')" class="dropdown-item notify-item">
                                <img src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/images/flags/french.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle"> French </span>
                            </button>
                            <!-- item-->
                            <button onclick="changeLanguage('en')" class="dropdown-item notify-item">
                                <img src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle"> Russian </span>
                            </button>
                        </div>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="mdi mdi-fullscreen"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-bell-outline bx-tada"></i>
                            <span class="badge bg-danger rounded-pill">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0"> Notificaciones </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/#!" class="small"> View All</a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">

                            </div>
                            <div class="p-2 border-top">
                                <a class="btn btn-sm btn-link font-size-14 w-100 text-center" href="../../apps/notification-center">
                                    <i class="mdi mdi-arrow-right-circle me-1"></i> Ver más..
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="<?php echo $UserSupport->getImageForProfile();?>"
                                alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1"><?php echo $UserSupport->getShortName();?></span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/apps/team/profile?ulid=<?php echo $UserSupport->company_id;?>"><i class="mdi mdi-account-circle-outline font-size-16 align-middle me-1"></i> Perfil</a>
                            <a class="dropdown-item" href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/apps/ewallet"><i class="mdi mdi-wallet-outline font-size-16 align-middle me-1"></i> Mi e-Wallet</a>
                            <a class="dropdown-item d-block" href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/apps/backoffice/update_profile"><span class="badge badge-success float-end">11</span><i class="mdi mdi-cog-outline font-size-16 align-middle me-1"></i> Ajustes</a>
                            <a class="dropdown-item"><i class="mdi mdi-lock-open-outline font-size-16 align-middle me-1"></i> Lock screen</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="../../apps/admin/?logout=true"><i class="mdi mdi-power font-size-16 align-middle me-1 text-danger"></i> Salir</a>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                            <i class="mdi mdi-cog-outline font-size-20"></i>
                        </button>
                    </div>
            
                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">


                <div class="user-sidebar text-center">
                    <div class="dropdown">
                        <div class="user-img">
                            <img src="<?php echo $UserSupport->getImageForProfile();?>" alt="<?php echo $UserSupport->getShortName();?>" class="rounded-circle">
                            <span class="avatar-online bg-success"></span>
                        </div>
                        <div class="user-info">
                            <h5 class="mt-3 font-size-16 text-white"><?php echo $UserSupport->getShortName();?></h5>
                            <span class="font-size-13 text-white-50">Admin</span>
                        </div>
                    </div>
                </div>



                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">

                        <li class="menu-title">Menú</li>

                        <li>
                            <a class="has-arrow waves-effect">
                                <i class="dripicons-suitcase"></i>
                                <span>Clientes</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="../../apps/admin-client/">Lista</a></li>
                                <li><a href="../../apps/admin-client/add">Alta</a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow waves-effect">
                                <i class="dripicons-suitcase"></i>
                                <span>Vendedores</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="../../apps/admin-seller/">Lista</a></li>
                                <li><a href="../../apps/admin-seller/add">Alta</a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow waves-effect">
                                <i class="dripicons-suitcase"></i>
                                <span>Préstamos</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="../../apps/admin-loan/add">Dar de alta</a></li>
                                <li><a href="../../apps/admin-loan/?s=<?php echo FSA\LoanPerUser::$PENDING_FOR_APPROVAL;?>">Pendientes</a></li>
                                <li><a href="../../apps/admin-loan/?s=<?php echo FSA\LoanPerUser::$APPROVED;?>">En curso</a></li>
                                <li><a href="../../apps/admin-loan/?s=<?php echo FSA\LoanPerUser::$FINISHED;?>">Terminados</a></li>
                                <li><a href="../../apps/admin-loan/?s=<?php echo FSA\LoanPerUser::$REJECTED;?>">Rechazados</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>


        <div class="main-content">

            <div class="page-content">
              %content% 
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © <img src="../../src/img/logo-horizontal.png" width="42px">
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Crafted with <i class="mdi mdi-heart text-danger"></i> by Financiera San Andrés
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title d-flex align-items-center px-3 py-4">
            
                <h5 class="m-0 me-2">Opciones</h5>

                <a class="right-bar-toggle ms-auto">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />
            <h6 class="text-center mb-0">Elegir Layout</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="layout-1">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                    <label class="form-check-label" for="light-mode-switch">Modo normal</label>
                </div>
    
                <div class="mb-2">
                    <img src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="layout-2">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css">
                    <label class="form-check-label" for="dark-mode-switch">Modo obscuro</label>
                </div>
    
                <div class="mb-2">
                    <img src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="layout-3">
                </div>
                <div class="form-check form-switch mb-5">
                    <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css">
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>

            
            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <!-- <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/libs/jquery/jquery.min.js"></script> -->
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/js/jquery-3.1.1.js" type="text/javascript"></script>
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/libs/node-waves/waves.min.js"></script>

    <!-- apexcharts -->
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- Plugins js-->
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>

    <?php if($init === true) { ?>
        <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/js/pages/dashboard.init.js"></script>
    <?php } ?>

    <script src="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/dist/assets/js/app.js"></script>

    <!-- core -->
    
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
    <link href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/css/special-alert.css" rel="stylesheet">
    <link href="<?php echo HCStudio\Connection::$protocol;?>://<?php echo HCStudio\Connection::$proyect_url;?>/src/css/loader.css" rel="stylesheet">

    %css_scripts%
</body>
</html>