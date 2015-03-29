<?php
echo ('https://' . $_SERVER['HTTP_HOST'] . str_replace('public', '', dirname($_SERVER['SCRIPT_NAME'])));
$vendorDir = dirname(dirname(__FILE__));
//$baseDir = dirname($vendorDir);
echo($vendorDir);