<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/src/databaseConstants.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/lib/RedBeanPHP.php");

    function databaseSabreDAVUserConnect ($webDAVUsername) {
        try {
            R::setup('mysql:host = ' . DATABASE_HOST . '; dbname = sabredav_' . strtolower($webDAVUsername), DATABASE_USERNAME, DATABASE_PASSWORD);
            R::freeze(TRUE);
        } catch (Exception $exceptionError) {}
    }