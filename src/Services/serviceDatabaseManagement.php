<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationInclude.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationClass.php");

/**
 * Function to connect to Database with RedBean PHP
 *
 * @param string $webDAVUsername
 * @param configurationClass $config
 * @return bool
 */
function databaseSabreDAVConnectRedBean($webDAVUsername, configurationClass $configClass, $silentFlag = FALSE) {
    // Getting configurationArray to Set Up Database Connection
    $config = $configClass->configurationArray;
    // Normalizing $webDAVUsername
    $webDAVUsername = strtolower($webDAVUsername);

    try {
        // Connect to Database and Freeze that connection
        R::setup('mysql:host=' . $config['DATABASE_HOST'] . ';dbname=sabredav_' . $webDAVUsername,
            $config['DATABASE']['DATABASE_USER_SINGLE']['USERNAME'], $config['DATABASE']['DATABASE_USER_SINGLE']['PASSWORD']);
        R::freeze(TRUE);

        // Checking if everything worked
        R::inspect();
        return TRUE;
    } catch (Exception $exceptionError) {
        if ($silentFlag === TRUE) {
            if (databaseSabreDAVCreateRedBean($webDAVUsername, $configClass)) {return TRUE;}
        }
    }
return FALSE;
}

/**
 * Function to create Database with RedBean PHP
 *
 * @param string $webDAVUsername
 * @param configurationClass $config
 * @return bool
 */
function databaseSabreDAVCreateRedBean($webDAVUsername, configurationClass $config) {
    // Getting configurationArray to Set Up Database Connection
    $config = $config->configurationArray;
    // Normalizing $webDAVUsername
    $webDAVUsername = strtolower($webDAVUsername);

    try {
        error_log("HOST : " . $config['DATABASE_HOST']);
        error_log("USERNAME : " . $config['DATABASE']['DATABASE_USER_SINGLE']['USERNAME']);
        error_log("PASSWORD : " . $config['DATABASE']['DATABASE_USER_SINGLE']['PASSWORD']);

        // Connect to Database and Selecting that connection
        R::addDatabase('Root', 'mysql:host=' . $config['DATABASE_HOST'],
            $config['DATABASE']['DATABASE_USER_SINGLE']['USERNAME'], $config['DATABASE']['DATABASE_USER_SINGLE']['PASSWORD']);
        R::selectDatabase('Root');

        if (R::exec("CREATE DATABASE sabredav_" . $webDAVUsername . " DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
            USE sabredav_" . $webDAVUsername . ";" . require_once(SQL_PATH . "SabreDAV.php"))) {
            // Back to Default Database
            R::selectDatabase('default');
            return TRUE;
        }
    } catch (Exception $exceptionError) {error_log($exceptionError);}

    // Closing Database connection before finishing
    R::close();
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