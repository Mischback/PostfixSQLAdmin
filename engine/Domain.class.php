<?php

    /** @file   Domain.class.php
     *  @brief  Contains the classes that handle Domain objects.
     *
     *  This does not only include the Domain object, but the DomainList 
     *  aswell. See the documentation of these classes for details.
     */


    /* fetch the DAO */
    require_once('./engine/DomainDAO.class.php');

    /* fetch the validator */
    require_once('./lib/validator.php');


    /** @class  Domain
     *  @brief  Represents a single Domain to be managed
     *
     *  Domains are one of the core elements of the application. User objects 
     *  are bound to a Domain object.
     *
     *  In regard of the mail transport, Domain objects represent the domain
     *  part of the eMail-address, thus, everything after \@.
     */
    class Domain {

        /** @brief  This variable controls, if a database update is neccessary
         *
         *  For the Domain class, this is only the case, if the function 
         *  setDomainName() is used.
         *
         *  The acutal update to the DB will happen on object destruction. See
         *  __destruct() for further details.
         */
        private $modified = false;


        /** @brief  The domain's ID
         */
        private $domain_id = NULL;

        /** @brief  Returns the domain's ID
         *  @retval INT $domain_id
         */
        public function getDomainID() {
            return $this->domain_id;
        }


        /** @brief  The domain's name
         */
        private $domain_name = NULL;

        /** @brief  Returns the domain's name
         *  @retval STRING $domain_name
         */
        public function getDomainName() {
            return $this->domain_name;
        }

        /** @brief  Sets the domain's name
         *  @param  STRING $name
         *  @todo   Error handling if illegal domain-part is given!
         */
        public function setDomainName($name) {

            $parsed = checkDomain($name);

            if ( $parsed === false ) {
                // TODO: insert some smart error handling here!
                die('setDomainName(): $name does not match domain-regex!');
            }

            $this->domain_name = $parsed;
            $this->modified = true;
        }


        /** @brief  The number of users of this domain
         */
        private $domain_user_count = NULL;

        /** @brief Returns the domain's user count
         *  @retval INT $domain_user_count
         */
        public function getUserCount() {
            return $this->domain_user_count;
        }


        /** @brief  The number of aliases of this domain
         */
        private $domain_alias_count = NULL;

        /** @brief  Returns the domain's alias count
         *  @retval INT $domain_alias_count
         */
        public function getAliasCount() {
            return $this->domain_alias_count;
        }


        /** @brief  The constructor
         *  @param  INT $id
         *  @param  STRING $name
         *
         *  The constructor can handle three different modes:
         *      - retrieve a Domain by its $id
         *      - retrieve a Domain by its $name
         *      - create a new Domain with a given $name
         */
        public function __construct($id = NULL, $name = NULL) {

            $dao = new DomainDAO();

            if ( isset($id) ) {
                $tmp_data = $dao->getDomainByID($id);
            }
            elseif ( isset($name) ) {

                $parsed = checkDomain($name);

                if ( $parsed === false ) {
                    // TODO: insert smart error handling here!
                    die('__construct() - mode createDomain: $name does not match domain-regex!');
                }
                $tmp_data = $dao->getDomainByName($parsed);

                if ( !$tmp_data ) {
                    $dao->createDomain($parsed);
                    $tmp_data = $dao->getDomainByName($parsed);
                }
            }

            if ( $tmp_data ) {
                $this->domain_id = $tmp_data['id'];
                $this->domain_name = $tmp_data['name'];
                $this->domain_user_count = $tmp_data['users'];
                $this->domain_alias_count = $tmp_data['aliases'];
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
                $dao = new DomainDAO();
                $dao->updateDomain($this->domain_id, $this->domain_name);
            }
        }


        /** @brief  Deletes an object
         */
        public function deleteDomain() {
            $dao = new DomainDAO();
            $dao->deleteDomainByID($this->domain_id);
        }

    }


    /** @class  DomainList
     *  @brief  A list of all existing domain ids
     */
    class DomainList implements Iterator {

        /** @brief  The constructor
         */
        public function __construct() {

            $this->pos = 0;

            $dao = new DomainDAO();

            foreach( $dao->getDomainList() as $tmp_id ) {
                $tmp_dom = new Domain($tmp_id);

                if ( $tmp_dom->getDomainID() == $tmp_id ) {
                    $this->list[] = $tmp_dom;
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
