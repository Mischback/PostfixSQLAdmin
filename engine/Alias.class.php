<?php

    /** @file   Alias.class.php
     *  @brief  TODO: insert smart description here!
     */


    /* fetch our DAO */
    require_once('./engine/AliasDAO.class.php');


    /** @class  Alias
     *  @brief  TODO: insert smart description here!
     */
    class Alias {

        /** @brief  The alias' ID
         */
        private $alias_id = NULL;

        /** @brief  Returns the alias' ID
         *  @retval INT $alias_id
         */
        public function getAliasID() {
            return $this->alias_id;
        }


        /** @brief  The alias' name
         *
         *  This is also the local-part of the alias
         *
         *  @todo: Check this against some RegEx to validate this!
         */
        private $alias_name = NULL;

        /** @brief  Returns the alias' name
         *  @retval STRING $alias_name
         */
        public function getAliasName() {
            return $this->alias_name;
        }


        /** @brief  The alias' domain ID
         *
         *  This is the foreign key to domains
         */
        private $domain_id = NULL;

        /** @brief  Returns the alias' domain ID
         *  @retval INT $domain_id
         */
        public function getDomainID() {
            return $this->domain_id;
        }


        /** brief   The alias' domain name
         *
         *  This is the actual domain name
         */
        private $domain_name = NULL;

        /** @brief  Returns the alias' domain name
         *  @retval STRING $domain_name
         */
        public function getDomainName() {
            return $this->domain_name;
        }


        /** @brief  Returns the complete alias-address
         *  @retval STRING
         */
        public function getAlias() {
            return $this->alias_name.'@'.$this->domain_name;
        }


        /** @brief  The destination of this alias
         *
         *  Mail will be forwarded to this address
         *
         *  @todo: Check this against some RegEx to validate this!
         */
        private $alias_destination = NULL;

        /** @brief  Returns the destination of this alias
         *  @retval STRING $alias_destination
         */
        public function getAliasDestination() {
            return $this->alias_destination;
        }
    }

?>
