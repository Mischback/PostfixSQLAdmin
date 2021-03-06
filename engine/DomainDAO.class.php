<?php

    /** @file   DomainDAO.class.php
     *  @brief  Contains the data access layer for Domain objects
     */


    /* fetch the database */
    require_once('./lib/Database.class.php');


    /** @class  DomainDAO
     *  @brief  Handles everything to make Domain objects persistent
     *
     *  This class is the way, Domains interact with the database. All means
     *  of access are concentrated in this class.
     *
     *  You can find all necessary SQL-statement in this class aswell.
     */
    class DomainDAO {

        /** @brief  Fetches all information about a domain specified by $id
         *  @param  INT $id
         *  @retval MIXED
         */
        public function getDomainByID($id) {
            return $this->getDomain('a.domain_id = ?', $id);
        }

        /** @brief  Fetches all information about a domain specified by $name
         *  @param  STRING $name
         *  @retval MIXED
         */
        public function getDomainByName($name) {
            return $this->getDomain('a.domain_name = ?', $name);
        }

        /** @brief  Generic function to retrieve a single domain
         *  @param  STRING $where The WHERE part of the statement
         *  @param  MIXED $param
         *  @retval MIXED
         */
        private function getDomain($where, $param) {

            $tmp_id = NULL;
            $tmp_name = NULL;
            $tmp_users = NULL;
            $tmp_aliases = NULL;

            /* connect to the database */
            $db = new Database();

            /* prepare the statment */
            $sql = 'SELECT a.domain_id AS id, a.domain_name AS name, COUNT(b.user_id) AS users, COUNT(c.alias_id) AS aliases FROM domains AS a LEFT JOIN users AS b ON (a.domain_id = b.domain_id) LEFT JOIN aliases AS c ON (a.domain_id = c.domain_id) WHERE ';
            $sql .= $where;
            $sql .= ' GROUP BY (a.domain_id) LIMIT 1';
            $db->Prepare($sql);

            /* bind the parameter */
            $db->BindParam(1, $param);

            /* execute the statement */
            $db->StmtExecute();

            /* bind variables to the result columns */
            $db->BindColumn(1, $tmp_id);
            $db->BindColumn(2, $tmp_name);
            $db->BindColumn(3, $tmp_users);
            $db->BindColumn(4, $tmp_aliases);

            /* fetch the result */
            $db->Fetch();

            /* terminate the connection */
            $db->Disconnect();

            /* check our results */
            if ( $tmp_id !== NULL && $tmp_name !== NULL && $tmp_users !== NULL && $tmp_aliases !== NULL ) {
                return array('id'=>$tmp_id, 'name'=>$tmp_name, 'users'=>$tmp_users, 'aliases'=>$tmp_aliases);
            } else {
                return false;
            }
        }


        /** @brief  Fetches all available domain ids
         *  @retval ARRAY
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


        /** @brief  Creates a new domain
         *  @param  STRING $name
         */
        public function createDomain($name) {

            /* connect to the database */
            $db = new Database();

            /* prepare the statment */
            $db->Prepare('INSERT INTO domains VALUES (NULL, ?)');

            /* bind the parameter */
            $db->BindParam(1, $name);

            /* execute the statement */
            $db->StmtExecute();

            /* terminate the connection */
            $db->Disconnect();
        }


        /** @brief  Deletes an existing domain by its id
         *  @param  INT $id
         */
        public function deleteDomainByID($id) {
            
            /* connect to the database */
            $db = new Database();

            /* prepare the statment */
            $db->Prepare('DELETE FROM domains WHERE domain_id = ? LIMIT 1');

            /* bind the parameter */
            $db->BindParam(1, $id);

            /* execute the statement */
            $db->StmtExecute();

            /* terminate the connection */
            $db->Disconnect();
        }


        /** @brief  Updates an existing domain
         *  @param  INT $id
         *  @param  STRING $name
         */
        public function updateDomain($id, $name) {
            
            /* connect to the database */
            $db = new Database();

            /* prepare the statment */
            $db->Prepare('UPDATE domains SET domain_name = ? WHERE domain_id = ? LIMIT 1');

            /* bind variables to the result columns */
            $db->BindParam(1, $name);
            $db->BindParam(2, $id);

            /* execute the statement */
            $db->StmtExecute();

            /* terminate the connection */
            $db->Disconnect();
        }
    }

?>
