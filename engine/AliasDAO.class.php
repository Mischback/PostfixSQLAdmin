<?php

    /** @file   AliasDAO.class.php
     *  @brief  Contains the data access layer for Alias objects
     */


    /* fetch the database */
    require_once('./lib/Database.class.php');


    /** @class  AliasDAO
     *  @brief  Handles everything to make Alias objects persistent
     */
    class AliasDAO {

        /** @brief  Fetches all information about an alias specified by $id
         *  @param  INT $id
         *  @retval MIXED
         */
        public function getAliasByID($id) {
            return $this->getAlias('a.alias_id = ?', $id);
        }

        /** @brief  Fetches all information about an alias specified by $name and $domain_id
         *  @param  STRING $name
         *  @param  INT $domain_id
         *  @retval MIXED
         */
        public function getAliasByNameAndDomainID($name, $domain_id) {
            return $this->getAlias('a.aliasname = ? AND a.domain_id = ?', array($name, $domain_id));
        }

        /** @brief  Generic function to retrieve an alias
         *  @param  STRING $where The part of the where-clause that matters
         *  @param  MIXED $param
         *  @retval MIXED
         */
        private function getAlias($where, $param) {

            $tmp_id = NULL;
            $tmp_name = NULL;
            $tmp_domain_id = NULL;
            $tmp_domain_name = NULL;
            $tmp_destination = NULL;

            /* connect to the database */
            $db = new Database();

            /* prepare the statement */
            $sql = 'SELECT a.alias_id AS alias_id, a.domain_id AS domain_id, a.aliasname AS aliasname, b.domain_name AS domain_name, a.destination AS destination FROM aliases AS a, domains AS b WHERE a.domain_id = b.domain_id AND ';
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
            $db->BindColumn(1, $tmp_id);
            $db->BindColumn(2, $tmp_domain_id);
            $db->BindColumn(3, $tmp_name);
            $db->BindColumn(4, $tmp_domain_name);
            $db->BindColumn(5, $tmp_destination);

            /* fetch the result */
            $db->Fetch();

            /* terminate the connection */
            $db->Disconnect();

            /* check our results */
            if ( $tmp_id !== NULL && $tmp_name !== NULL && $tmp_domain_id !== NULL
                && $tmp_domain_name !== NULL && $tmp_destination !== NULL ) {
                return array(
                    'alias_id'      => $tmp_id,
                    'alias_name'    => $tmp_name,
                    'domain_id'     => $tmp_domain_id,
                    'domain_name'   => $tmp_domain_name,
                    'destination'   => $tmp_destination,
                );
            } else {
                return false;
            }
        }


        /** @brief  Fetches all available alias ids of a given domain
         *  @param  INT $domain
         *  @retval ARRAY
         */
        public function getAliasList($domain) {

            $result = array();

            /* connect to the database */
            $db = new Database();

            /* prepare the statment */
            $sql = 'SELECT a.alias_id FROM aliases AS a, domains AS b WHERE a.domain_id = b.domain_id';
            if ( $domain !== NULL ) {
                $sql .= ' WHERE domain_id = ?';
            }
            $sql .= ' ORDER BY b.domain_name, a.aliasname';
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


        /** @brief  Creates a new alias
         *  @param  STRING $name
         *  @param  INT $domain_id
         *  @param  STRING $destination
         */
        public function createAlias($name, $domain_id, $destination) {
            
            /* connect to the database */
            $db = new Database();

            /* prepare the statement */
            $db->Prepare('INSERT INTO aliases VALUES (NULL, ?, ?, ?)');

            /* bind the parameter */
            $db->BindParam(1, $domain_id);
            $db->BindParam(2, $name);
            $db->BindParam(3, $destination);

            /* execute the statement */
            $db->StmtExecute();

            /* terminate the connection */
            $db->Disconnect();
        }


        /** @brief  Deletes an existing alias
         *  @param  INT $id
         */
        public function deleteAliasByID($id) {

            /* connect to the database */
            $db = new Database();

            /* prepare the statement */
            $db->Prepare('DELETE FROM aliases WHERE alias_id = ? LIMIT 1');

            /* bind the parameter */
            $db->BindParam(1, $id);

            /* execute the statement */
            $db->StmtExecute();

            /* terminate the connection */
            $db->Disconnect();
        }


        /** @brief  Updates an existing alias
         *  @param  INT $id
         *  @param  STRING $name
         *  @param  INT $domain_id
         *  @param  STRING $destination
         */
        public function updateAlias($id, $name, $domain_id, $destination) {
        
            /* connect to the database */
            $db = new Database();

            /* prepare the statement */
            $db->Prepare('UPDATE aliases SET aliasname = ?, domain_id = ?, destination = ? WHERE alias_id = ? LIMIT 1');

            /* bind the parameter */
            $db->BindParam(1, $name);
            $db->BindParam(2, $domain_id);
            $db->BindParam(3, $destination);
            $db->BindParam(4, $id);

            /* execute the statement */
            $db->StmtExecute();

            /* terminate the connection */
            $db->Disconnect();
        }
    }

?>
