<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationInclude.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationClass.php");
use Sabre\VObject;

require_once(SOURCE_PATH . "Services/serviceDatabaseManagement.php");

/**
 * Function to Create an AddressBook for a specific User
 *
 * @param PDO $connectionPDO
 * @param string $webDAVUsername
 * @param string $addressBookUri
 * @param string $addressBookDisplayName
 * @return bool
 */
function cardDAVAddressBookCreate($connectionPDO, $webDAVUsername, $addressBookUri, $addressBookDisplayName) {
    try {
        // Building CardDAV Backend
        $cardDAVBackend = new Sabre\CardDAV\Backend\PDO($connectionPDO);

        // Creating CardDAV AddressBook and checking if all went good
        if (! ($cardDAVBackend->createAddressBook("principals/" . $webDAVUsername, $addressBookUri, array(
                '{DAV:}displayname' => $addressBookDisplayName)))) {
            return FALSE;
        }
    } catch (Exception $exceptionError) {
        return FALSE;
    }
return TRUE;
}

/**
 * Function to Delete an AddressBook using is ID in Database
 *
 * @param PDO $connectionPDO
 * @param int $addressBookID
 * @return bool
 */
function cardDAVAddressBookDelete($connectionPDO, $addressBookID) {
    try {
        // Building CardDAV Backend
        $cardDAVBackend = new Sabre\CardDAV\Backend\PDO($connectionPDO);

        // Deleting CardDAV AddressBook using ID and checking if all went good
        if (! ($cardDAVBackend->deleteAddressBook($addressBookID))) {
            return FALSE;
        }
    } catch (Exception $exceptionError) {
        return FALSE;
    }
return TRUE;
}

function cardDAVAddressBookUpdate($connectionPDO, $addressBookID, $addressBookUri, $addressBookDisplayName) {
    try {
        // Building CardDAV Backend
        $cardDAVBackend = new Sabre\CardDAV\Backend\PDO($connectionPDO);

        // Deleting CardDAV AddressBook using ID and checking if all went good
        if (! ($cardDAVBackend->updateAddressBook($addressBookID, new \Sabre\DAV\PropPatch(array(
                '{DAV:}uri' => $addressBookUri,
                '{DAV:}displayname' => $addressBookDisplayName
        ))))) {
            return FALSE;
        }
    } catch (Exception $exceptionError) {
        return FALSE;
    }
return TRUE;
}

cardDAVAddressBookUpdate(databaseSabreDAVConnectPDO("admin", new configurationClass()), 1, "testUpdateUri", "testUpdateDisplayName");