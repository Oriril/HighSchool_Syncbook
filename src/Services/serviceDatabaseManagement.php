<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationInclude.php");

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
        // Connect to Database and Freeze that connection
        R::setup('mysql:host=' . $config['DATABASE_HOST'] . ';dbname=sabredav_' . $webDAVUsername,
            $config['DATABASE']['DATABASE_USER_SINGLE']['USERNAME'], $config['DATABASE']['DATABASE_USER_SINGLE']['PASSWORD']);
        R::freeze(TRUE);

        // Checking if everything worked
        R::inspect();
        return TRUE;
    } catch (Exception $exceptionError) {}
return FALSE;
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
    // Normalizing $webDAVUsername
    $webDAVUsername = strtolower($webDAVUsername);

    try {
        // Database connection with PDO Method
        $connectionPDO = new PDO('mysql:dbname=sabredav_' . $webDAVUsername . ';hostname=' . $config['DATABASE_HOST'],
            $config['DATABASE']['DATABASE_USER_SINGLE']['USERNAME'], $config['DATABASE']['DATABASE_USER_SINGLE']['PASSWORD']);
        return $connectionPDO;
    } catch (Exception $exceptionError) {}
return FALSE;
}

/**
 * unction to create SabreDAV Database with PDO
 *
 * @param string $webDAVUsername
 * @param configurationClass $config
 * @return bool
 */
function databaseSabreDAVCreatePDO($webDAVUsername, configurationClass $config) {
    // Getting configurationArray to Set Up Database Connection
    $config = $config->configurationArray;
    // Normalizing $webDAVUsername
    $webDAVUsername = strtolower($webDAVUsername);

    try {
        // Host connection with PDO Method
        $connectionPDO = new PDO("mysql:hostname=" . $config['DATABASE_HOST'],
            $config['DATABASE']['DATABASE_USER_SINGLE']['USERNAME'], $config['DATABASE']['DATABASE_USER_SINGLE']['PASSWORD']);

        // Database Create
        $connectionPDO->exec("CREATE DATABASE IF NOT EXISTS sabredav_" . $webDAVUsername . " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
        USE sabredav_" . $webDAVUsername . ";" . require_once(SQL_PATH . "Sabredav.php"));

        return TRUE;
    } catch (Exception $exceptionError) {
        $connectionPDO->exec("DROP DATABASE sabredav_" . $webDAVUsername);
        echo($exceptionError);
    }
return FALSE;
}
