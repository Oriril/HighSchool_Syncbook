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
    public function insertNewContact() {

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


    }

    public function contactInputValidation() {

    }
}
