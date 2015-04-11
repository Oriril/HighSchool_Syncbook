<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationInclude.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationClass.php");
use Sabre\VObject;

require_once(SOURCE_PATH . "SabreDAV/CardDAV/cardDAVManagement.php");
require_once(SOURCE_PATH . "SabreDAV/CardDAV/contactMapper.php");

/**
 * Function for Creating a vCard in a specific AddressBook
 *
 * @param \Sabre\CardDAV\AddressBook $addressBook
 * @param VObject\Component\VCard $vCardData
 * @return bool
 */
function vCardCreate(Sabre\CardDAV\AddressBook $addressBook, VObject\Component\VCard $vCardData) {
    try {
        // Checking if the vCard has an UID, if not assigning it
        if ($vCardData->UID === "") {$vCardData->UID = Sabre\DAV\UUIDUtil::getUUID();}

        // Uploading vCard to Server and checking if all went good
        if ($addressBook->createFile($vCardData->UID . ".vcf", $vCardData->serialize())) {return TRUE;}
    } catch (Exception $exceptionError) {}
return FALSE;
}

/**
 * Function for Deleting a vCard in a specific AddressBook
 *
 * @param \Sabre\CardDAV\AddressBook $addressBook
 * @param VObject\Component\VCard $vCardData
 * @return bool
 */
function vCardDelete(Sabre\CardDAV\AddressBook $addressBook, VObject\Component\VCard $vCardData) {
    try {
        // Retrieving vCard UID from vCardData
        if ($vCard = $addressBook->getChild($vCardData->UID . ".vcf")) {
            // Deleting vCard from Server and checking if all went good
            if ($vCard->delete()) {return TRUE;}
        }
    } catch (Exception $exceptionError) {}
return FALSE;
}

/**
 * Function for Updating a vCard in a specific AddressBook
 *
 * @param \Sabre\CardDAV\AddressBook $addressBook
 * @param VObject\Component\VCard $vCardData
 * @return bool
 */
function vCardUpdate(Sabre\CardDAV\AddressBook $addressBook, VObject\Component\VCard $vCardData) {
    try {
        // Retrieving vCard UID from vCardData
        if ($vCard = $addressBook->getChild($vCardData->UID . ".vcf")) {
            // Updating vCard in Server and checking if all went good
            if ($vCard->put($vCardData->serialize())) {return TRUE;}
        }
    } catch (Exception $exceptionError) {}
return FALSE;
}

/**
 * Function to retrieve vCardList
 *
 * $returnArray = array(
 *   'UID' => array(
 *   'FirstName' => "",
 *   'LastName' => ""
 * )
 *
 * @param \Sabre\CardDAV\AddressBook $addressBook
 * @param $arrayUID
 * @return array|bool
 */
function vCardListRetrieve(Sabre\CardDAV\AddressBook $addressBook, $arrayUID) {
    try {
        // Building an empty Array
        $returnArray = array();

        foreach($arrayUID as $singleUID) {
            // Getting vCardData for UID
            $vCardData = $addressBook->getChild($singleUID);

            $vCardObject = mapperCardObject($vCardData->serialize());

            $returnArray[$vCardObject->UID] = array(
                'contactFirstName' => $vCardObject->contactDefault->contactFirstName,
                'contactLastName' => $vCardObject->contactDefault->contactLastName
            );
        }

        return $returnArray;
    } catch (Exception $exceptionError) {}
return FALSE;
}

/*$connectionPDO = databaseSabreDAVConnectPDO("admin", new configurationClass());
$addressBook = cardDAVAddressBookRetrieve($connectionPDO, "admin", "AdminTestUri");

$vCard = VObject\Reader::read(fopen(TEST_PATH . "vCardStorage/FedericoLonghin.vcf", "r"));*/