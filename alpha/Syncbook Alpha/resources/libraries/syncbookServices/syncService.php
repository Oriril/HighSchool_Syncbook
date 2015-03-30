<?php
    use Sabre\VObject;
    include '../sabredav/vendor/autoload.php';
    require_once '../RedBeanPHP4_0_5/rb.php';
    require_once './procedureFunctions.php';
    require_once './SabreDAV_Services.php';

    function dbConnection() {
        R::setup('mysql:host=localhost;dbname=syncbook','federico','password');
        R::freeze(true);

        try {
            R::inspect();
        } catch (Exception $error) {
            errorProcedure("500", false, "Unable to Connect to Database");
            die();
        }
    }
    
    /**
     * 
     * @param \Sabre\CardDAV\Addressbook || \Sabre\CalDAV\Calendar $objectMain
     * @param type $flag
     */
    function updateSyncToken($objectMain, $flag = "carddav")
    {
        $syncToken = R::dispense('synctoken');
        
        if($flag == "carddav") {
            $syncToken->id = 1;
        } else {
            if($flag == "caldav") {
                $syncToken->id = 2;
            } else {
                errorProcedure(500, false, "Error in Flag Retriving");
                die();
            }
        }
        
        $syncToken->synctoken = $objectMain->getSyncToken();
        $syncToken->flag = $flag;
        
        R::store($syncToken);
    }
    
    /**
     * Function to update MYDB Contacts
     * 
     * @param string $principalUsername
     * @param \Sabre\CardDAV\Addressbook $principalAddressBook
     * @param boolean $silent
     */
    function updateDatabaseContacts($principalUsername, $principalAddressBook, $silent = false)
    {
        try {
            $syncRecord = R::find('synctoken', 'flag = "carddav"');
        } catch(Exception $error) {
            errorProcedure(500, false, "Unable Database Reading");
            die();
        }
        
        $addressBookMain = setupProcedureContacts($principalUsername, $principalAddressBook);
        if($addressBookMain == false) {
            errorProcedure(500, false, "Error occoured in setupProcedure() Function");
            die();
        }
        
        $gettingChanges = $addressBookMain->getChanges($syncRecord[1]->synctoken, 1);
        
        R::begin();
        try {
            foreach($gettingChanges['added'] as $vCardUri)
            {
                if(R::getRow('SELECT * FROM contacts WHERE UUID = "'.str_replace(".vcf", "", $vCardUri).'"') == null)
                {
                    $vCardData = mappingVCardObject(\Sabre\VObject\Reader::read($addressBookMain->getChild($vCardUri)->get()));
                    $redBean = mappingArrayContact($vCardData);
                    R::store($redBean);
                }
            }
            
            foreach($gettingChanges['modified'] as $vCardUri)
            {
                $vCardData = mappingVCardObject(\Sabre\VObject\Reader::read($addressBookMain->getChild($vCardUri)->get()));
                
                $dataString = '';
                foreach($vCardData as $key=>$value) {
                    $dataString = $dataString.' '.strtolower($key).'="'.$value.'",';
                }
                $dataString = substr($dataString, 1, (strlen($dataString)-2));
                
                $auxiliar = R::getAssocRow('SELECT * FROM contacts WHERE UUID = "'.$vCardData['UUID'].'"');
                if(count($auxiliar)>0 && $auxiliar[0]['ID']!=null) {
                    R::exec('UPDATE contacts SET '.$dataString.' WHERE id='.$auxiliar[0]['ID']);
                } else {
                    $redBean = mappingArrayContact($vCardData);
                    R::store($redBean);
                }
            }
            
            foreach($gettingChanges['deleted'] as $vCardUri)
            {   
                $redBean = mappingArrayContact(R::load('contacts', R::getRow('SELECT id FROM contacts WHERE UUID = "'.str_replace(".vcf", "", $vCardUri).'"')['id']));
                R::trash($redBean);
            }
            
            updateSyncToken($addressBookMain);
            R::commit();
            
            if($silent == false) {
                errorProcedure(200, true, "");
            }
        } catch(Exception $error) {
            R::rollback();
            errorProcedure(500, false, "Error in Database Syncronizing");
            die();
        }
    }
    
    /**
     * Function to update MYDB Events
     * 
     * @param string $principalUsername
     * @param \Sabre\CalDAV\Calendar $principalCalendar
     * @param boolean $silent
     */
    function updateDatabaseEvents($principalUsername, $principalCalendar, $silent = false)
    {
        try {
            $syncRecord = R::find('synctoken', 'flag = "caldav"');
        } catch(Exception $error) {
            errorProcedure(500, false, "Unable Database Reading", "events");
            die();
        }
        
        $calendarMain = setupProcedureEvents('federico', 'events');
        if($calendarMain == false) {
            errorProcedure(500, false, "Error occoured in setupProcedure() Function", "events");
            die();
        }
        
        $gettingChanges = $calendarMain->getChanges($syncRecord[2]->synctoken, 1);
        
        R::begin();
        try {
            foreach($gettingChanges['added'] as $vCalendarUri)
            {
                if(R::getRow('SELECT * FROM events WHERE UUID = "'.str_replace(".ics", "", $vCalendarUri).'"') == null)
                {
                    $vCalendarData = mappingVCalendarObject(\Sabre\VObject\Reader::read($calendarMain->getChild($vCalendarUri)->get()));
                    $redBean = mappingArrayEvent($vCalendarData);
                    R::store($redBean);
                }
            }
            
            foreach($gettingChanges['modified'] as $vCalendarUri)
            {
                $vCalendarData = mappingVCalendarObject(\Sabre\VObject\Reader::read($calendarMain->getChild($vCalendarUri)->get()));
                
                $dataString = '';
                foreach($vCalendarData as $key=>$value) {
                    if($key != "eventStartTime" && $key != "eventEndTime") {
                        $dataString = $dataString.' '.strtolower($key).'="'.$value.'",';
                    }
                }
                $dataString = substr($dataString, 1, (strlen($dataString)-2));
                
                $auxiliar = R::getAssocRow('SELECT * FROM events WHERE UUID = "'.$vCalendarData['UUID'].'"');
                if(count($auxiliar)>0 && $auxiliar[0]['ID']!=null) {
                    R::exec('UPDATE events SET '.$dataString.' WHERE id='.$auxiliar[0]['ID']);
                } else {
                    $redBean = mappingArrayEvent($vCalendarData);
                    R::store($redBean);
                }
            }
            
            foreach($gettingChanges['deleted'] as $vCalendarUri)
            {   
                $redBean = mappingArrayEvent(R::load('events', R::getRow('SELECT id FROM events WHERE UUID = "'.str_replace(".ics", "", $vCalendarUri).'"')['id']));
                R::trash($redBean);
            }
            
            updateSyncToken($calendarMain, "caldav");
            R::commit();
            
            if($silent == false) {
                errorProcedure(200, true, "", "events");
            }
        } catch(Exception $error) {
            R::rollback();
            errorProcedure(500, false, "Error in Database Syncronizing", "events");
            die();
        }
    }
    
    if(isset($_REQUEST['syncContacts']) && $_REQUEST['syncContacts']=="syncContacts") {
        dbConnection();
        updateDatabaseContacts('federico', 'contacts');
    }
    
    if(isset($_REQUEST['syncEvents']) && $_REQUEST['syncEvents']=="syncEvents") {
        dbConnection();
        updateDatabaseEvents('federico', 'events');
    }
?>