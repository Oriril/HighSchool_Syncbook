<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationInclude.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationClass.php");
use Sabre\VObject;

/**
 * Function to turn an Object to vCard
 *
 * @param $vCardObject
 * @return VObject\Component\VCard
 */
function mapperObjectCard($vCardObject) {
    // @TODO This could be written simpler and cleaner using functions
    // @TODO Implement controls for possible NULL Parameters

    // Mapping UID Parameter
    $vCard = new Sabre\VObject\Component\VCard([
        'UID' => ($vCardObject->UID !== "") ? $vCardObject->UID : Sabre\DAV\UUIDUtil::getUUID()
    ]);

    // Mapping contactDefault Parameters
    $contactDefault = $vCardObject->contactDefault;

    $vCard->add('FN',
        $contactDefault->contactPrefix . " " .
        $contactDefault->contactFirstName . " " .
        $contactDefault->contactMiddleName . " " .
        $contactDefault->contactLastName . " " .
        $contactDefault->contactSuffix
    );
    $vCard->add('N', [
        $contactDefault->contactLastName,
        $contactDefault->contactFirstName,
        $contactDefault->contactMiddleName,
        $contactDefault->contactPrefix,
        $contactDefault->contactSuffix
    ]);

    // Mapping contactCompany Parameters
    $contactCompany = $vCardObject->contactCompany;

    if ($contactCompany->contactIsCompany === "TRUE") {
        $vCard->FN = $contactCompany->contactCompany;
    }
    $vCard->add('ORG', [
        $contactCompany->contactCompany,
        $contactCompany->contactDepartment
    ]);
    $vCard->add('TITLE', $contactCompany->contactJobTitle);
    $vCard->add('ROLE', $contactCompany->contactJobRole);

    $dateTime = new \DateTime($contactCompany->contactBirthDate);
    $dateTime = $dateTime->format('Y-m-d\TH:i:s\Z');
    $vCard->add('BDAY', $dateTime);

    $vCard->add('X-ISCOMPANY', $contactCompany->contactIsCompany);

    // Mapping contactPhone Parameters
    $contactPhone = $vCardObject->contactPhone;

    foreach($contactPhone as $phoneContainer) {
        $vCard->add('TEL', $phoneContainer->phoneValue, [
            'TYPE' => [
                $phoneContainer->phoneType,
                ($phoneContainer->phoneIsCell === "TRUE") ? 'CELL' : NULL,
                ($phoneContainer->phoneIsFax === "TRUE") ?  'FAX' : NULL,
                ($phoneContainer->phoneIsVoice === "TRUE") ? 'VOICE' : NULL
            ]
        ]);
    }

    // Mapping contactMail Parameters
    $contactMail = $vCardObject->contactMail;

    foreach($contactMail as $mailContainer) {
        $vCard->add('EMAIL', $mailContainer->mailValue, [
            'TYPE' => [
                'INTERNET',
                $mailContainer->mailType
            ]
        ]);
    }

    // Mapping contactAddress Parameters
    $contactAddress = $vCardObject->contactAddress;

    foreach($contactAddress as $addressContainer) {
        $vCard->add('ADR', [
            "",
            "",
            $addressContainer->addressStreet,
            $addressContainer->addressCity,
            $addressContainer->addressRegion,
            $addressContainer->addressPostalCode,
            $addressContainer->addressCountry,
        ], ['TYPE' => $addressContainer->addressType]);
    }

    // Mapping contactInternet Parameters
    $contactInternet = $vCardObject->contactInternet;

    foreach($contactInternet as $internetContainer) {
        $vCard->add('URL', $internetContainer->internetValue, ['TYPE' => $internetContainer->internetType]);
    }

    // Mapping contactAnniversary Parameters
    $contactAnniversary = $vCardObject->contactAnniversary;

    foreach($contactAnniversary as $anniversaryContainer) {
        $dateTime = new \DateTime($anniversaryContainer->anniversaryValue);
        $dateTime = $dateTime->format('Y-m-d\TH:i:s\Z');
        $vCard->add('ANNIVERSARY', $dateTime, ['VALUE' => "DATE"]);
    }

    // Mapping contactNotes Parameter
    $vCard->add('NOTE', $vCardObject->contactNotes);
return $vCard;
}

