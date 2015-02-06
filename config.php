<?php
    return array(
        "DATABASE_HOST" => "10.8.0.1",

        "DATABASE" => array(
            "DATABASE_USER_LIST" => array(
                "USERNAME" => "longh",
                "PASSWORD" => "longh123"
            ),

            "DATABASE_USER_SINGLE" => array(
                "USERNAME" => "longh",
                "PASSWORD" => "longh123"
            )
        )
    );

    defined("LIBRARY_PATH") or define("LIBRARY_PATH", realpath(dirname("__FILE__" . "/lib")));
    defined("SOURCE_PATH") or define("SOURCE_PATH", realpath(dirname("__FILE__" . "/src")));

    require_once(LIBRARY_PATH . "/SabreDAV/vendor/autoload.php");
    require_once(LIBRARY_PATH . "/RedBeanPHP.php");