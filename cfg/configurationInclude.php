<?php

defined("LIBRARY_PATH") or define("LIBRARY_PATH", dirname(__DIR__) . "/lib/");
defined("SOURCE_PATH") or define("SOURCE_PATH", dirname(__DIR__) . "/src/");

require_once(LIBRARY_PATH . "SabreDAV/vendor/autoload.php");
require_once(LIBRARY_PATH . "RedBeanPHP.php");