function mapperCardObject(Sabre\VObject\Component\VCard $vCardData) {
    // @TODO This could be written simpler and cleaner using functions
    // @TODO Implement controls for possible NULL Parameters

    // Mapping UID Parameter
    $vCardObject = new stdClass();
    $vCardObject->UID = "" . $vCardData->UID;

    // Mapping contactDefault Parameters
    $contactDefault = new stdClass();

    $contactDefaultParts = $vCardData->N->getParts();
    $contactDefault->contactLastName = "" . $contactDefaultParts[0];
    $contactDefault->contactFirstName = "" . $contactDefaultParts[1];
    $contactDefault->contactMiddleName = "" . $contactDefaultParts[2];
    $contactDefault->contactPrefix = "" . $contactDefaultParts[3];
    $contactDefault->contactSuffix = "" . $contactDefaultParts[4];

    $vCardObject->contactDefault = $contactDefault;

    // Mapping contactCompany Parameters
    $contactCompany = new stdClass();
    $contactCompany->contactIsCompany = "" . $vCardData->{'X-ISCOMPANY'};

    $contactCompanyParts = $vCardData->ORG->getParts();
    $contactCompany->contactCompany = "" . $contactCompanyParts[0];
    $contactCompany->contactDepartment = "" . $contactCompanyParts[1];

    $contactCompany->contactJobTitle = "" . $vCardData->TITLE;
    $contactCompany->contactJobRole = "" . $vCardData->ROLE;
    $contactCompany->contactBirthDate = "" . $vCardData->BDAY->getDateTime()->format('Y-m-d');

    $vCardObject->contactCompany = $contactCompany;

    // Mapping contactPhone Parameters
    if (isset($vCardData->TEL)) {
        $phoneContainerArray = array();

        $phoneContainerCounter = 0;
        foreach($vCardData->TEL as $phoneContainer) {
            $phoneContainerCounter++;

            $phoneContainerTypeParts = $phoneContainer['TYPE']->getParts();
            $phoneContainerArray['phoneContainer_' . $phoneContainerCounter] = (object)array(
                'phoneType' => "" . $phoneContainerTypeParts[0],
                'phoneIsCell' => (isset($phoneContainerTypeParts[1])) ? "TRUE" : "FALSE",
                'phoneIsFax' => (isset($phoneContainerTypeParts[2])) ? "TRUE" : "FALSE",
                'phoneIsVoice' => (isset($phoneContainerTypeParts[3])) ? "TRUE" : "FALSE",
                'phoneValue' => "" . $phoneContainer
            );
        }

        $vCardObject->contactPhone = (object)$phoneContainerArray;
    } else {
        $vCardObject->contactPhone = NULL;
    }

    // Mapping contactMail Parameters
    $mailContainerArray = array();

    $mailContainerCounter = 0;
    foreach($vCardData->EMAIL as $mailContainer) {
        $mailContainerCounter++;

        $mailContainerTypeParts = $mailContainer['TYPE']->getParts();
        $mailContainerArray['mailContainer_' . $mailContainerCounter] = (object)array(
            'mailType' => "" . $mailContainerTypeParts[1],
            'mailValue' => "" . $mailContainer
        );
    }

    $vCardObject->contactMail = (object)$mailContainerArray;

    // Mapping contactAddress Parameters
    $addressContainerArray = array();

    $addressContainerCounter = 0;
    foreach($vCardData->ADR as $addressContainer) {
        $addressContainerCounter++;

        $addressContainerParts = $addressContainer->getParts();
        $addressContainerArray['addressContainer_' . $addressContainerCounter] = (object)array(
            'addressType' => "" . $addressContainer['TYPE'],
            'addressStreet' => "" . $addressContainerParts[2],
            'addressCity' => "" . $addressContainerParts[3],
            'addressRegion' => "" . $addressContainerParts[4],
            'addressPostalCode' => "" . $addressContainerParts[5],
            'addressCountry' => "" . $addressContainerParts[6],
        );
    }

    $vCardObject->contactAddress = (object)$addressContainerArray;

    // Mapping contactInternet Parameters
    $internetContainerArray = array();

    $internetContainerCounter = 0;
    foreach($vCardData->URL as $internetContainer) {
        $internetContainerCounter++;

        $internetContainerArray['internetContainer_' . $internetContainerCounter] = (object)array(
            'internetType' => "" . $internetContainer['TYPE'],
            'internetValue' => "" . $internetContainer
        );
    }

    $vCardObject->contactInternet = (object)$internetContainerArray;

    // Mapping contactAnniversary Parameters
    $anniversaryContainerArray = array();

    $anniversaryContainerCounter = 0;
    foreach($vCardData->ANNIVERSARY as $anniversaryContainer) {
        // echo($anniversaryContainer);
        $anniversaryContainerCounter++;

        $anniversaryContainerArray['anniversaryContainer_' . $anniversaryContainerCounter] = (object)array(
            'anniversaryValue' => "" . $anniversaryContainer->getDateTime()->format('Y-m-d')
        );
    }

    $vCardObject->contactAnniversary = (object)$anniversaryContainerArray;

    // Mapping contactNotes Parameter
    $vCardObject->contactNotes = "" . $vCardData->NOTE;
return $vCardObject;
}

/*$jsonContents = file_get_contents(TEST_PATH . "Example/exampleContactJSON.json");
echo($jsonContents);
echo("\n===SPACER===\n\n");

$vCardObject = json_decode($jsonContents);
print_r($vCardObject);
echo("\n===SPACER===\n\n");

$vCard = mapperObjectCard($vCardObject);
echo($vCard->serialize());
echo("\n===SPACER===\n\n");

$vCardObject = mapperCardObject($vCard);
print_r($vCardObject);
echo("\n===SPACER===\n\n");

$jsonContents = json_encode($vCardObject);
echo($jsonContents);*/