<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationClass.php");
$config = new configurationClass() and $config = $config->configurationArray;

/**
 * This server combines both CardDAV and CalDAV functionality into a single
 * server. It is assumed that the server runs at the root of a HTTP domain (be
 * that a domainname-based vhost or a specific TCP port.
 *
 * This example also assumes that you're using SQLite and the database has
 * already been setup (along with the database tables).
 *
 * You may choose to use MySQL instead, just change the PDO connection
 * statement.
 */

/**
 * UTC or GMT is easy to work with, and usually recommended for any
 * application.
 */
date_default_timezone_set('UTC');

/**
 * Make sure this setting is turned on and reflect the root url for your WebDAV
 * server.
 *
 * This can be for example the root / or a complete path to your server script.
 */
$baseUri = '/Syncbook/lib/SabreDAV/groupwareserver.php/';

if (!isset($databaseUsername)) {
    $serverUri = $_SERVER["REQUEST_URI"];
    $serverName = $_SERVER["SCRIPT_NAME"];

    if (strpos($serverUri, '/principals/') !== false) {
        $urlParamsString = str_replace($serverName . "/principals/", "", $serverUri);
    } else if (strpos($serverUri, '/calendars/') !== false) {
        $urlParamsString = str_replace($serverName . "/calendars/", "", $serverUri);
    } else if (strpos($serverUri, '/addressbooks/') !== false) {
        $urlParamsString = str_replace($serverName . "/addressbooks/", "", $serverUri);
    } else {
        $urlParamsString = '';
    }

    if ($urlParamsString === '') {$urlParamsString = 'admin';}
}

/**
 * Database
 *
 * Feel free to switch this to MySQL, it will definitely be better for higher
 * concurrency.
 */
$pdo = new PDO('mysql:dbname=sabredav_' . $urlParamsString . ';hostname=' . $config['DATABASE_HOST'],
    $config['DATABASE']['DATABASE_USER_SINGLE']['USERNAME'], $config['DATABASE']['DATABASE_USER_SINGLE']['PASSWORD']);
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

/**
 * Mapping PHP errors to exceptions.
 *
 * While this is not strictly needed, it makes a lot of sense to do so. If an
 * E_NOTICE or anything appears in your code, this allows SabreDAV to intercept
 * the issue and send a proper response back to the client (HTTP/1.1 500).
 */
function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler("exception_error_handler");

// Autoloader
require_once 'vendor/autoload.php';

/**
 * The backends. Yes we do really need all of them.
 *
 * This allows any developer to subclass just any of them and hook into their
 * own backend systems.
 */
$authBackend      = new \Sabre\DAV\Auth\Backend\PDO($pdo);
$principalBackend = new \Sabre\DAVACL\PrincipalBackend\PDO($pdo);
$carddavBackend   = new \Sabre\CardDAV\Backend\PDO($pdo);
$caldavBackend    = new \Sabre\CalDAV\Backend\PDO($pdo);

/**
 * The directory tree
 *
 * Basically this is an array which contains the 'top-level' directories in the
 * WebDAV server.
 */
$nodes = [
    // /principals
    new \Sabre\CalDAV\Principal\Collection($principalBackend),
    // /calendars
    new \Sabre\CalDAV\CalendarRoot($principalBackend, $caldavBackend),
    // /addressbook
    new \Sabre\CardDAV\AddressBookRoot($principalBackend, $carddavBackend),
];

// The object tree needs in turn to be passed to the server class
$server = new \Sabre\DAV\Server($nodes);
if (isset($baseUri)) $server->setBaseUri($baseUri);

// Plugins
$server->addPlugin(new \Sabre\DAV\Auth\Plugin($authBackend,'SabreDAV'));
$server->addPlugin(new \Sabre\DAV\Browser\Plugin());
$server->addPlugin(new \Sabre\CalDAV\Plugin());
$server->addPlugin(new \Sabre\CardDAV\Plugin());
$server->addPlugin(new \Sabre\DAVACL\Plugin());
$server->addPlugin(new \Sabre\DAV\Sync\Plugin());

// And off we go!
$server->exec();
