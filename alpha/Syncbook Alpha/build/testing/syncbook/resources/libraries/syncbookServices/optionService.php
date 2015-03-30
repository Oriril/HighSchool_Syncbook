<?php
    require_once '../RedBeanPHP4_0_5/rb.php';
    require_once './procedureFunctions.php';

    R::setup('mysql:host=localhost;dbname=syncbook','federico','password');
    R::freeze(true);
    
    try {
        R::inspect();
    } catch (Exception $error) {
        errorProcedure(500, false, "Unable to Connect to Database", "option");
        die();
    }
    
    /**
     * Function to Get the Options from a Database with the specified Type
     * 
     * @param string $syncType
     */
    function getDatabaseOptions($syncType)
    {
        try {
            $syncOption = R::findOne('syncoptions', 'synctype = ?', [$syncType]);
            if($syncOption == null) {
                errorProcedure(500, false, "SyncOption not Found", "option");
                die();
            }

            $syncOption = $syncOption->export();
            echo("{\"option\":".json_encode($syncOption)."}");
        } catch (Exception $error) {
            errorProcedure(500, false, "SyncOption not Found", "option");
            die();
        }
    }
    
    /**
     * Function to Set the Options on a Database with the specified Type
     * 
     * @param string $syncType
     * @param object $newSyncOption
     */
    function setDatabaseOptions($syncType, $newSyncOption)
    {
        try {
            $syncOption = R::findOne('syncoptions', 'synctype = ?', [$syncType]);
            if($syncOption == null) {
                errorProcedure(500, false, "SyncOption not Found", "option");
                die();
            }
            
            $syncOption->syncflag = $newSyncOption->syncflag;
            $syncOption->synctime = $newSyncOption->synctime;

            R::begin();
            R::store($syncOption);
            R::commit();

            errorProcedure(200, true, "", "option");
        } catch (Exception $error) {
            R::rollback();
            errorProcedure(500, false, "Error in setDatabaseOptions() Function", "option");
        }
    }
    
    
    if(isset($_REQUEST['syncType']) && !(isset($_REQUEST['newSyncOption']))) {
        getDatabaseOptions($_REQUEST['syncType']);
    }
    
    if(isset($_REQUEST['syncType']) && isset($_REQUEST['newSyncOption'])) {
        setDatabaseOptions($_REQUEST['syncType'], json_decode($_REQUEST['newSyncOption']));
    }
?>