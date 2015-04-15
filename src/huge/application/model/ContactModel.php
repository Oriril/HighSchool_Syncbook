<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationInclude.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationClass.php");

require_once(SOURCE_PATH . "SabreDAV/CardDAV/cardDAVManagement.php");
require_once(SOURCE_PATH . "SabreDAV/CardDAV/contactMapper.php");
require_once(SOURCE_PATH . "SabreDAV/CardDAV/vCardManagement.php");

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

    public static function getCardsUID() {
        try {
            $database = DatabaseFactory::getFactory()->getConnection();

            $database->exec("USE sabredav_" . strtolower(Session::get('user_name')) . ";");
            $querySQL = "SELECT cards.uri
                         FROM cards;";
            $foundCards = $database->query($querySQL);

            $returnCards = array();

            foreach($foundCards as $singleCard) {
                $returnCards[] = $singleCard->uri;
            }

            return $returnCards;
        } catch (Exception $exceptionError) {}

        return FALSE;
    }

    public static function printContactList($vCardList) {
        error_log(print_r($vCardList, TRUE));

        foreach ($vCardList as $UID => $arrayInfo) {
            $firstName = $arrayInfo['contactFirstName'];
            $lastName = $arrayInfo['contactLastName'];

            echo("<li class=\"list-group-item\" data-uid=\"$UID\">
                            <div class=\"col-xs-12 col-sm-3\">
                                <img src=\"http://api.randomuser.me/portraits/men/97.jpg\" alt=\"Seth Frazier\" class=\"img-responsive img-circle\" />
                            </div>
                            <div class=\"col-xs-12 col-sm-9\">
                                <span class=\"name\">$firstName $lastName</span><br/>
                            </div>
                            <div class=\"clearfix\"></div>
                        </li>");
        }
    }

    public static function getContactListForAddressBook() {
        $uriList = ContactModel::getCardsUID();

        if ($uriList !== FALSE) {
            // Getting PDO Connection for User
            $connectionPDO = databaseSabreDAVConnectPDO(Session::get('user_name'), new configurationClass());

            // Retrieving AddressBook "Contacts" for User
            $addressBook = cardDAVAddressBookRetrieve($connectionPDO, Session::get('user_name'), "Contacts");

            if ($addressBook !== FALSE) {
                $vCardList = vCardListRetrieve($addressBook, $uriList);
                // error_log(print_r($vCardList, TRUE));

                /*$vCardList = array(
                    '345' => array(
                        'FirstName' => '',
                        'LastName' => ''
                    ),
                    '346' => array(
                        'FirstName' => '',
                        'LastName' => ''
                    ),
                    '347' => array(
                        'FirstName' => '',
                        'LastName' => ''
                    )
                );*/

                ContactModel::printContactList($vCardList);
            }
        }

    }
}
