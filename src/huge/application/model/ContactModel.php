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

        // If $_POST['UID'] is not NULL this is an edit action.
        if (Request::post('UID') != "") {
            $UID = Request::post('UID');
        }

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
            'UID' => $UID,
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

                ContactModel::printContactList($vCardList);
            }
        }
    }


    /**
     * Function to Retrieve vCard, UID given
     *
     * @param $toGetUID
     * @return bool|stdClass
     */
    public static function vCardRetrieve($toGetUID) {
        try {
            // Appending .vcf for identification purposes
            $toGetUID = $toGetUID . ".vcf";

            // Getting PDO Connection for User
            $connectionPDO = databaseSabreDAVConnectPDO(Session::get('user_name'), new configurationClass());

            // Retrieving AddressBook "Contacts" for User
            $addressBook = cardDAVAddressBookRetrieve($connectionPDO, Session::get('user_name'), "Contacts");

            if ($addressBook !== FALSE) {
                $vCardData = $addressBook->getChild($toGetUID);
                $vCardData = \Sabre\VObject\Reader::read($vCardData->get());
                return mapperCardObject($vCardData);
            } else {throw new Exception();}
        } catch (Exception $exceptionError) {}
        return FALSE;
    }

    public static function printVCard($vCard) {
        $buttons = "<button type=\"button\" class=\"btn btn-success btn-xs\" id=\"editVCard\" data-uid=\"$vCard->UID\">
                        <span class=\"glyphicon glyphicon-edit\" aria-hidden=\"true\"></span> Edit
                    </button>
                    <button type=\"button\" class=\"btn btn-danger btn-xs\" id=\"deleteVCard\" data-uid=\"$vCard->UID\">
                        <span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span> Delete
                     </button>";
        echo "<nav id=\"mainContainerPanel\"><div class=\"well\"><fieldset><legend>" . $vCard->contactDefault->contactFirstName . " " . $vCard->contactDefault->contactLastName .
                " " . $buttons . "</legend>";

        echo "<div class=\"col-sm-2\"><span class=\"label label-primary\">Birthday</span></div>";
        echo "<div class=\"col-sm-10\">" . $vCard->contactCompany->contactBirthDate . "</div>";

        if ($vCard->contactPhone->phoneContainer_1->phoneValue != NULL) {
            echo "<div class=\"col-sm-2\"></div>";
            echo "<div class=\"col-sm-10\"><h4>Phone</h4></div>";
            echo "<div class=\"col-sm-2\"><span class=\"label label-primary\">" . $vCard->contactPhone->phoneContainer_1->phoneType . "</span></div>";
            echo "<div class=\"col-sm-10\">" . $vCard->contactPhone->phoneContainer_1->phoneValue . "</div>";
        }

        echo "</fieldset></div></nav>";
    }

    public static function printEditForm($vCard) {
        //$action = Config::get('URL') . "contact/savechangestocontact";
        echo "<nav id=\"mainContainerPanel\"><div class=\"well\"><form class=\"form-horizontal\" action=\"javascript:void(0);\" method=\"post\"><fieldset><legend>Modify</legend>";

        // first panel
        echo "<div class=\"col-sm-12\">
                <div class=\"panel-default\">
                    <div class=\"panel-body\">
                        <div class=\"form-group\">
                            <label for=\"contactPrefix\" class=\"col-lg-2 control-label\">Prefix</label>
                            <div class=\"col-lg-10\">
                                <input type=\"text\" class=\"form-control\" id=\"contactPrefix\" name=\"contactPrefix\" placeholder=\"Prefix\" value=". $vCard->contactDefault->contactPrefix . ">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"contactFirstName\" class=\"col-lg-2 control-label\">First Name</label>
                            <div class=\"col-lg-10\">
                                <input type=\"text\" class=\"form-control\" id=\"contactFirstName\" name=\"contactFirstName\" placeholder=\"First Name\" value=" . $vCard->contactDefault->contactFirstName ." required />
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"contactMiddleName\" class=\"col-lg-2 control-label\">Middle Name</label>
                            <div class=\"col-lg-10\">
                                <input type=\"text\" class=\"form-control\" id=\"contactMiddleName\" name=\"contactMiddleName\" placeholder=\"Middle Name\" value=" . $vCard->contactDefault->contactMiddleName . ">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"contactLastName\" class=\"col-lg-2 control-label\">Last Name</label>
                            <div class=\"col-lg-10\">
                                <input type=\"text\" class=\"form-control\" id=\"contactLastName\" name=\"contactLastName\" placeholder=\"Last Name\" value=" . $vCard->contactDefault->contactLastName . " required />
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"contactSuffix\" class=\"col-lg-2 control-label\">Suffix</label>
                            <div class=\"col-lg-10\">
                                <input type=\"text\" class=\"form-control\" id=\"contactSuffix\" name=\"contactSuffix\" placeholder=\"Suffix\" value=". $vCard->contactDefault->contactSuffix .">
                            </div>
                        </div>
                    </div>
                </div>
            </div>";

        // company panel
        echo "<div class=\"col-sm-12\">
                <div class=\"panel-default\">
                    <div class=\"panel-body\">
                        <div class=\"form-group\">
                            <div class=\"col-lg-2\"></div>
                            <div class=\"col-lg-10\">
                                <div class=\"checkbox\">
                                    <label>
                                        <input type=\"checkbox\" name=\"contactIsCompany\" value=\"true\">Show as Company
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"contactCompany\" class=\"col-lg-2 control-label\">Company</label>
                            <div class=\"col-lg-10\">
                                <input type=\"text\" class=\"form-control\" id=\"contactCompany\" name=\"contactCompany\" placeholder=\"Company name\" value=" . $vCard->contactCompany->contactCompany .">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"contactDepartment\" class=\"col-lg-2 control-label\">Department</label>
                            <div class=\"col-lg-10\">
                                <input type=\"text\" class=\"form-control\" id=\"contactDepartment\" name=\"contactDepartment\" placeholder=\"Department\" value=" . $vCard->contactCompany->contactDepartment . ">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"contactJobTitle\" class=\"col-lg-2 control-label\">Job title</label>
                            <div class=\"col-lg-10\">
                                <input type=\"text\" class=\"form-control\" id=\"contactJobTitle\" name=\"contactJobTitle\" placeholder=\"Job title\" value=" . $vCard->contactCompany->contactJobTitle .">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"contactJobRole\" class=\"col-lg-2 control-label\">Job role</label>
                            <div class=\"col-lg-10\">
                                <input type=\"text\" class=\"form-control\" id=\"contactJobRole\" name=\"contactJobRole\" placeholder=\"Job role\" value=" . $vCard->contactCompany->contactJobRole . ">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label for=\"contactBirthDate\" class=\"col-lg-2 control-label\">Birthday</label>
                            <div class=\"col-lg-10\">
                                <input type=\"date\" class=\"form-control\" id=\"contactBirthDate\" name=\"contactBirthDate\" value=" . $vCard->contactCompany->contactBirthDate . ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>";

        // phone
        echo "<div class=\"col-sm-12\">
                <div class=\"panel panel-primary\">
                    <div class=\"panel-heading\">Phone</div>
                    <div class=\"panel-body\">
                        <div class=\"form-group\">
                            <div class=\"col-lg-2\">
                                <select name=\"phone1Type\">
                                    <option value=\"home\">Home</option>
                                    <option value=\"work\">Work</option>
                                </select>
                            </div>
                            <div class=\"col-lg-10\">
                                <input type=\"text\" class=\"form-control\" id=\"phoneValue\" name=\"phoneValue\" placeholder=\"Phone number\" value=" . $vCard->contactPhone->phoneContainer_1->phoneValue . ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>";

        // mail
        echo "<div class=\"col-sm-12\">
                <div class=\"panel panel-primary\">
                    <div class=\"panel-heading\">Mail</div>
                    <div class=\"panel-body\">
                        <div class=\"form-group\">
                            <div class=\"col-lg-12\">
                                <input type=\"text\" class=\"form-control\" id=\"mailValue\" name=\"mailValue\" placeholder=\"Mail\" value=" . $vCard->contactMail->mailContainer_1->mailValue . ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>";

        // address
        echo "<div class=\"col-sm-12\">
                <div class=\"panel panel-primary\">
                    <div class=\"panel-heading\">Street Address</div>
                    <div class=\"panel-body\">
                        <div class=\"form-group\">
                            <label for=\"addressStreet\" class=\"col-lg-2 control-label\">Home</label>
                            <div class=\"col-lg-10\">
                                <input type=\"text\" class=\"form-control\" id=\"addressStreet\" name=\"addressStreet\" placeholder=\"Street\" value=" . $vCard->contactAddress->addressContainer_1->addressStreet . ">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <div class=\"col-lg-2\"></div>
                            <div class=\"col-lg-10\">
                                <input type=\"text\" class=\"form-control\" id=\"addressCity\" name=\"addressCity\" placeholder=\"City\" value=" . $vCard->contactAddress->addressContainer_1->addressCity . ">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <div class=\"col-lg-2\"></div>
                            <div class=\"col-lg-10\">
                                <input type=\"text\" class=\"form-control\" id=\"addressRegion\" name=\"addressRegion\" placeholder=\"Region\" value=" . $vCard->contactAddress->addressContainer_1->addressRegion .">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <div class=\"col-lg-2\"></div>
                            <div class=\"col-lg-10\">
                                <input type=\"text\" class=\"form-control\" id=\"addressPostalCode\" name=\"addressPostalCode\" placeholder=\"Postal code\" value=" . $vCard->contactAddress->addressContainer_1->addressPostalCode . ">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <div class=\"col-lg-2\"></div>
                            <div class=\"col-lg-10\">
                                <input type=\"text\" class=\"form-control\" id=\"addressCountry\" name=\"addressCountry\" placeholder=\"Country\" value=" . $vCard->contactAddress->addressContainer_1->addressCountry . ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>";

        // confirm buttons
        $index = Config::get('URL') . "dashboard/index";

        echo "<div class=\"form-group\">
                <div class=\"col-sm-4\">
                    <input type=\"submit\" class=\"btn btn-success btn-lg\" id=\"btn_save_changes\" data-uid=" . $vCard->UID . " value=\"Save\">
                    <a href=\"$index\" class=\"btn btn-danger btn-lg\">Cancel</a>
            </div>
            </div>";

        echo "</fieldset></form></div></nav>";
    }

    // Example of Usage with error_log, for testing purpose.
    //error_log(print_r(ContactModel::vCardRetrieve("ff2ba66e-f2a5-4ac0-897c-f322a9f2ede4.vcf"), TRUE));
}
