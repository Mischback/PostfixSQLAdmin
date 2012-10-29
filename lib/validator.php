<?php

    /*  @file   validator.php
     *  @brief  Contains functions to validate user input
     */


    /* RFC5322 defines a character set to be used in atoms
     * see: http://tools.ietf.org/html/rfc5322#section-3.2.3
     */
    define('VALIDATOR_DOT_ATOM_CHAR', "[a-z0-9!#$%&'*+-/=?^_`{|}~]");
    

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

        /* now check, if $address conforms to the specification of RFC5322
         * see: http://tools.ietf.org/html/rfc5322#section-3.4.1
         * see: http://tools.ietf.org/html/rfc5322#section-3.2.3
         *
         * However, we will not implement the full RFC! We will go with
         * what the RFC calls 'dot-atom', which means a string of 
         * ASCII-characters and the '.' surrounded by ASCII.
         *
         * see: http://www.regular-expressions.info/email.html
         */
        $regex = '@^'.VALIDATOR_DOT_ATOM_CHAR.'+(?:\.'.VALIDATOR_DOT_ATOM_CHAR.'+)*$@';

        if ( preg_match($regex, $address) == 0 ) {
            return false;
        }

        return $address;
    }


    /** @brief  Checks the domain part of an email-address
     *  @param  STRING $domain The domain to check
     *  @retval MIXED The result of the check
     */
    function checkDomain($domain) {

        /* remove unnecessary whitespaces
         * removes ' ', '\t', '\n', '\r', '\0', '\x0B'
         * see: http://php.net/manual/en/function.trim.php
         */
        $domain = strtolower(trim($domain));

        /* check, if $domain conforms to the specification of RFC5321
         *
         * RFC5321 defines a character set to be used in domains
         * see: http://tools.ietf.org/html/rfc5321#section-4.1.2
         */
        $regex = '@^(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$@'

        if ( preg_match($regex, $domain) == 0 ) {
            return false;
        }

        return $domain;
    }

?>
