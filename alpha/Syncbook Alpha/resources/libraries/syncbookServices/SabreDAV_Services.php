<?php
    use Sabre\VObject;
    include '../sabredav/vendor/autoload.php';
    
    /*========== ||||| ===== SabreDAV Services ===== ||||| ==========*/
    
    /**
     * Function to Create a NewUser in the Server
     * 
     * @param string $auxiliarUsername
     * @param string $auxiliarPassword
     * @param string $auxiliarEMail
     * @return boolean if(==true) {Successfull User Creation} else {Unsuccessfull User Creation}
     */
    function buildUserSabreDAV($auxiliarUsername, $auxiliarPassword, $auxiliarEMail, $baseUri)
    {
        if(R::findOne('users', 'username = ?', [$auxiliarUsername])==NULL) 
        {
            /*Build a SabreDAV User*/
            
            // Adding the User to "users" Table
            $user = R::dispense('users');
            $user->username = $auxiliarUsername;
            $user->digesta1 = md5($auxiliarUsername.":SabreDAV:".$auxiliarPassword);
            $id = R::store($user);
            
            // Adding the User to "principals" Table
            $principal = R::dispense('principals');
            $principal->displayname = $auxiliarUsername;
            $principal->email = $auxiliarEMail;
            $principal->uri = "principals/".$auxiliarUsername;
            $principal->vcardurl = NULL;
            $id = R::store($principal);
            
            // Adding read permission for the User
            $principal = R::dispense('principals');
            $principal->displayname = NULL;
            $principal->email = NULL;
            $principal->uri = "principals/".$auxiliarUsername."/calendar-proxy-read";
            $principal->vcardurl = NULL;
            $id = R::store($principal);
            
            // Adding write permission for the User
            $principal = R::dispense('principals');
            $principal->displayname = NULL;
            $principal->email = NULL;
            $principal->uri = "principals/".$auxiliarUsername."/calendar-proxy-write";
            $principal->vcardurl = NULL;
            $id = R::store($principal);
            
            if(userSuccessfullAuthentication($baseUri, $auxiliarUsername, $auxiliarPassword)) {return true;} else {return false;}
        } else {
            echo("<B>Username : -|".$auxiliarUsername."|- Already Exits</B>");
            return false;
        }
    }
    
    /**
     * Function to Authenticate an User
     * 
     * @param string $baseUri (Example : http://127.0.0.1/htdocs/sabredav/addressbookserver.php/)
     * @param string $auxiliarUsername
     * @param string $auxiliarPassword
     * @return boolean if(==true) {Successfull Authentication} else {Unsuccessfull Authentication}
     */
    function userSuccessfullAuthentication($baseUri, $auxiliarUsername, $auxiliarPassword)
    {
        // Building the Settings for Server Connection
        $connectionSettings = array('baseUri' => $baseUri, 'userName' => $auxiliarUsername, 'password' => $auxiliarPassword);
        // Building the Client with the Settings builded above
        $client = new Sabre\DAV\Client($connectionSettings);
        // Trying a request with the client setted above
        $response = $client->request('GET');
        // if(Successfull Request)else(Unsuccessfull Request)
        if($response['statusCode']==200) {return true;} else {return false;}
    }
    
    /**
     * Function to Connect to Database with PDO
     * 
     * @param string $pdoHostName
     * @param string $dataBaseUsername
     * @param string $dataBasePassword
     * @return \PDO
     */
    function dataBasePDOConnection($pdoHostName, $dataBaseUsername, $dataBasePassword)
    {
        // DataBase connection with PDO Method
        $connectionPDO = new PDO('mysql:dbname=sabredav;hostname='.$pdoHostName, $dataBaseUsername, $dataBasePassword);
    return $connectionPDO;
    }
    
    /*========== ||||| ===== CardDAV Services ===== ||||| ==========*/
    
    /**
     * Function to Build an AddressBook for an User
     * 
     * @param \PDO $connectionPDO
     * @param string $principalUri
     * @param string $addressBookUri
     * @param string $addressBookDisplayName
     */
    function buildAddressBook($connectionPDO, $principalUri, $addressBookUri, $addressBookDisplayName)
    {
        // Building a PDO Object
        $mainObject = new Sabre\CardDAV\Backend\PDO($connectionPDO);
        // Create AddressBook Operation
        $mainObject->createAddressBook("principals/".$principalUri, $addressBookUri, array('{DAV:}displayname' => $addressBookDisplayName));
    }
    
    /**
     * Function to Build an AddressBooks List Object
     * 
     * @param \PDO $connectionPDO
     * @param string $principalUri
     * @return \Sabre\CardDAV\Addressbook\array()
     */
    function buildAddressBooksList($connectionPDO, $principalUri) {
        // Building a Principals List (Uncomment if needed)
        //$principalBackend = new Sabre\DAVACL\PrincipalBackend\PDO($connectionPDO);
        //$principalsList = $principalBackend->getPrincipalsByPrefix('principals');
        
        // Building a PDO Object
        $mainObject = new Sabre\CardDAV\Backend\PDO($connectionPDO);
        // Returning a Principal AddressBooks
        return $mainObject->getAddressBooksForUser("principals/".$principalUri);
    }
    
    /**
     * Function to Retrive a single AddressBook from an AddressBooks List
     * 
     * @param \PDO $connectionPDO
     * @param \Sabre\CardDAV\Addressbook\array() $addressBooksList
     * @param string $toFindAddressBookUri
     * @return null|\Sabre\CardDAV\AddressBook
     */
    function retriveAddressBookFromList($connectionPDO, $addressBooksList, $toFindAddressBookUri)
    {
        for($i=0; $i<count($addressBooksList); $i++)
        {
            // Save a Single AddressBook from List to an Auxiliar Array
            $auxiliarSingleAddressBook = $addressBooksList[$i];
            // if(Object where we arrived == Object that we have to Find)
            if($auxiliarSingleAddressBook['uri'] == $toFindAddressBookUri)
            {
                // Building a PDO Object
                $mainObject = new Sabre\CardDAV\Backend\PDO($connectionPDO);
                // Returnig the searched AddressBook
                return new Sabre\CardDAV\AddressBook($mainObject, $auxiliarSingleAddressBook);
            }
        }
    return NULL;
    }
    
    /**
     * Funtion to Add a vCard to an AddressBook
     * 
     * @param \Sabre\CardDAV\AddressBook $addressBookMain
     * @param \Sabre\VObject\VCard $vCardData
     * @return string if(!=NULL) {Successfull Adding Operation} else {Unsuccessfull Adding Operation}
     */
    function addVCard($addressBookMain, $vCardData) 
    {
        // Generating an UID for the vCard and inserting it to the vCard itself
        if($vCardData->UID=="") {$vCardData->UID = Sabre\DAV\UUIDUtil::getUUID();}
        // Saving the vCard in the DataBase
    return $addressBookMain->createFile($vCardData->UID.".vcf", $vCardData->serialize());
    }
    
    /**
     * Funtion to Delete a vCard from an AddressBook
     * 
     * @param \Sabre\CardDAV\AddressBook $addressBookMain
     * @param string $vCardUri
     * @return boolean if(==true) {Successfull Deleting Operation} else {Unsuccessfull Deleting Operation}
     */
    function deleteVCard($addressBookMain, $vCardUri)
    {
        // Appending the FileType to the Uri
        $vCardUri = $vCardUri.".vcf";
        $vCardsList = $addressBookMain->getChildren();
        
        for($i=0; $i<count($vCardsList); $i++)
        {
            // Saving a Single vCard
            $auxiliarVCard = $vCardsList[$i];
            // Getting the vCard Uri
            $auxiliarUri = $auxiliarVCard->getName();
            
            if($auxiliarUri == $vCardUri)
            {
                // Getting the vCard itself as an Object
                $auxiliarVCard = $addressBookMain->getChild($auxiliarUri);
                // Deleting the vCard
                $auxiliarVCard->delete();
                return true;
            }
        }
    return false;
    }
    
    /**
     * Funtion to Update a vCard from an AddressBook
     * 
     * @param \Sabre\CardDAV\AddressBook $addressBookMain
     * @param string $vCardUri
     * @param \Sabre\VObject\VCard $vCardData
     * @return boolean if(==true) {Successfull Updating Operation} else {Unsuccessfull Updating Operation}
     */
    function updateVCard($addressBookMain, $vCardUri, $vCardData)
    {
        // Appending the FileType to the Uri
        $vCardUri = $vCardUri.".vcf";
        $vCardsList = $addressBookMain->getChildren();
        
        for($i=0; $i<count($vCardsList); $i++)
        {
            // Saving a Single vCard
            $auxiliarVCard = $vCardsList[$i];
            // Getting the vCard Uri
            $auxiliarUri = $auxiliarVCard->getName();
            
            if($auxiliarUri == $vCardUri)
            {
                // Getting the vCard itself as an Object
                $auxiliarVCard = $addressBookMain->getChild($auxiliarUri);
                // Forming the vCard String
                $auxiliarVCardString = $auxiliarVCard->get();
                // Parsing the vCard String
                $parsedVCard = VObject\Reader::read($auxiliarVCardString);
                // Setting the New vCard UID equals to the old one
                $vCardData->UID = $parsedVCard->UID;
                // Updating the vCard
                $auxiliarVCard->put($vCardData->serialize());
                return true;
            }
        }
    return false; 
    }
    
    /**
     * Function for Getting all the vCards of an AddressBook
     * 
     * @param \Sabre\CardDAV\AddressBook $addressBookMain
     * @return \Sabre\VObject\array() if(!=NULL) {Successfull CardsList Build} else {Unsuccessfull CardsList Build}
     */
    function getAddressBookCards($addressBookMain)
    {
        // Return a vCardsList for a Single Address Book
        $vCardsList = $addressBookMain->getChildren();
        
        // Building an Array() for return values
        $returnArray = array();
        for($i=0; $i<count($vCardsList); $i++)
        {
            // Saving a Single vCard
            $auxiliarVCard = $vCardsList[$i];
            // Getting the vCard Uri
            $auxiliarUri = $auxiliarVCard->getName();
            // Getting the vCard itself as an Object
            $auxiliarVCard = $addressBookMain->getChild($auxiliarUri);
            // Forming the vCard String
            $auxiliarVCard = $auxiliarVCard->get();
            // Parsing the vCard String
            $parsedVCard = VObject\Reader::read($auxiliarVCard);
            // Adding the Parsed vCard to the Returning Array()
            $returnArray[]=$parsedVCard;
        }
    return $returnArray;
    }
    
    /**
     * Function to Map a JSON to a vCard, specific for the choosen Interface
     * 
     * @param Object $jSONObject
     * @return \Sabre\VObject\Component\VCard
     */
    function mappingJSONVCardObject($jSONObject)
    {
        if($jSONObject->contactImage != '') {
            try{$base64Encode = base64_encode(file_get_contents($jSONObject->contactImage));} catch(Exception $error) {$base64Encode = '';}
        } else {
            $base64Encode = '';
        }
        
        $mappedVCard = new VObject\Component\VCard([
            'UID' => $jSONObject->UUID,
            'X-CONTACTCOLOR' => $jSONObject->contactColor,
            'X-CONTACTGROUP' => $jSONObject->contactGroup,
            'X-CONTACTTYPE' => $jSONObject->contactType,
            'PHOTO;ENCODING=B;TYPE=JPEG' => $base64Encode,
            'N'   => [''.$jSONObject->contactSurname, ''.$jSONObject->contactName, '', '', ''],
            'FN'  => $jSONObject->contactName.' '.$jSONObject->contactSurname,
            'NICKNAME' => $jSONObject->contactUsername,
            'EMAIL' => $jSONObject->contactEMail,
            'TEL;TYPE=PHONE NUMBER;TYPE=VOICE' => $jSONObject->contactPhoneNumber,
            'TEL;TYPE=MOBILE NUMBER;TYPE=VOICE' => $jSONObject->contactMobileNumber,
            'TEL;TYPE=FAX' => $jSONObject->contactFax,
            'ADR' => ['', $jSONObject->contactAddress, '', '', '', ''],
            'URL' => $jSONObject->contactWeb,
            'X-CONTACTPARTITAIVA' => $jSONObject->contactPartitaIva,
            'X-CONTACTCODICEFISCALE' => $jSONObject->contactCodiceFiscale,
            'X-FACEBOOK' => $jSONObject->contactFacebook,
            'X-TWITTER' => $jSONObject->contactTwitter,
            'X-INSTAGRAM' => $jSONObject->contactInstagram,
            'X-GOOGLE' => $jSONObject->contactGoogle,
            'X-LINKEDIN' => $jSONObject->contactLinkedin,
            'X-SKYPE' => $jSONObject->contactSkype
        ]);
    return $mappedVCard;
    }
    
    /**
     * Function to get a Specific Telephone type from a vCard
     * 
     * @param \Sabre\VObject\Component\VCard $vCardObject
     * @param string $telephoneType
     * @return string
     */
    function getTelephoneType($vCardObject, $telephoneType)
    {
        try {
            if(isset($vCardObject->TEL)) {
                foreach($vCardObject->TEL as $singularTelephone)
                {
                    $auxiliar = $singularTelephone['TYPE'];
                    foreach($auxiliar as $singularType)
                    {
                        if($singularType == $telephoneType) {return "".$singularTelephone;}
                    }
                }
            }
        } catch (Exception $error) {}
    return "";
    }
    
    /**
     * Function to Map a vCard to an Array(), specific for the choosen Interface
     * 
     * @param \Sabre\VObject\Component\VCard $vCardObject
     * @return array()
     */
    function mappingVCardObject($vCardObject)
    {
        $mappedArray = array(
            'UUID' => (isset($vCardObject->UID)) ? "".$vCardObject->UID : "",
            'contactColor' => (isset($vCardObject->{'X-CONTACTCOLOR'})) ? "".$vCardObject->{'X-CONTACTCOLOR'} : "",
            'contactGroup' => (isset($vCardObject->{'X-CONTACTGROUP'})) ? "".$vCardObject->{'X-CONTACTGROUP'} : "",
            'contactType' => (isset($vCardObject->{'X-CONTACTTYPE'})) ? "".$vCardObject->{'X-CONTACTTYPE'} : "",
            'contactImage' => (isset($vCardObject->{'PHOTO;ENCODING=B;TYPE=JPEG'})) ? "".$vCardObject->{'PHOTO;ENCODING=B;TYPE=JPEG'} : "",
            'contactSurname' => (isset($vCardObject->N)) ? "".$vCardObject->N->getParts()[0] : "",
            'contactUsername' => (isset($vCardObject->NICKNAME)) ? "".$vCardObject->NICKNAME : "",
            'contactName' => (isset($vCardObject->N)) ? "".$vCardObject->N->getParts()[1] : "",
            'contactEMail' => (isset($vCardObject->EMAIL)) ? "".$vCardObject->EMAIL : "",
            'contactPhoneNumber' => getTelephoneType($vCardObject, 'PHONE NUMBER'),
            'contactMobileNumber' => getTelephoneType($vCardObject, 'MOBILE NUMBER'),
            'contactFax' => getTelephoneType($vCardObject, 'FAX'),
            'contactAddress' => (isset($vCardObject->ADR)) ? "".$vCardObject->ADR->getParts()[1] : "",
            'contactWeb' => (isset($vCardObject->URL)) ? "".$vCardObject->URL : "",
            'contactPartitaIva' => (isset($vCardObject->{'X-CONTACTPARTITAIVA'})) ? "".$vCardObject->{'X-CONTACTPARTITAIVA'} : "",
            'contactCodiceFiscale' => (isset($vCardObject->{'X-CONTACTCODICEFISCALE'})) ? "".$vCardObject->{'X-CONTACTCODICEFISCALE'} : "",
            'contactFacebook' => (isset($vCardObject->{'X-FACEBOOK'})) ? "".$vCardObject->{'X-FACEBOOK'} : "",
            'contactTwitter' => (isset($vCardObject->{'X-TWITTER'})) ? "".$vCardObject->{'X-TWITTER'} : "",
            'contactInstagram' => (isset($vCardObject->{'X-INSTAGRAM'})) ? "".$vCardObject->{'X-INSTAGRAM'} : "",
            'contactGoogle' => (isset($vCardObject->{'X-GOOGLE'})) ? "".$vCardObject->{'X-GOOGLE'} : "",
            'contactLinkedin' => (isset($vCardObject->{'X-LINKEDIN'})) ? "".$vCardObject->{'X-LINKEDIN'} : "",
            'contactSkype' => (isset($vCardObject->{'X-SKYPE'})) ? "".$vCardObject->{'X-SKYPE'} : ""
        );
    return $mappedArray;
    }
    
    /*========== ||||| ===== CalDAV Services ===== ||||| ==========*/
    
    /**
     * Function to Build a Calendar for an User
     * 
     * @param \PDO $connectionPDO
     * @param string $principalUri
     * @param string $calendarUri
     * @param string $supportedCalendarComponentSetAlpha
     * @param string $supportedCalendarComponentSetBeta
     * @return int if(!=0) {Successfull Calendar Adding Operation} else {Unsuccessfull Calendar Adding Operation}
     */
    function buildCalendar($connectionPDO, $principalUri, $calendarUri, $supportedCalendarComponentSetAlpha, $supportedCalendarComponentSetBeta)
    {   
        // Formatting the two SupportedCalendarComponentSet
        $supportedCalendarComponentSet = $supportedCalendarComponentSetAlpha.','.$supportedCalendarComponentSetBeta;
        // Building a PDO Object
        $mainObject = new Sabre\CalDAV\Backend\PDO($connectionPDO);
        // Create Calendar Operation
        $calendarID = $mainObject->createCalendar("principals/".$principalUri, $calendarUri, array('sccs' => $supportedCalendarComponentSet));
    
    return $calendarID;
    }
    
    /**
     * Function to Build a Calendars List Object
     * 
     * @param \PDO $connectionPDO
     * @param string $principalUri
     * @return \Sabre\CalDAV\Calendar\array()
     */
    function buildCalendarsList($connectionPDO, $principalUri) {
        // Building a Principals List (Uncomment if needed)
        // $principalBackend = new Sabre\DAVACL\PrincipalBackend\PDO($connectionPDO);
        // $principalsList = $principalBackend->getPrincipalsByPrefix('principals');
   
        // Building a PDO Object
        $mainObject = new Sabre\CalDAV\Backend\PDO($connectionPDO);
        // Returning a Principal AddressBooks
        return $mainObject->getCalendarsForUser("principals/".$principalUri);
    }
    
    /**
     * Function to Retrive a single Calendar from a Calendars List
     * 
     * @param \PDO $connectionPDO
     * @param \Sabre\CalDAV\Calendar\array() $calendarsList
     * @param string $toFindCalendarUri
     * @return \Sabre\CalDAV\Calendar|null
     */
    function retriveCalendarFromList($connectionPDO, $calendarsList, $toFindCalendarUri)
    {
        for($i=0; $i<count($calendarsList); $i++)
        {
            // Save a Single Calendar from List to an Auxiliar Array
            $auxiliarSingleCalendar = $calendarsList[$i];
            // if(Object where we arrived == Object that we have to Find)
            if($auxiliarSingleCalendar['uri'] == $toFindCalendarUri)
            {
                // Building a PDO Object
                $mainObject = new Sabre\CalDAV\Backend\PDO($connectionPDO);
                // Returnig the searched Calendar
                return new Sabre\CalDAV\Calendar($mainObject, $auxiliarSingleCalendar);
            }
        }
    return NULL;
    }
    
    /**
     * Funtion to Add a vCalendar to a Calendar
     * 
     * @param \Sabre\CalDAV\Calendar| $calendarMain
     * @param \Sabre\VObject\VCalendar\ $vCalendarData
     */
    function addVCalendar($calendarMain, $vCalendarData) 
    {
        // Generating an UID for the vCalendar and inserting it to the vCalendar itself
        if($vCalendarData->VEVENT->UID == "") {$vCalendarData->VEVENT->UID = Sabre\DAV\UUIDUtil::getUUID();}
        // Saving the vCalendar in the DataBase
        $calendarMain->createFile($vCalendarData->VEVENT->UID.".ics", $vCalendarData->serialize());
    }
    
    /**
     * Funtion to Delete a vCalendar to a Calendar
     * 
     * @param \Sabre\CalDAV\Calendar| $calendarMain
     * @param string $vCalendarUri
     * @return boolean if(==true) {Successfull Deleting Operation} else {Unsuccessfull Deleting Operation}
     */
    function deleteVCalendar($calendarMain, $vCalendarUri)
    {
        // Appending the FileType to the Uri
        $vCalendarUri = $vCalendarUri.".ics";
        $vCalendarsList = $calendarMain->getChildren();
        
        for($i=0; $i<count($vCalendarsList); $i++)
        {
            // Saving a Single vCalendar
            $auxiliarVCalendar = $vCalendarsList[$i];
            // Getting the vCalendar Uri
            $auxiliarUri = $auxiliarVCalendar->getName();
            
            if($auxiliarUri == $vCalendarUri)
            {
                // Getting the vCalendar itself as an Object
                $auxiliarVCalendar = $calendarMain->getChild($auxiliarUri);
                // Deleting the vCalendar
                $auxiliarVCalendar->delete();
                return true;
            }
        }
    return false;
    }
    
    /**
     * Funtion to Update a vCalendar from a Calendar
     * 
     * @param \Sabre\CalDAV\Calendar| $calendarMain
     * @param string $vCalendarUri
     * @param \Sabre\VObject\VCalendar\ $vCalendarData
     * @return if(==true) {Successfull Updating Operation} else {Unsuccessfull Updating Operation}
     */
    function updateVCalendar($calendarMain, $vCalendarUri, $vCalendarData)
    {
        // Appending the FileType to the Uri
        $vCalendarUri = $vCalendarUri.".ics";
        $vCalendarsList = $calendarMain->getChildren();
        
        for($i=0; $i<count($vCalendarsList); $i++)
        {
            // Saving a Single vCalendar
            $auxiliarVCalendar = $vCalendarsList[$i];
            // Getting the vCalendar Uri
            $auxiliarUri = $auxiliarVCalendar->getName();
            
            if($auxiliarUri == $vCalendarUri)
            {
                // Getting the vCalendar itself as an Object
                $auxiliarVCalendar = $calendarMain->getChild($auxiliarUri);
                // Forming the vCalendar String
                $auxiliarVCalendarString = $auxiliarVCalendar->get();
                // Parsing the vCalendar String
                $parsedVCalendar = VObject\Reader::read($auxiliarVCalendarString);
                // Setting the New vCalendar->VEVENT->UID equals to the old one
                $vCalendarData->VEVENT->UID = $parsedVCalendar->VEVENT->UID;
                // Updating the vCalendar
                $auxiliarVCalendar->put($vCalendarData->serialize());
                return true;
            }
        }
    return false; 
    }
    
    /**
     * Function for Getting all the vCalendars of a Calendar
     * 
     * @param \Sabre\CalDAV\Calendar| $calendarMain
     * @return \Sabre\VObject\VCalendar\array() if(!=NULL) {Successfull CardsList Build} else {Unsuccessfull CardsList Build}
     */
    function getCalendarVCalendars($calendarMain)
    {
        // Return a vCalendars for a Single Address Book
        $vCalendarsList = $calendarMain->getChildren();
        
        // Building an Array() for return values
        $returnArray = array();
        for($i=0; $i<count($vCalendarsList); $i++)
        {
            // Saving a Single vCalendar
            $auxiliarVCalendar = $vCalendarsList[$i];
            // Getting the vCalendar Uri
            $auxiliarUri = $auxiliarVCalendar->getName();
            // Getting the vCalendar itself as an Object
            $auxiliarVCalendar = $calendarMain->getChild($auxiliarUri);
            // Forming the vCalendar String
            $auxiliarVCalendar = $auxiliarVCalendar->get();
            // Parsing the vCalendar String
            $parsedVCalendar = VObject\Reader::read($auxiliarVCalendar);
            // Adding the Parsed vCalendar to the Returning Array()
            $returnArray[]=$parsedVCalendar;
        }
    return $returnArray;
    }
    
    /**
     * Function to Map a JSON to a vCalendar, specific for the choosen Interface
     * 
     * @param Object $jSONObject
     * @param string $clientTimeZone
     * @return \Sabre\VObject\Component\VCalendar
     */
    function mappingJSONVCalendarObject($jSONObject, $clientTimeZone = 'UTC')
    {
        $eventStart = new \DateTime($jSONObject->eventStart);
        $eventStartTime = new \DateTime($jSONObject->eventStartTime);
        
        $eventEnd = new \DateTime($jSONObject->eventEnd);
        $eventEndTime = new \DateTime($jSONObject->eventEndTime);
        
        $mappedVCalendar = new VObject\Component\VCalendar();
        $mappedVCalendar->add('VEVENT', [
            'UID' => $jSONObject->UUID,
            'SUMMARY' => $jSONObject->eventName,
            'DTSTART' => new \DateTime($eventStart->format('Y/m/d').' '.$eventStartTime->format('H:i:s'), new \DateTimeZone($clientTimeZone)),
            'DTEND' => new \DateTime($eventEnd->format('Y/m/d').' '.$eventEndTime->format('H:i:s'), new \DateTimeZone($clientTimeZone)),
            'DESCRIPTION' => $jSONObject->eventDescription,
            'LOCATION' => $jSONObject->eventLocation,
            'URL;VALUE=URI' => $jSONObject->eventUrl,
            'X-EVENTTYPE' => $jSONObject->eventType
        ]);
    return $mappedVCalendar;
    }
    
    /**
     * Function to Map a vCalendar to a JSON, specific for the choosen Interface
     * 
     * @param Object $vCalendarObject
     * @return array()
     */
    function mappingVCalendarObject($vCalendarObject)
    {
        $mappedJSON = array(
            'UUID' => (isset($vCalendarObject->VEVENT->UID)) ? "".$vCalendarObject->VEVENT->UID : "",
            'eventDate' => (isset($vCalendarObject->VEVENT->DTSTART)) ? "".$vCalendarObject->VEVENT->DTSTART->getDateTime()->format(\DateTime::W3C) : "",
            'eventName' => (isset($vCalendarObject->VEVENT->SUMMARY)) ? "".$vCalendarObject->VEVENT->SUMMARY : "",
            'eventStart' => (isset($vCalendarObject->VEVENT->DTSTART)) ? "".$vCalendarObject->VEVENT->DTSTART->getDateTime()->format(\DateTime::W3C) : "",
            'eventStartTime' => (isset($vCalendarObject->VEVENT->DTSTART)) ? "".$vCalendarObject->VEVENT->DTSTART->getDateTime()->format('H:i') : "",
            'eventEnd' => (isset($vCalendarObject->VEVENT->DTEND)) ? "".$vCalendarObject->VEVENT->DTEND->getDateTime()->format(\DateTime::W3C) : "",
            'eventEndTime' => (isset($vCalendarObject->VEVENT->DTEND)) ? "".$vCalendarObject->VEVENT->DTEND->getDateTime()->format('H:i') : "",
            'eventDescription' => (isset($vCalendarObject->VEVENT->DESCRIPTION)) ? "".$vCalendarObject->VEVENT->DESCRIPTION : "",
            'eventLocation' => (isset($vCalendarObject->VEVENT->LOCATION)) ? "".$vCalendarObject->VEVENT->LOCATION : "",
            'eventUrl' => (isset($vCalendarObject->VEVENT->URL)) ? "".$vCalendarObject->VEVENT->URL : "",
            'eventType' => (isset($vCalendarObject->VEVENT->{'X-EVENTTYPE'})) ? "".$vCalendarObject->VEVENT->{'X-EVENTTYPE'} : "",
        );
    return $mappedJSON;
    }
?>