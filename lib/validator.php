<?php

    /*  @file   validator.php
     *  @brief  Contains functions to validate user input
     */


    define('VALIDATOR_ALLOWED_CHAR_LOCAL', "[a-z0-9!#$%&'*+/=?^_`{|}~-]");

    /** @brief  Checks the local part of an email-address
     *  @param  STRING $address The address to check
     *  @retval MIXED The result of the check
     *
     *  Will return the sanitized $address, if it conforms to the regular 
     *  expression, or FALSE otherwise.
     *
     *  @todo:  The RegEx contains the "'"-character. How does this fit in the database?
     */
    function checkLocalAddress($address) {

        /* remove unnecessary whitespaces
         * removes ' ', '\t', '\n', '\r', '\0', '\x0B'
         * see: http://php.net/manual/en/function.trim.php
         */
        $address = strtolower(trim($address));

        /* now check, if $address confirms to the specification of RFC2822
         * see: http://tools.ietf.org/html/rfc2822#section-3.4.1
         *
         * However, we will not implement the full RFC2822! We will go with
         * what the RFC calls 'dot-atom', which means a string of 
         * ASCII-characters and the '.' surrounded by ASCII.
         *
         * see: http://www.regular-expressions.info/email.html
         */
        $regex = '@^'.VALIDATOR_ALLOWED_CHAR_LOCAL.'+(?:\.'.VALIDATOR_ALLOWED_CHAR_LOCAL.'+)*$@';

        if ( preg_match($regex, $address) == 0 ) {
            return false;
        }

        return $address;
    }

?>
