<?php

/**
 * Class used for handling Exceptions
 *
 * Class exceptionHandler
 *
 * @todo Exception Priority
 */
class exceptionHandler {
    public function __construct($exceptionCode, $exceptionMessage, $exceptionPriority = 0) {
        switch ($exceptionPriority) {
            case 0 :
                echo("ERROR " . $exceptionCode . " = " . $exceptionMessage);
                break;
        }
    }
}