<?php

    /** @file   DomainDAO.class.php
     *  @brief  Contains the data access layer for Domain objects
     */


    /* fetch the database */
    require_once('./lib/Database.class.php');


    /* define the necessary statements */


    /** @class  DomainDAO
     *  @brief  Handles everything to make Domain objects persistent
     */
    class DomainDAO {

        /** @brief  Fetches all information about a domain specified by $id
         *  @param  INT $id
         */
        public function getDomainByID($id) {
            return $this->getDomain('SELECT a.domain_id AS id, a.domain_name AS name, COUNT(b.user_id) AS users FROM domains AS a LEFT JOIN users AS b ON (a.domain_id = b.domain_id) WHERE a.domain_id = ? GROUP BY (a.domain_id) LIMIT 1', $id);
        }

        /** @brief  Fetches all information about a domain specified by $name
         *  @param  STRING $name
         */
        public function getDomainByName($name) {
            return $this->getDomain('SELECT a.domain_id AS id, a.domain_name AS name, COUNT(b.user_id) AS users FROM domains AS a LEFT JOIN users AS b ON (a.domain_id = b.domain_id) WHERE a.domain_name = ? GROUP BY (a.domain_id) LIMIT 1', $name);
        }

        /** @brief  Generic function to retrieve a single domain
         *  @param  STRING $sql The SQL-statement to use
         *  @param  MIXED $param
         */
        private function getDomain($sql, $param) {

            $tmp_id = NULL;
            $tmp_name = NULL;
            $tmp_users = NULL;

            /* connect to the database */
            $db = new Database();

            /* prepare the statment */
            $db->Prepare($sql);

            /* bind the parameter */
            $db->BindParam(1, $param);

            /* execute the statement */
            $db->StmtExecute();

            /* bind variables to the result columns */
            $db->BindColumn(1, $tmp_id);
            $db->BindColumn(2, $tmp_name);
            $db->BindColumn(3, $tmp_users);

            /* fetch the result */
            $db->Fetch();

            /* terminate the connection */
            $db->Disconnect();

            /* check our results */
            if ( $tmp_id !== NULL && $tmp_name !== NULL && $tmp_users !== NULL ) {
                return array('id'=>$tmp_id, 'name'=>$tmp_name, 'users'=>$tmp_users);
            } else {
                return false;
            }
        }


        /** @brief  Fetches all available domain ids
         */
        public function getDomainList() {

            $result = array();

            /* connect to the database */
            $db = new Database();

            /* prepare the statment */
            $db->Prepare('SELECT domain_id FROM domains ORDER BY domain_name');

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
    }

?>
