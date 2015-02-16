<?php

/**
 * Function to connect to Database with RedBean PHP
 *
 * @param string $webDAVUsername
 * @param configurationClass $config
 * @return bool
 */
function databaseSabreDAVConnectRedBean($webDAVUsername, configurationClass $config) {
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

/**
 * Function to connect to Database with PDO
 *
 * @param string $webDAVUsername
 * @param configurationClass $config
 * @return bool|PDO
 */
function databaseSabreDAVConnectPDO($webDAVUsername, configurationClass $config)
{
    // Getting configurationArray to Set Up Database Connection
    $config = $config->configurationArray;

    try {
        // Database connection with PDO Method
        $connectionPDO = new PDO('mysql:dbname=sabredav_' . $webDAVUsername . ';hostname=' . $config['DATABASE_HOST'],
            $config['DATABASE']['DATABASE_USER_SINGLE']['USERNAME'], $config['DATABASE']['DATABASE_USER_SINGLE']['PASSWORD']);
    } catch (Exception $exceptionError) {
        return FALSE;
    }
return $connectionPDO;
}