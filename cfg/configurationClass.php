<?php

class configurationClass {
    public $configurationArray = array();

    public function __construct() {
        $this->configurationArray = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/Syncbook/cfg/configuration.json"), TRUE);
    }
}