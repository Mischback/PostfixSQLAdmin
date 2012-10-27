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

            $tmp_user_id = NULL;
            $tmp_domain_id = NULL;
            $tmp_username = NULL;
            $tmp_domain_name = NULL;
        
            /* connect to the database */
            $db = new Database();

            /* prepare the statment */
            $db->Prepare('SELECT a.user_id AS user_id, a.domain_id AS domain_id, a.username AS username, b.domain_name AS domain_name FROM users AS a, domains AS b WHERE a.domain_id = b.domain_id AND a.user_id = ? LIMIT 1');

            /* bind the parameter */
            $db->BindParam(1, $id);

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
    }

?>
