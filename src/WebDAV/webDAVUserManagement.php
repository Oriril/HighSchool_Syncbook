<?php
    use Sabre\VObject;

    function webDAVUserCreate($webDAVUsername, $webDAVPassword, $webDAVEMail, $webDAVDisplayname) {
        if (R::findOne('users', 'username = ?', $webDAVUsername) == NULL) {

        }
    return false;
    }