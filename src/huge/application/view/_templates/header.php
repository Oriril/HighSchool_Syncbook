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
    <link href="../../../lib/bootstrap-3.3.2-dist/css/bootstrap.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../../../lib/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
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
                    <form class="navbar-form navbar-right">
                        <a href="<?php echo Config::get('URL'); ?>login/register" class="btn btn-success">Register</a>
                        <a href="<?php echo Config::get('URL'); ?>login/index" class="btn btn-primary">Login</a></li>
                    </form>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <?php $this->renderFeedbackMessages(); ?>