<?php
    function databaseSabreDAVUserConnect($webDAVUsername, $config) {
        try {
            R::setup('mysql:host = ' . $config['DATABASE_HOST'] . '; dbname = sabredav_' . strtolower($webDAVUsername),
                $config['DATABASE']['DATABASE_USER_SINGLE']['USERNAME'], $config['DATABASE']['DATABASE_USER_SINGLE']['PASSWORD']);
            R::freeze(TRUE);
        } catch (Exception $exceptionError) {}
    }