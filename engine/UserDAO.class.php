<?php

    /** @file   UserDAO.class.php
     *  @brief  Contains the data access layer for User objects
     */


    /* fetch the database */
    require_once('./lib/Database.class.php');


    /** @class  UserDAO
     *  @brief  Handles everything to make User objects persistent
     */
    class UserDAO {

        /** @brief  Fetches all information about a user specified by $id
         *  @param  INT $id
         *  @retval MIXED
         */
        public function getUserByID($id) {
            return $this->getUser('a.user_id = ?', $id);
        }

        /** @brief  Fetches all information about a user specified by $username and $domain_id
         *  @param  STRING $username
         *  @param  INT $domain_id
         *  @retval MIXED
         */
        public function getUserByNameAndDomainID($username, $domain_id) {
            return $this->getUser('a.username = ? AND a.domain_id = ?', array($username, $domain_id));
        }

        /** @brief  Fetches all information about a user by $username, $domain_id and $password
         *  @param  STRING $username
         *  @param  INT $domain_id
         *  @param  STRING $password
         *  @retval MIXED
         */
        public function getUserByNameDomainIDAndPassword($username, $domain_id, $password) {
            return $this->getUser('a.username = ? AND a.domain_id = ? AND a.password = MD5(?)', array($username, $domain_id, $password));
        }

        /** @brief  Fetches all information about a user specified by $mail
         *  @param  STRING $mail
         *  @retval MIXED
         *
         *  We assume, that $mail is a valid mail address and we will simply 
         *  split it at the '@' character.
         */
        public function getUserByMail($mail) {

            $tmp = explode('@', $mail);
            if ( count($tmp) != 2 ) {
                return false;
            }

            return $this->getUser('a.username = ? AND b.domain_name = ?', $tmp);
        }

        /** @brief  Generic function to retrieve a single user
         *  @param  STRING $where The part of the where-clause that matters
         *  @param  MIXED  $param
         *  @reval  MIXED
         */
        private function getUser($where, $param) {
        
            $tmp_user_id = NULL;
            $tmp_domain_id = NULL;
            $tmp_username = NULL;
            $tmp_domain_name = NULL;
        
            /* connect to the database */
            $db = new Database();

            /* prepare the statment */
            $sql = 'SELECT a.user_id AS user_id, a.domain_id AS domain_id, a.username AS username, b.domain_name AS domain_name FROM users AS a, domains AS b WHERE a.domain_id = b.domain_id AND ';
            $sql .= $where;
            $sql .= ' LIMIT 1';
            $db->Prepare($sql);

            /* bind the parameter */
            if ( is_array($param) ) {
                for ( $i = 0; $i < count($param); $i++ ) {
                    $db->BindParam($i+1, $param[$i]);
                }
            } else {
                $db->BindParam(1, $param);
            }

            /* execute the statement */
            $db->StmtExecute();

            /* bind variables to the result columns */
            $db->BindColumn(1, $tmp_user_id);
            $db->BindColumn(2, $tmp_domain_id);
            $db->BindColumn(3, $tmp_username);
            $db->BindColumn(4, $tmp_domain_name);

            /* fetch the result */
            $db->Fetch();

            /* terminate the connection */
            $db->Disconnect();

            /* check our results */
            if ( $tmp_user_id !== NULL && $tmp_domain_id !== NULL && $tmp_username !== NULL && $tmp_domain_name !== NULL ) {
                return array(
                    'user_id'       => $tmp_user_id,
                    'username'      => $tmp_username,
                    'domain_id'     => $tmp_domain_id,
                    'domain_name'   => $tmp_domain_name,
                );
            } else {
                return false;
            }
        }


        /** @brief  Fetches all availabe user ids of a given domain
         *  @param  INT $domain
         *  @retval ARRAY
         */
        public function getUserList($domain) {

            $result = array();

            /* connect to the database */
            $db = new Database();

            /* prepare the statment */
            $sql = 'SELECT a.user_id FROM users AS a, domains AS b WHERE a.domain_id = b.domain_id';
            if ( $domain !== NULL ) {
                $sql .= ' WHERE domain_id = ?';
            }
            $sql .= ' ORDER BY b.domain_name';
            $db->Prepare($sql);

            /* bind the parameter */
            if ( $domain !== NULL ) {
                $db->BindParam(1, $domain);
            }

            /* execute the statement */
            $db->StmtExecute();

            /* bind variables to the result columns */
            $db->BindColumn(1, $tmp_id);

            /* fetch the results */
            while ( $db->Fetch() ) {
                $result[] = $tmp_id;
            }

            /* terminate the connection */
            $db->Disconnect();

            return $result;
        }


        /** @brief  Creates a new user
         *  @param  STRING $username
         *  @param  INT $domain_id
         *  @param  STRING $password
         */
        public function createUser($username, $domain_id, $password) {

            /* connect to the database */
            $db = new Database();

            /* prepare the statment */
            $db->Prepare('INSERT INTO users VALUES (NULL, ?, ?, MD5(?))');

            /* bind the parameter */
            $db->BindParam(1, $domain_id);
            $db->BindParam(2, $username);
            $db->BindParam(3, $password);

            /* execute the statement */
            $db->StmtExecute();

            /* terminate the connection */
            $db->Disconnect();
        }
    }

?>
