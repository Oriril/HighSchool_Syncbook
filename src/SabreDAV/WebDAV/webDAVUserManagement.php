<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationInclude.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configurationClass.php");
use Sabre\VObject;

require_once(SOURCE_PATH . "Services/serviceDatabaseManagement.php");

const SABREDAV_REALM = ":SabreDAV:";
const WEBDAV_BASE_URI = "/Syncbook/lib/SabreDAV/groupwareserver.php/";

/**
 * Function for building a Principal Bean
 *
 * @param $beanPrincipal
 * @param string $webDAVUsername
 * @param null|string $webDAVEMail
 * @param null|string $webDAVDisplayname
 * @param null|string $webDAVvCardUrl
 * @return $beanPrincipal
 */
function webDAVPrincipalBuild($beanPrincipal, $webDAVUsername, $webDAVEMail = NULL, $webDAVDisplayname = NULL, $webDAVvCardUrl = NULL) {
    $beanPrincipal->displayname = $webDAVDisplayname;
    $beanPrincipal->email = $webDAVEMail;
    $beanPrincipal->uri = "principals/" . $webDAVUsername;
    $beanPrincipal->vcardurl = $webDAVvCardUrl;
return $beanPrincipal;
}

/**
 * Function for Building an User Bean
 *
 * @param $beanUser
 * @param string $webDAVUsername
 * @param string $webDAVPassword
 * @return $beanUser
 */
function webDAVUserBuild($beanUser, $webDAVUsername, $webDAVPassword) {
    $beanUser->username = $webDAVUsername;
    $beanUser->digesta1 = md5($webDAVUsername . SABREDAV_REALM . $webDAVPassword);
return $beanUser;
}

/**
 * Function to Create a webDAV User/Principal
 *
 * @param string $webDAVUsername
 * @param string $webDAVPassword
 * @param string $webDAVEMail
 * @param string $webDAVDisplayname
 * @param null|string $webDAVvCardUrl
 * @return bool
 *
 * #todo vCard Default from Register
 */
function webDAVUserPrincipalCreate($webDAVUsername, $webDAVPassword, $webDAVEMail, $webDAVDisplayname, $webDAVvCardUrl = NULL) {
    $configurationClass = new configurationClass();

    if (databaseSabreDAVConnectRedBean($webDAVUsername, $configurationClass, TRUE)) {
        try {
            // Starting Transaction
            R::begin();

            // Adding Instance to "users" Table for User creation purpose
            $beanUser = R::dispense('users');
            $beanUser = webDAVUserBuild($beanUser, $webDAVUsername, $webDAVPassword);
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

            /*if (!webDAVUserPrincipalSuccessfulCreation($webDAVUsername, $webDAVPassword)) {
                // Closing Transaction (Failure)
                R::rollback();
                return FALSE;
            }*/

            // Closing Transaction (Success)
            R::commit();
            echo("Test True");
            return TRUE;
        } catch (Exception $exceptionError) {
            // Closing Transaction (Failure)
            R::rollback();
        }
    }
return FALSE;
}

/**
 * Function for Checking webDAV User/Principal Creation
 *
 * @param string $webDAVUsername
 * @param string $webDAVPassword
 * @return bool
 */
function webDAVUserPrincipalSuccessfulCreation($webDAVUsername, $webDAVPassword) {
    // Creating User Authentication Informations
    $webDAVConnectionSettings = array('baseUri' => WEBDAV_BASE_URI, 'userName' => $webDAVUsername, 'password' => $webDAVPassword);
    $webDAVClient = new Sabre\DAV\Client($webDAVConnectionSettings);
    print_r($webDAVConnectionSettings);

    // Sending Request and checking Response with User Informations
    $webDAVResponse = $webDAVClient->request('GET');
    if ($webDAVResponse['statusCode'] == 200) {
        // The user has been Successfully Created
        return TRUE;
    }
return FALSE;
}

// webDAVUserPrincipalCreate("Nildric", "password", "longhin.federico.nildric@gmail.com", "Federico" . " " . "Longhin");
