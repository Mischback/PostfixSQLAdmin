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

        /** @brief  This variable controls, if a database update is neccessary
         *
         *  For the User class, this is only the case, if the functions
         *  setAliasName(), setDomainID() and setDestination() are used.
         *
         *  The acutal update to the DB will happen on object destruction. See
         *  __destruct() for further details.
         */
        private $modified = false;


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
         */
        private $alias_name = NULL;

        /** @brief  Returns the alias' name
         *  @retval STRING $alias_name
         */
        public function getAliasName() {
            return $this->alias_name;
        }

        /** @brief  Sets the alias' name
         *  @param  STRING $name
         *
         *  @todo: Check this against some RegEx to validate this!
         */
        public function setAliasName($name) {
            $this->alias_name = $name;
            $this->modified = true;
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

        /** @brief  Sets the alias' domain ID
         *  @param  INT $domain_id
         */
        public function setDomainID($domain_id) {
            $this->domain_id = $domain_id;
            $this->modified = true;
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
         */
        private $destination = NULL;

        /** @brief  Returns the destination of this alias
         *  @retval STRING $alias_destination
         */
        public function getDestination() {
            return $this->destination;
        }

        /** @brief  Sets the destination of this alias
         *  @param  STRING $destination
         *
         *  @todo: Check this against some RegEx to validate this!
         */
        public function setDestination($destination) {
            $this->destination = $destination;
            $this->modified = true;
        }


        /** @brief  The constructor
         *  @param  INT $id
         */
        public function __construct($id = NULL, $name = NULL, $domain_id = NULL, $destination = NULL) {
            
            $dao = new AliasDAO();

            if ( isset($id) ) {
                $tmp_data = $dao->getAliasByID($id);
            }
            elseif ( isset($name) && isset($domain_id) && isset($destination) ) {
                $tmp_data = $dao->getAliasByNameAndDomainID($name, $domain_id);

                if ( !$tmp_data ) {
                    $dao->createAlias($name, $domain_id, $destination);
                    $tmp_data = $dao->getAliasByNameAndDomainID($name, $domain_id);
                }
            }

            /* fill the object */
            if ( $tmp_data ) {
                $this->alias_id = $tmp_data['alias_id'];
                $this->alias_name = $tmp_data['alias_name'];
                $this->domain_id = $tmp_data['domain_id'];
                $this->domain_name = $tmp_data['domain_name'];
                $this->destination = $tmp_data['destination'];
            }
        }


        /** @brief  The destructor
         *
         *  This function is called, when the object is destructed. In PHP
         *  objects get destructed, if all references to the object are deleted.
         *
         *  If the object has been changed in its lifecycle, this will perform
         *  an update of the database tables.
         */
        public function __destruct() {
            
            if ( $this->modified ) {
                $dao = new AliasDAO();
                $dao->updateAlias($this->alias_id, $this->alias_name, $this->domain_id, $this->destination);
            }
        }


        /** @brief  Deletes the alias object
         */
        public function delete() {

            $dao = new AliasDAO();
            $dao->deleteAliasByID($this->alias_id);
        }
    }


    /** @class  AliasList
     *  @brief  A list of alias ids
     */
    class AliasList implements Iterator {

        /** @brief  The constructor
         */
        public function __construct($domain = NULL) {

            $this->pos = 0;

            $dao = new AliasDAO();

            foreach( $dao->getAliasList($domain) as $tmp_id ) {
                $tmp_alias = new Alias($tmp_id);

                if ( $tmp_alias->getAliasID() == $tmp_id ) {
                    $this->list[] = $tmp_alias;
                }
            }
        }


        /*
         * The following stuff is required for the iterator interface
         */
        private $pos = 0;
        private $list = array();

        public function rewind() {
            $this->pos = 0;
        }

        public function current() {
            return $this->list[$this->pos];
        }

        public function key() {
            return $this->pos;
        }

        public function next() {
            ++$this->pos;
        }

        public function valid() {
            return isset($this->list[$this->pos]);
        }
    }

?>
