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
        <!-- Base CSS -->
        <link href="../../../lib/css/base.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo Config::get('URL') . "index/index"; ?>">Syncbook</a>
                </div>

                <div class="collapse navbar-collapse" id="navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li <?php if (View::checkForActiveController($filename, "index")) { echo ' class="active" '; } ?> >
                            <a href="<?php echo Config::get('URL'); ?>index/index">Home</a>
                        </li>
                        <?php if (Session::userIsLoggedIn()) { ?>
                            <li <?php if (View::checkForActiveController($filename, "dashboard")) { echo ' class="active" '; } ?> >
                                <a href="<?php echo Config::get('URL'); ?>dashboard/index">Dashboard</a>
                            </li>
                        <?php } ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (Session::userIsLoggedIn()) { ?>
                            <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="dropdown" '; } ?> >
                                <a href="<?php echo Config::get('URL'); ?>login/showprofile" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Account<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                                        <a href="<?php echo Config::get('URL'); ?>login/changeaccounttype">Change account type</a>
                                    </li>
                                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                                        <a href="<?php echo Config::get('URL'); ?>login/uploadavatar">Upload an avatar</a>
                                    </li>
                                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                                        <a href="<?php echo Config::get('URL'); ?>login/editusername">Edit my username</a>
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
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="<?php echo Config::get('URL'); ?>login/index">Log in</a></li>
                            </ul>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container containerPage" id="containerPage">
            <?php $this->renderFeedbackMessages(); ?>