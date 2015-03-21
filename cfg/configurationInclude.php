<?php

defined("LIBRARY_PATH") or define("LIBRARY_PATH", dirname(__DIR__) . "/lib/");
defined("SOURCE_PATH") or define("SOURCE_PATH", dirname(__DIR__) . "/src/");
defined("SQL_PATH") or define("SQL_PATH", dirname(__DIR__) . "/sql/");
defined("TEST_PATH") or define("TEST_PATH", dirname(__DIR__) . "/test/");

require_once(LIBRARY_PATH . "SabreDAV/vendor/autoload.php");
require_once(LIBRARY_PATH . "RedBeanPHP.php");