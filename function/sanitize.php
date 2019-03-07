<?php

/*
 * Sanitize input/output data in/out database
 */

function escape($string){
    return trim(htmlentities($string, ENT_QUOTES, 'UTF-8'));
}
