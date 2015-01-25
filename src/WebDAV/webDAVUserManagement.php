<?php
    use Sabre\VObject;

    function webDAVUserCreate($webDAVUsername, $webDAVPassword, $webDAVEMail, $webDAVDisplayname) {
        if (R::findOne('userz', 'username = ?', $webDAVUsername) == NULL) {

        }
    return false;
    }