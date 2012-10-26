<?php

    /** @file   Domain.class.php
     *  @brief  TODO: insert smart description here!
     */


    /* fetch the DAO */
    require_once('./engine/DomainDAO.class.php');


    /** @class  Domain
     *  @brief  Represents a single Domain to be managed
     */
    class Domain {

        /** @brief  The domain's ID
         */
        private $domain_id = NULL;

        /** @brief  Returns the domain's ID
         */
        public function getDomainID() {
            return $this->domain_id;
        }


        /** @brief  The domain's name
         */
        private $domain_name = NULL;

        /** @brief  Returns the domain's name
         */
        public function getDomainName() {
            return $this->domain_name;
        }


        /** @brief  The number of users of this domain
         */
        private $domain_user_count = NULL;

        /** @brief Returns the domain's user count
         */
        public function getUserCount() {
            return $this->domain_user_count;
        }


        /** @brief  The constructor
         */
        public function __construct($id = NULL, $name = NULL) {

            $dao = new DomainDAO();

            if ( isset($id) ) {
                $tmp_data = $dao->getDomainByID($id);
            }
            elseif ( isset($name) ) {
                $tmp_data = $dao->getDomainByName($name);

                if ( !$tmp_data ) {
                    $dao->createDomain($name);
                    $tmp_data = $dao->getDomainByName($name);
                }
            }

            if ( $tmp_data ) {
                $this->domain_id = $tmp_data['id'];
                $this->domain_name = $tmp_data['name'];
                $this->domain_user_count = $tmp_data['users'];
            }
        }

    }


    /** @class  DomainList
     *  @brief  A list of all existing domains
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
