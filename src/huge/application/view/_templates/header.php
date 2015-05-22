<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationInclude.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Syncbook</title>

        <!-- Bootstrap -->
        <link href="../../../lib/bootstrap-3.3.2/css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design -->
        <link href="../../../lib/material-design/css/roboto.min.css" rel="stylesheet">
        <link href="../../../lib/material-design/css/material-fullpalette.css" rel="stylesheet">
        <link href="../../../lib/material-design/css/ripples.css" rel="stylesheet">
        <!-- Scrolling nav -->
        <link href="../../../lib/css/scrolling-nav.css" rel="stylesheet">
        <!-- Base CSS -->
        <link href="../../../lib/css/base.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../../../lib/font-awesome-4.3.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../../../lib/css/about-card.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
        <nav class="navbar navbar-inverse navbar-default navbar-fixed-top top-nav-collapse" role="navigation">
            <div class="container">
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand page-scroll" href="#page-top">Syncbook</a>
                </div>

                <div class="collapse navbar-collapse navbar-ex1-collapse" id="navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="hidden">
                            <a class="page-scroll" href="#page-top"></a>
                        </li>
                        <?php if (Session::userIsLoggedIn()) { ?>
                            <li id="page-dashboard" <?php if (View::checkForActiveController($filename, "dashboard")) { echo ' class="active" '; } ?> >
                                <a href="<?php echo Config::get('URL'); ?>dashboard/index">Dashboard</a>
                            </li>
                        <?php } else { ?>
                            <?php if (View::checkForActiveController($filename, "index")) { ?>
                                <li>
                                    <a class="page-scroll" href="#services">Services</a>
                                </li>
                                <li>
                                    <a class="page-scroll" href="#powered-by">Powered by</a>
                                </li>
                                <li>
                                    <a class="page-scroll" href="#team">Team</a>
                                </li>
                            <?php } else { ?>
                                <li <?php if (View::checkForActiveController($filename, "index")) { echo ' class="active" '; } ?> >
                                    <a href="<?php echo Config::get('URL'); ?>index/index">Home</a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (Session::userIsLoggedIn()) { ?>
                            <li class="add-button">
                                <button class="btn btn-fab btn-fab-mini btn-raised btn-material-deep-purple-200 btn-sm" id="displayAddContactForm">
                                    <i class='fa fa-plus'></i>
                                </button>
                            </li>
                            <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="dropdown" '; } ?> >
                                <a href="<?php echo Config::get('URL'); ?>login/showprofile" class="dropdown-toggle" style="padding-bottom: 8px;padding-top: 8px;" data-toggle="dropdown" role="button" aria-expanded="false"><img src="<?php echo Session::get('user_gravatar_image_url') ?>" class="img-circle"><span class="caret"></span></a>

                                <ul class="dropdown-menu" role="menu">
                                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                                        <a href="<?php echo Config::get('URL'); ?>login/showprofile">Show profile</a>
                                    </li>
                                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                                        <a href="<?php echo Config::get('URL'); ?>login/edituseremail">Edit my email</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                                        <a href="<?php echo Config::get('URL'); ?>login/logout">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        <?php } else { ?>
                            <?php if (!View::checkForActiveController($filename, "login")) { ?>
                                <li >
                                    <button class="btn btn-material-deep-purple-300" data-toggle="modal" data-target="#log-in-dialog">Log in</button>
                                </li>
                            <?php } ?>

                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
