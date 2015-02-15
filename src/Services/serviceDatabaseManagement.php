<?php

/**
 * Function for connecting to Database
 *
 * @param $webDAVUsername
 * @param configurationClass $config
 * @return bool
 */
function databaseSabreDAVUserConnect($webDAVUsername, configurationClass $config) {
    // Getting configurationArray to Set Up Database Connection
    $config = $config->configurationArray;

    try {
        // Checking if already connected to Database
        R::inspect();
    } catch (Exception $exceptionError) {
        try {
            // Connect to Database and Freeze that connection
            R::setup('mysql:host=' . $config['DATABASE_HOST'] . ';dbname=sabredav_' . strtolower($webDAVUsername),
                $config['DATABASE']['DATABASE_USER_SINGLE']['USERNAME'], $config['DATABASE']['DATABASE_USER_SINGLE']['PASSWORD']);
            R::freeze(TRUE);

            // Checking if everything worked
            R::inspect();
        } catch (Exception $exceptionError) {
            return FALSE;
        }
    }
return TRUE;
}