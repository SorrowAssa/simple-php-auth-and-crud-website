<?php

/***********************************/
/**        FORM VALIDATION        **/
/***********************************/

/**
 * Validate a string is NOT null or whitespace
 *
 * @param string $str   String to check
 * @return boolean      True is not null or ws
 */
function ValfNullOrEmpty($str):bool {
    return (isset($str) && trim($str) !== '');
}

/**
 * Validate a string length
 *
 * @param string $str       String to check
 * @param int $minLength    Minimum length of string (optional)
 * @param int $maxLength    Maximum length of string (optional)
 * @return boolean          True if all conditions are ok. If $str is null, return False (to avoid possible confusions)
 */
function ValfLength($str, $minLength, $maxLength):bool {
    if (!isset($str)) return false; // not valid, to avoid possible confusions
    if (isset($minLength) && strlen($str) < $minLength) return false;   // too short
    if (isset($maxLength) && strlen($str) > $maxLength) return false;   // too large
    if (!isset($minLength) && !isset($maxLength)) throw new Exception('Params $minLength and $maxLength are not set.');
    return true;
}
