<?php
    class configurationClass {
        public $configurationArray = array();

        public function __construct() {
            $this->configurationArray = require_once("configurationArray.php");
        }
    }