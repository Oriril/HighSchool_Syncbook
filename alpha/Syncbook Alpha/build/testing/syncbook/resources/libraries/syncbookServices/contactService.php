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
    
    $auxiliar->get('/contacts', 'getContacts');
    $auxiliar->post('/contacts', 'addContact');
    $auxiliar->put('/contacts/:ID', 'updateContact');
    $auxiliar->delete('/contacts/:ID', 'deleteContact');

    $auxiliar->run();

    /**
     * Function to get all contacts from Database
     */
    function getContacts()
    {
        try {
            $contacts = R::getAll('SELECT * FROM contacts ORDER BY contactSurname');
            echo("{\"contacts\":".json_encode($contacts)."}");
        } catch (Exception $error) {
            errorProcedure(500, false, "SQL Error");
            die();
        }
    }
    
    /**
     * Function to Add a Contact to WebDAV/MYDB Database
     */
    function addContact()
    {
        updateDatabaseContacts('federico', 'contacts', true);
        
        try {
            $redBean = mappingArrayContact(json_decode(\Slim\Slim::getInstance()->request()->getBody(), true));
            
            R::begin();
            R::store($redBean);
            
            $addressBookMain = setupProcedureContacts('federico', 'contacts');
            if($addressBookMain != false) {
                $vCardData = mappingJSONVCardObject(json_decode(\Slim\Slim::getInstance()->request()->getBody(), false));
                if(addVCard($addressBookMain, $vCardData) != NULL) {
                    R::commit();
                    errorProcedure(200, true, "");
                } else {
                    R::rollback();
                    errorProcedure(500, false, "Cannot Add the vCard");
                    die();
                }
            } else {
                R::rollback();
                errorProcedure(500, false, "Error occoured in setupProcedure() Function");
                die();
            }
        } catch (Exception $error) {
            R::rollback();
            errorProcedure(500, false, "Cannot Add Contact");
            die();
        }
        
        updateDatabaseContacts('federico', 'contacts', true);
    }

    /**
     * Functio to Update a Contact in WebDAV/MYDB Database
     * 
     * @param int $ID
     */
    function updateContact($ID)
    {
        updateDatabaseContacts('federico', 'contacts', true);
        
        try {
            $redBean = mappingArrayContact(json_decode(\Slim\Slim::getInstance()->request()->getBody(), true));
            
            R::begin();
            R::store($redBean);
            
            $addressBookMain = setupProcedureContacts('federico', 'contacts');
            if($addressBookMain != false) {
                $vCardData = mappingJSONVCardObject(json_decode(\Slim\Slim::getInstance()->request()->getBody(), false));
                if(updateVCard($addressBookMain, $vCardData->UID, $vCardData) == true) {
                    R::commit();
                    errorProcedure(200, true, "");
                } else {
                    R::rollback();
                    errorProcedure(500, false, "Cannot Update the vCard");
                    die();
                }
            } else {
                R::rollback();
                errorProcedure(500, false, "Error occoured in setupProcedure() Function");
                die();
            }
        } catch (Exception $error) {
            R::rollback();
            errorProcedure(500, false, "Cannot Update Contact");
            die();
        }
        
        updateDatabaseContacts('federico', 'contacts', true);
    }
    
    /**
     * Function to Delete a Contact in WebDAV/MYDB Database
     * 
     * @param int $ID
     */
    function deleteContact($ID)
    {
        updateDatabaseContacts('federico', 'contacts', true);
        
        try {
            $redBean = mappingArrayContact(R::load('contacts', $ID));
            
            R::begin();
            R::trash($redBean);
            
            $addressBookMain = setupProcedureContacts('federico', 'contacts');
            if($addressBookMain != false) {
                $vCardData = mappingJSONVCardObject(json_decode(\Slim\Slim::getInstance()->request()->getBody(), false));
                if(deleteVCard($addressBookMain, $vCardData->UID) == true) {
                    R::commit();
                    errorProcedure(200, true, "");
                } else {
                    R::rollback();
                    errorProcedure(500, false, "Cannot Delete the vCard");
                    die();
                }
            } else {
                R::rollback();
                errorProcedure(500, false, "Error occoured in setupProcedure() Function");
                die();
            }
        } catch (Exception $error) {
            R::rollback();
            errorProcedure(500, false, "Cannot Delete Contact");
            die();
        }
        
        updateDatabaseContacts('federico', 'contacts', true);
    }
?>