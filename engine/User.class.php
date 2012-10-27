<?php

    /** @file   User.class.php
     *  @brief  Contains the classes that handle User objects
     */


    /* fetch the DAO */
    require_once('./engine/DomainDAO.class.php');


    /** @class  User
     *  @brief  Represents a single User to be managed
     */
    class User {

        /** @brief  The user's ID
         */
        private $user_id = NULL;

        /** @brief  Returns the user's ID
         *  @retval INT $user_id
         */
        public function getUserID() {
            return $this->user_id;
        }


        /** @brief  The user's name
         *
         *  This is also the local-part of the mail-address.
         *
         *  @todo: Check this against some RegEx to validate this!    
         */
        private $username = NULL;

        /** @brief  Returns the user's name
         *  @retval STRING $username
         */
        public function getUserName() {
            return $this->username;
        }


        /** @brief  The user's domain ID
         *  
         *  This is the foreign key to the domains
         */
        private $domain_id = NULL;

        /** @brief  Returns the user's domain ID
         *  @retval INT $domain_id
         */
        public function getDomainID() {
            return $this->domain_id;
        }


        /** @brief  The user's domain name
         *
         *  This is the actual domain name
         */
        private $domain_name = NULL;

        /** @brief  Returns the user's domain name
         *  @retval STRING $domain_name
         */
        public function getDomainName() {
            return $this->domain_name;
        }


        /** @brief  Returns the user's mail-address
         *  @retval STRING 
         */
        public function getUserMail() {
            return $this->username.'@'.$this->domain_name;
        }
    }

?>
