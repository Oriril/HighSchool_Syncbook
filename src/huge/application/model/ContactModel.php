<?php

/**
 * Class ContactModel
 *
 * All about contacts.
 */
class ContactModel {

    /**
     * Handles the entire insertion process of a single contact.
     *
     * @return boolean Gives back the success status of the insertion
     */
    public static function buildNewContact() {
        $contactPrefix = Request::post('contactPrefix');
        $contactFirstName = Request::post('contactFirstName');
        $contactMiddleName = Request::post('contactMiddleName');
        $contactLastName = Request::post('contactLastName');
        $contactSuffix = Request::post('contactSuffix');

        $contactIsCompany = isset($_POST['contactIsCompany']) ? 'TRUE' : 'FALSE';
        $contactCompany = Request::post('contactCompany');
        $contactDepartment = Request::post('contactDepartment');
        $contactJobTitle = Request::post('contactJobTitle');
        $contactJobRole = Request::post('contactJobRole');
        $contactBirthDate = Request::post('contactBirthDate');

        $phoneValue = Request::post('phoneValue');

        $mailValue = Request::post('mailValue');

        $addressStreet = Request::post('addressStreet');
        $addressCity = Request::post('addressCity');
        $addressRegion = Request::post('addressRegion');
        $addressPostalCode = Request::post('addressPostalCode');
        $addressCountry = Request::post('addressCountry');

        $arrayToJSON = array(
            'UID' => '',
            'contactDefault' => array(
                'contactPrefix' => $contactPrefix,
                'contactFirstName' => $contactFirstName,
                'contactMiddleName' => $contactMiddleName,
                'contactLastName' => $contactLastName,
                'contactSuffix' => $contactSuffix
            ),
            'contactCompany' => array(
                'contactIsCompany' => $contactIsCompany,
                'contactCompany' => $contactCompany,
                'contactDepartment' => $contactDepartment,
                'contactJobTitle' => $contactJobTitle,
                'contactJobRole' => $contactJobRole,
                'contactBirthDate' => $contactBirthDate
            ),
            'contactPhone' => array(
                'phoneContainer_1' => array(
                    'phoneType' => '',
                    'phoneIsCell' => '',
                    'phoneIsFax' => '',
                    'phoneIsVoice' => '',
                    'phoneValue' => $phoneValue
                )
            ),
            'contactMail' => array(
                'mailContainer_1' => array(
                    'mailType' => '',
                    'mailValue' => $mailValue
                )
            ),
            'contactAddress' => array(
                'addressContainer_1' => array(
                    'addressType' => '',
                    'addressStreet' => $addressStreet,
                    'addressCity' => $addressCity,
                    'addressRegion' => $addressRegion,
                    'addressPostalCode' => $addressPostalCode,
                    'addressCountry' => $addressCountry
                )
            ),
           'contactInternet' => array(
               'internetContainer_1' => array(
                   'internetType' => '',
                   'internetValue' => ''
               )
           ),
           'contactAnniversary' => array(
               'anniversaryContainer_1' => array(
                   'anniversaryValue' => ''
               )
           ),
           'contactNotes' => ''
        );

    return json_encode($arrayToJSON);
    }
}
