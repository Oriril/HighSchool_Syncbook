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
        <link href="../lib/bootstrap-3.3.2-dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
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
                <a class="navbar-brand" href="#">Syncbook</a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href=#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="well">
            <form class="form-horizontal" action="" method="post">
                <fieldset>
                    <legend>Insert a new contact!</legend>
                    <div class="form-group">
                        <label for="prefix" class="col-lg-2 control-label">Prefix</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="prefix" name="prefix" placeholder="Prefix" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="first_name" class="col-lg-2 control-label">First Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="col-lg-2 control-label">Last Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="suffix" class="col-lg-2 control-label">Suffix</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="suffix" name="suffix" placeholder="Suffix" required />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Phone</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Email</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Address</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Address" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="custom_1" name="custom_1" placeholder="Custom label" required />
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="custom_content_1" name="custom_content_1" placeholder="Custom content" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="custom_2" name="custom_2" placeholder="Custom label" required />
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="custom_content_2" name="custom_content_2" placeholder="Custom content" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="custom_3" name="custom_3" placeholder="Custom label" required />
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="custom_content_3" name="custom_content_3" placeholder="Custom content" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="custom_4" name="custom_4" placeholder="Custom label" required />
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="custom_content_4" name="custom_content_4" placeholder="Custom content" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="custom_5" name="custom_5" placeholder="Custom label" required />
                        </div>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="custom_content_5" name="custom_content_5" placeholder="Custom content" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10">
                            <input type="submit" class="btn-primary" value="Insert"/>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>




        <footer>
            <p>&copy; Syncbook 2015</p>
        </footer>
    </div> <!-- /container -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../lib/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
</body>
</html>
