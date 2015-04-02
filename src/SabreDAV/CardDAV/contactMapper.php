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
    print_r($vCardObject);

    // @TODO Implement controls for possible NULL Parameters

    $vCard = new Sabre\VObject\Component\VCard([
        'UID' => (isset($vCardObject->UID)) ? $vCardObject->UID : Sabre\DAV\UUIDUtil::getUUID()
    ]);

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
    $vCard->add('BDAY', $contactCompany->contactBirthDate . "T00:00:00Z");

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

    $contactMail = $vCardObject->contactMail;

    foreach($contactMail as $mailContainer) {
        $vCard->add('EMAIL', $mailContainer->mailValue, [
            'TYPE' => [
                'INTERNET',
                $mailContainer->mailType
            ]
        ]);
    }

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

    $contactInternet = $vCardObject->contactInternet;

    foreach($contactInternet as $internetContainer) {
        $vCard->add('URL', $internetContainer->internetValue, ['TYPE' => $internetContainer->internetType]);
    }

    $contactAnniversary = $vCardObject->contactAnniversary;

    foreach($contactAnniversary as $anniversaryContainer) {
        $vCard->add('ANNIVERSARY', $anniversaryContainer->anniversaryValue . "T00:00:00Z", ['VALUE' => "TEXT"]);
    }

    $vCard->add('NOTE', $vCardObject->contactNotes);
return $vCard;
}

function mapperCardObject(Sabre\VObject\Component\VCard $vCardData) {

}

/*$vCardObject = json_decode(file_get_contents(TEST_PATH . "Example/exampleContactJSON.json"));
$vCard = mapperObjectCard($vCardObject);
echo("\n===SPACER===\n\n");
echo($vCard->serialize());*/