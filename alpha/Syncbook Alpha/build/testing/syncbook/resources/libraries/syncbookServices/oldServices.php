<?php
    /*SabreDAV User Database Manipulation*/
    
    /**
     * 
     * @param type $auxiliarAddressBookName
     * @return boolean (if(==true) {AddressBook !Exists} else {AddressBook Exists})
     * 
     * Function to evaluate the existence of an User
     */
    /*function existenceAddressBook($auxiliarAddressBookName) {
        if(R::findOne('addressbooks', 'uri = ?', [$auxiliarAddressBookName])==NULL) {return true;} else {return false;}
    }*/
    
    /**
     * 
     * @param type $auxiliarUesrname
     * @param type $auxiliarAddressBookDisplayName
     * @param type $auxiliarAddressBookName
     * 
     * Function to Build an AddressBook
     */
    /*function buildAddressbook($auxiliarUesrname, $auxiliarAddressBookDisplayName, $auxiliarAddressBookName)
    {
        if(existenceAddressBook($auxiliarAddressBookName)) {
            $addressBook = R::dispense('addressbooks');
            $addressBook->principaluri = "principals/".$auxiliarUesrname;
            $addressBook->displayname = $auxiliarAddressBookDisplayName;
            $addressBook->uri = $auxiliarAddressBookName;
            $addressBook->description = NULL;
            $addressBook->synctoken = 1;
            $id = R::store($addressBook);
        } else {
            echo("<B>The AddressBook : -|".$auxiliarAddressBookName."|- Already Exits</B>");
        }
    }*/
    
    /**
     * 
     * @param type $auxiliarUsername
     * @param type $auxiliarPassword
     * @param type $auxiliarAddressBookName
     * @param type $auxiliarContactName
     * @param type $vCardObject
     * @return boolean (if(==true) {Successfull Operation} else {UnSuccessfull Operation})
     * 
     * Function to Add a Contact to a Specific AddressBook
     */
    /*function addContactToAddressbook($auxiliarUsername, $auxiliarPassword, $auxiliarAddressBookName, $auxiliarContactName, $vCardObject)
    {
        if(!(existenceAddressBook($auxiliarAddressBookName))) {
            $connectionSettings = array('baseUri' => 'http://localhost:8888/federico_htdocs/syncbook/libraries/sabredav/addressbookserver.php/addressbooks/'.$auxiliarUsername."/".$auxiliarAddressBookName."/", 'userName' => $auxiliarUsername, 'password' => $auxiliarPassword);
            $client = new Sabre\DAV\Client($connectionSettings);
            
            $vCardToString = $vCardObject->serialize();
            
            try {$response = $client->request('PUT', $auxiliarContactName, $vCardToString);} catch (Exception $exceptionError) {$response['statusCode']=200;}
            // $response = $client->request('PUT', (string)$auxiliarContactName, (string)$vCardToString);
            
            if($response['statusCode']==200) {return true;} else {return false;}
        } else {
            echo("<B>The AddressBook : -|".$auxiliarAddressBookName."|- Does not Exits</B>");
            return false;
        }
    }*/
?>