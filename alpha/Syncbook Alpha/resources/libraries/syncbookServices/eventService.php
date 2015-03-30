<?php
    require_once '../Slim/Slim.php';
    require_once '../RedBeanPHP4_0_5/rb.php';
    require_once './procedureFunctions.php';
    require_once './SabreDAV_Services.php';
    require_once './syncService.php';
    
    R::setup('mysql:host=localhost;dbname=syncbook','federico','password');
    R::freeze(true);
    
    try {
        R::inspect();
    } catch (Exception $error) {
        errorProcedure("500", false, "Unable to Connect to Database");
        die();
    }
    
    \Slim\Slim::registerAutoloader();

    $auxiliar = new \Slim\Slim();
    
    $auxiliar->get('/events', 'getEvents');
    $auxiliar->post('/events', 'addEvent');
    $auxiliar->put('/events/:ID', 'updateEvent');
    $auxiliar->delete('/events/:ID', 'deleteEvent');

    $auxiliar->run();

    /**
     * Function to get all events from Database
     */
    function getEvents()
    {
        try {
            $events = R::getAll('SELECT * FROM events ORDER BY eventDate');
            echo("{\"events\":".json_encode($events)."}");
        } catch (Exception $error) {
            errorProcedure(500, false, "SQL Error", "events");
            die();
        }
    }
    
    /**
     * Function to Add an Event to WebDAV/MYDB Database
     */
    function addEvent()
    {
        updateDatabaseEvents('federico', 'events', true);
        
        try {
            $redBean = mappingArrayEvent(json_decode(\Slim\Slim::getInstance()->request()->getBody(), true));
            
            R::begin();
            R::store($redBean);
            
            $calendarMain = setupProcedureEvents('federico', 'events');
            if($calendarMain != false) {
                $vCalendarData = mappingJSONVCalendarObject(json_decode(\Slim\Slim::getInstance()->request()->getBody(), false), 'Europe/Rome');
                if(addVCalendar($calendarMain, $vCalendarData) == NULL) {
                    R::commit();
                    errorProcedure(200, true, "", "events");
                } else {
                    R::rollback();
                    errorProcedure(500, false, "Cannot Add the vCalendar", "events");
                    die();
                }
            } else {
                R::rollback();
                errorProcedure(500, false, "Error occoured in setupProcedure() Function", "events");
                die();
            }
        } catch (Exception $error) {
            R::rollback();
            errorProcedure(500, false, "Cannot Add Event", "events");
            die();
        }
        
        updateDatabaseEvents('federico', 'events', true);
    }
    
    /**
     * Functio to Update an Event in WebDAV/MYDB Database
     * 
     * @param int $ID
     */
    function updateEvent($ID)
    {
        updateDatabaseEvents('federico', 'events', true);
        
        try {
            $redBean = mappingArrayEvent(json_decode(\Slim\Slim::getInstance()->request()->getBody(), true));
            
            R::begin();
            R::store($redBean);
            
            $calendarMain = setupProcedureEvents('federico', 'events');
            if($calendarMain != false) {
                $vCalendarData = mappingJSONVCalendarObject(json_decode(\Slim\Slim::getInstance()->request()->getBody(), false), 'Europe/Rome');
                if(updateVCalendar($calendarMain, $vCalendarData->VEVENT->UID, $vCalendarData)) {
                    R::commit();
                    errorProcedure(200, true, "", "events");
                } else {
                    R::rollback();
                    errorProcedure(500, false, "Cannot Update the vCalendar", "events");
                    die();
                }
            } else {
                R::rollback();
                errorProcedure(500, false, "Error occoured in setupProcedure() Function", "events");
                die();
            }
        } catch (Exception $error) {
            R::rollback();
            errorProcedure(500, false, "Cannot Update Event", "events");
            die();
        }
        
        updateDatabaseEvents('federico', 'events', true);
    }
    
    /**
     * Function to Delete an Event in WebDAV/MYDB Database
     * 
     * @param int $ID
     */
    function deleteEvent($ID)
    {
        updateDatabaseEvents('federico', 'events', true);
        
        try {
            $redBean = mappingArrayEvent(R::load('events', $ID));
            
            R::begin();
            R::trash($redBean);
            
            $calendarMain = setupProcedureEvents('federico', 'events');
            if($calendarMain != false) {
                $vCalendarData = mappingJSONVCalendarObject(json_decode(\Slim\Slim::getInstance()->request()->getBody(), false), 'Europe/Rome');
                if(deleteVCalendar($calendarMain, $vCalendarData->VEVENT->UID)) {
                    R::commit();
                    errorProcedure(200, true, "", "events");
                } else {
                    R::rollback();
                    errorProcedure(500, false, "Cannot Delete the vCalendar", "events");
                    die();
                }
            } else {
                R::rollback();
                errorProcedure(500, false, "Error occoured in setupProcedure() Function", "events");
                die();
            }
        } catch (Exception $error) {
            R::rollback();
            errorProcedure(500, false, "Cannot Delete Event", "events");
            die();
        }
        
        updateDatabaseEvents('federico', 'events', true);
    }
?>