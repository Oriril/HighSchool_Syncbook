<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/src/Services/serviceDatabaseManagement.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/lib/SabreDAV/vendor/autoload.php");
    use Sabre\VObject;

    /*@todo configure GroupAwareServer.php*/
    const SABREDAV_REALM = ":SabreDAV:";
    const WEBDAV_BASE_URI = "";

    function webDAVPrincipalBuild($beanPrincipal, $webDAVUsername, $webDAVEMail = NULL, $webDAVDisplayname = NULL, $webDAVvCardUrl = NULL) {
        $beanPrincipal -> displayname = $webDAVDisplayname;
        $beanPrincipal -> email = $webDAVEMail;
        $beanPrincipal -> uri = "principals/" . $webDAVUsername;
        $beanPrincipal -> vcardurl = $webDAVvCardUrl;
    return $beanPrincipal;
    }

    function webDAVUserBuild($beanUser, $webDAVUsername, $webDAVPassword) {
        $beanUser -> username = $webDAVUsername;
        $beanUser -> digesta1 = md5($webDAVUsername . SABREDAV_REALM . $webDAVPassword);
    return $beanUser;
    }

    function webDAVUserPrincipalCreate($webDAVUsername, $webDAVPassword, $webDAVEMail, $webDAVDisplayname, $webDAVvCardUrl = NULL) {
        databaseSabreDAVUserConnect($webDAVUsername);

        try {
            if (R::findOne('users', 'username = ?', $webDAVUsername) == NULL) {
                // Starting Transaction
                R::begin();

                // Adding Instance to "users" Table for User creation purpose
                $beanUser = R::dispense('users');
                webDAVUserBuild($beanUser, $webDAVUsername, $webDAVPassword);
                $beanUserID = R::store($beanUser);

                // Adding Instance to "principals" Table for Principal creation purpose
                $beanPrincipal = R::dispense('principals');
                $beanPrincipal = webDAVPrincipalBuild($beanPrincipal, $webDAVUsername, $webDAVEMail, $webDAVDisplayname, $webDAVvCardUrl);
                $beanPrincipalID = R::store($beanPrincipal);

                // Adding Instance to "principals" Table for Reading permission purpose
                $beanPrincipalReading = R::dispense('principals');
                $beanPrincipalReading = webDAVPrincipalBuild($beanPrincipalReading, $webDAVUsername . "/calendar-proxy-read");
                $beanPrincipalReadingID = R::store($beanPrincipalReading);

                // Adding Instance to "principals" Table for Writing permission purpose
                $beanPrincipalWriting = R::dispense('principals');
                $beanPrincipalWriting = webDAVPrincipalBuild($beanPrincipalWriting, $webDAVUsername . "/calendar-proxy-write");
                $beanPrincipalWritingID = R::store($beanPrincipalWriting);

                if (!webDAVUserPrincipalSuccessfulCreation($webDAVUsername, $webDAVPassword)) {
                    // Closing Transaction (Failure)
                    R::rollback();
                    return FALSE;
                }

                // Closing Transaction (Success)
                R::commit();
            }
        } catch (Exception $exceptionError) {
            // Closing Transaction (Failure)
            R::rollback();
        }
    return FALSE;
    }

    function webDAVUserPrincipalSuccessfulCreation($webDAVUsername, $webDAVPassword) {
        // Creating User Authentication Informations
        $webDAVConnectionSettings = array('baseUri' => WEBDAV_BASE_URI, 'userName' => $webDAVUsername, 'password' => $webDAVPassword);
        $webDAVClient = new Sabre\DAV\Client($webDAVConnectionSettings);

        // Sending Request and checking Response with User Informations
        $webDAVResponse = $webDAVClient -> request('GET');
        if ($webDAVResponse['statusCode'] == 200) {
            // The user has been Successfully Created
            return TRUE;
        }
    return FALSE;
    }

