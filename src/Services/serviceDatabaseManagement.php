<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "\\lib\\RedBeanPHP.php");

    const DATABASE_HOST = '10.8.0.1';
    const DATABASE_USERNAME = 'longh';
    const DATABASE_PASSWORD = 'longh123';

    function databaseSabreDAVUserConnect ($webDAVUsername) {
        try {
            R::setup('mysql:host = ' . DATABASE_HOST . '; dbname = sabredav_' . strtolower($webDAVUsername), DATABASE_USERNAME, DATABASE_PASSWORD);
            R::freeze(TRUE);
        } catch (Exception $exceptionError) {}
    }