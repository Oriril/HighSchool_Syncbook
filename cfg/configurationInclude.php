<?php

/*defined("LIBRARY_PATH") or define("LIBRARY_PATH", dirname(__DIR__) . "/lib/");
defined("SOURCE_PATH") or define("SOURCE_PATH", dirname(__DIR__) . "/src/");
defined("SQL_PATH") or define("SQL_PATH", dirname(__DIR__) . "/sql/");
defined("TEST_PATH") or define("TEST_PATH", dirname(__DIR__) . "/test/");*/

defined("LIBRARY_PATH") or define("LIBRARY_PATH",  "/var/www/html/Syncbook/lib/");
defined("SOURCE_PATH") or define("SOURCE_PATH",  "/var/www/html/Syncbook/src/");
defined("SQL_PATH") or define("SQL_PATH", "/var/www/html/Syncbook/sql/");
defined("TEST_PATH") or define("TEST_PATH", "/var/www/html/Syncbook/test/");

require_once("/var/www/html/Syncbook/lib/SabreDAV/vendor/autoload.php");
require_once("/var/www/html/Syncbook/lib/RedBeanPHP.php");