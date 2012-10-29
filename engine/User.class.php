<?php

    /** @file   User.class.php
     *  @brief  Contains the classes that handle User objects
     */


    /* fetch the DAO */
    require_once('./engine/UserDAO.class.php');

    /* fetch the validator */
    require_once('./lib/validator.php');


    /** @class  User
     *  @brief  Represents a single User to be managed
     */
    class User {

        /** @brief  This variable controls, if a database update is neccessary
         *
         *  For the User class, this is only the case, if the functions
         *  setUserName and setDomainID() are used.
         *
         *  The acutal update to the DB will happen on object destruction. See
         *  __destruct() for further details.
         */
        private $modified = false;


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
         */
        private $username = NULL;

        /** @brief  Returns the user's name
         *  @retval STRING $username
         */
        public function getUserName() {
            return $this->username;
        }

        /** @brief  Sets the user's name
         *  @param  STRING $name
         *
         *  @todo: Error handling if illegal local-part is given!
         */
        public function setUserName($name) {

            $parsed = checkLocalAddress($name);

            if ( $parsed === false ) {
                // TODO: insert some smart error handling here!
                die('setUserName(): $name does not match mail-regex!');
            }

            $this->username = $parsed;
            $this->modified = true;
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

        /** @brief  Sets the user's domain ID
         *  @param  INT $domain
         */
        public function setDomainID($domain) {
            $this->domain_id = $domain;
            $this->modified = true;
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


        /** @brief  The constructor
         *  @param  INT $id
         *  @param  STRING $username
         *  @param  INT $domain_id
         *  @param  STRING $password
         *  @param  STRING $mail
         *
         *  The constructor can handle different modes to retrieve User objects:
         *      * retrieve a User by its $id
         *      * retrieve a User by its $username and $domain_id
         *      * retrieve a User by its $username and $domain_id and $password
         *      * retrieve a User by its $mail
         *
         *  To create a new User object, the method $username, $domain_id and
         *  $password is used.
         */
        public function __construct($id = NULL, $username = NULL, $domain_id = NULL, $password = NULL, $mail = NULL) {

            $dao = new UserDAO();

            if ( isset($id) ) {
                $tmp_data = $dao->getUserByID($id);
            }
            elseif ( isset($username) && isset($domain_id) && !isset($password) ) {
                $tmp_data = $dao->getUserByNameAndDomainID($username, $domain_id);
            }
            elseif ( isset($mail) ) {
                $tmp_data = $dao->getUserByMail($mail);
            }
            elseif ( isset($username) && isset($domain_id) && isset($password) ) {
                $tmp_data = $dao->getUserByNameDomainIDAndPassword($username, $domain_id, $password);

                if ( !$tmp_data ) {
                    /* here we create new users!
                     * Make sure to check the username against our RegEx. No
                     * need to check the $domain_id, because the FK constraint
                     * of the database will only allow valid numbers here.
                     */

                    $parsed_name = checkLocalAddress($username);
                    if ( $parsed_name === false ) {
                        // TODO: insert smart error handling here!
                        die('__construct() - mode createUser(): $username does not match mail-regex');
                    }

                    $dao->createUser($parsed_name, $domain_id, $password);
                    $tmp_data = $dao->getUserByNameDomainIDAndPassword($parsed_name, $domain_id, $password);
                }
            }

            /* fill the object */
            if ( $tmp_data ) {
                $this->user_id = $tmp_data['user_id'];
                $this->username = $tmp_data['username'];
                $this->domain_id = $tmp_data['domain_id'];
                $this->domain_name = $tmp_data['domain_name'];
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
                $dao = new UserDAO();
                $dao->updateUser($this->user_id, $this->username, $this->domain_id);
            }
        }


        /** @brief  Deletes this user from the database
         */
        public function delete() {
            
            $dao = new UserDAO();
            $dao->deleteUserByID($this->user_id);
        }


        /** @brief  Sets the user's password
         *  @param  STRING $password
         */
        public function setPassword($password) {
            
            $dao = new UserDAO();
            $dao->setPasswordByID($this->user_id, $password);
        }
    }


    /** @class  UserList
     *  @brief  A list of user ids
     */
    class UserList implements Iterator {

        /** @brief  The constructor
         */
        public function __construct($domain = NULL) {

            $this->pos = 0;

            $dao = new UserDAO();

            foreach( $dao->getUserList($domain) as $tmp_id ) {
                $tmp_user = new User($tmp_id);

                if ( $tmp_user->getUserID() == $tmp_id ) {
                    $this->list[] = $tmp_user;
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
