<?php

/*require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationInclude.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationClass.php");*/
require_once("/var/www/html/Syncbook/cfg/configurationInclude.php");
require_once("/var/www/html/Syncbook/cfg/configurationClass.php");

use Sabre\VObject;

require_once(SOURCE_PATH . "Services/serviceDatabaseManagement.php");

/**
 * Function to Create an AddressBook for a specific User
 *
 * @param PDO $connectionPDO
 * @param string $webDAVUsername
 * @param string $addressBookUri
 * @param string $addressBookDisplayName
 * @param string $addressBookDescription
 * @return bool
 */
function cardDAVAddressBookCreate(PDO $connectionPDO, $webDAVUsername, $addressBookUri, $addressBookDisplayName, $addressBookDescription) {
    try {
        // Building CardDAV Backend
        $cardDAVBackend = new Sabre\CardDAV\Backend\PDO($connectionPDO);
        // Creating CardDAV AddressBook and checking if all went good
        if ($cardDAVBackend->createAddressBook("principals/" . $webDAVUsername, $addressBookUri,
            array('{DAV:}displayname' => $addressBookDisplayName,
                  '{' . Sabre\CardDAV\Plugin::NS_CARDDAV . '}addressbook-description' => $addressBookDescription))) {return TRUE;}
    } catch (Exception $exceptionError) {}
return FALSE;
}

/**
 * Function to Delete an AddressBook using is ID in Database
 *
 * @param PDO $connectionPDO
 * @param int $addressBookID
 * @return bool
 */
function cardDAVAddressBookDelete(PDO $connectionPDO, $addressBookID) {
    try {
        // Building CardDAV Backend
        $cardDAVBackend = new Sabre\CardDAV\Backend\PDO($connectionPDO);
        // Deleting CardDAV AddressBook using ID and checking if all went good
        if ($cardDAVBackend->deleteAddressBook($addressBookID)) {return TRUE;}
    } catch (Exception $exceptionError) {}
return FALSE;
}

/**
 * Function to Update an AddressBook using is ID in Database
 *
 * @param string $webDAVUsername
 * @param int $addressBookID
 * @param string $addressBookDisplayName
 * @param string $addressBookDescription
 * @param null|string $addressBookUri
 * @return bool
 */
function cardDAVAddressBookUpdate($webDAVUsername, $addressBookID, $addressBookDisplayName, $addressBookDescription, $addressBookUri = NULL) {
    try {
        if (databaseSabreDAVConnectRedBean($webDAVUsername, new configurationClass())) {
            // Loading AddressBook Bean from Database
            $beanAddressBook = R::load('addressbooks', $addressBookID);

            // Updating the AddressBook that's has just been retrieved
            if ($addressBookUri !== NULL) {
                $beanAddressBook->uri = $addressBookUri;
            }
            $beanAddressBook->displayname = $addressBookDisplayName;
            $beanAddressBook->description = $addressBookDescription;

            // Store the Updated AddressBook
            $addressBookID = R::store($beanAddressBook);
            return TRUE;
        }
    } catch (Exception $exceptionError) {}
return FALSE;
}

/**
 * Function to Retrieve the AddressBooksList for a specific User
 *
 * @param PDO $connectionPDO
 * @param string $webDAVUsername
 * @return array|bool
 */
function cardDAVAddressBooksList(PDO $connectionPDO, $webDAVUsername) {
    try {
        // Building CardDAV Backend
        $cardDAVBackend = new Sabre\CardDAV\Backend\PDO($connectionPDO);
        // Retrieving AddressBooksList
        if ($addressBooksList = $cardDAVBackend->getAddressBooksForUser("principals/" . $webDAVUsername)) {return $addressBooksList;}
    } catch (Exception $exceptionError) {}
return FALSE;
}

/**
 * Function to Retrieve an AddressBook from an AddressBooksList for a specific User
 *
 * @param PDO $connectionPDO
 * @param string $webDAVUsername
 * @param string $addressBookUri
 * @return bool|\Sabre\CardDAV\AddressBook
 */
function cardDAVAddressBookRetrieve(PDO $connectionPDO, $webDAVUsername, $addressBookUri) {
    try {
        // Retrieving AddressBooksList for User
        $addressBooksList = cardDAVAddressBooksList($connectionPDO, $webDAVUsername);

        // Checking if Retrieving operation went good
        if ($addressBooksList !== FALSE) {
            foreach ($addressBooksList as $addressBookInfo) {
                // Checking if addressBookUri is found in List
                if ($addressBookInfo['uri'] == $addressBookUri) {

                    // Building CardDAV Backend
                    $cardDAVBackend = new Sabre\CardDAV\Backend\PDO($connectionPDO);
                    // Retrieving AddressBook
                    if ($addressBook = new Sabre\CardDAV\AddressBook($cardDAVBackend, $addressBookInfo)) {return $addressBook;}
                }
            }
        }
    } catch (Exception $exceptionError) {}
return FALSE;
}