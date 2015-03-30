<?php
    require_once './SabreDAV_Services.php';

    /*========== ||||| ===== Setup Management ===== ||||| ==========*/

    /**
     * Function to Prepare an AddressBook
     * 
     * @param string $principalUsernamne
     * @param string $principalAddressbook
     * @return boolean || \Sabre\CardDAV\Addressbook
     */
    function setupProcedureContacts($principalUsernamne, $principalAddressbook)
    {
        $connectionPDO = dataBasePDOConnection('127.0.0.1', 'federico', 'password');
        
        $addressBooksList = buildAddressBooksList($connectionPDO, $principalUsernamne);
        if(count($addressBooksList) != 0) {
            $addressBookMain = retriveAddressBookFromList($connectionPDO, $addressBooksList, $principalAddressbook);
            
            if(count($addressBookMain) != 0) {
                return $addressBookMain;
            } else {
                errorProcedure(500, false, "Cannot Retrive AddressBookMain");
                die();
            }
        } else {
            errorProcedure(500, false, "Cannot retrive AddressBooksList");
            die();
        }
    return false;
    }
    
    /**
     * Function to Prepare a Calendar
     * 
     * @param string $principalUsernamne
     * @param string $principalCalendar
     * @return boolean || \Sabre\CardDAV\Calendar\
     */
    function setupProcedureEvents($principalUsernamne, $principalCalendar)
    {
        $connectionPDO = dataBasePDOConnection('127.0.0.1', 'federico', 'password');
        
        $calendarsList = buildCalendarsList($connectionPDO, $principalUsernamne);
        if(count($calendarsList) != 0) {
            $calendarMain = retriveCalendarFromList($connectionPDO, $calendarsList, $principalCalendar);
            
            if(count($calendarMain) != 0) {
                return $calendarMain;
            } else {
                errorProcedure(500, false, "Cannot Retrive CalendarMain");
                die();
            }
        } else {
            errorProcedure(500, false, "Cannot retrive CalendarsList");
            die();
        }
    return false;
    }
    
    /*========== ||||| ===== Error Management ===== ||||| ==========*/
    
    /**
     * Function to Return a JSON for a specific Error Management
     * 
     * @param int $errorCode
     * @param boolean $errorSuccess
     * @param string $errorDescription
     * @param string $errorRoot
     */
    function errorProcedure($errorCode, $errorSuccess, $errorDescription, $errorRoot = "contacts")
    {
        $returningError = new stdClass();
        $returningError->errorCode = $errorCode;
        $returningError->errorSuccess = $errorSuccess;
        $returningError->errorDescription = $errorDescription;
    echo("{\"".$errorRoot."\":".json_encode($returningError)."}");
    }
    
    /*========== ||||| ===== Mapping Management ===== ||||| ==========*/
    
    /**
     * Function to transform an Event array() in a Bean
     * 
     * @param array() $toMapArray
     * @return RedBeanPHP\OODBBean
     */
    function mappingArrayContact($toMapArray)
    {
        $redBean = R::dispense('contacts');
        foreach($toMapArray as $key=>$value)
        {
            if($key != "errorCode" && $key != "errorSuccess" && $key != "errorDescription") {
                $redBean[strtolower($key)] = $value;
            }
        }
    return $redBean;
    }
    
    /**
     * Function to trasform a Contact array() in a Bean
     * 
     * @param array() $toMapArray
     * @return RedBeanPHP\OODBBean
     */
    function mappingArrayEvent($toMapArray)
    {
        $redBean = R::dispense('events');
        
        foreach($toMapArray as $key=>$value) {
            if(
                    $key != "eventStart" && 
                    $key != "eventStartTime" && 
                    $key != "eventEnd" && 
                    $key != "eventEndTime" && 
                    $key != "errorCode" && 
                    $key != "errorSuccess" && 
                    $key != "errorDescription") 
                {$redBean[strtolower($key)] = $value;}
        }
        
        $redBean['eventstart'] = (new \DateTime((new \DateTime($toMapArray['eventStart']))->format('Y/m/d').' '.(new \DateTime($toMapArray['eventStartTime']))->format('H:i:s'), new \DateTimeZone('Europe/Rome')))->format(\DateTime::W3C);
        $redBean['eventend'] = (new \DateTime((new \DateTime($toMapArray['eventEnd']))->format('Y/m/d').' '.(new \DateTime($toMapArray['eventEndTime']))->format('H:i:s'), new \DateTimeZone('Europe/Rome')))->format(\DateTime::W3C);
        $redBean['eventdate'] = $redBean['eventstart'];
    return $redBean;
    }
?>

