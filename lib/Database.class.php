<?php

    /** @file   Database.class.php
     *  @brief  Contains the database interface
     */


    /* fetch our config! */
    require_once('./config/config.inc.php');


    /** @class  DatabaseInterface
     *  @brief  The minimum set of functions a database implementation must provide
     */
    interface DatabaseInterface {

        /** @brief  Prepares a statement to be executed
         *  @param  $sql STRING  The statement to be prepared
         */
        public function Prepare($sql);

        /** @brief  Binds a single parameter to a placeholder in a statement
         *  @param  $number INT The number of the placeholder
         *  @param  $val MIXED  The parameter to be bound
         */
        public function BindParam($number, $val);

        /** @brief  Binds a variable to a column of the result set
         *  @param  $number INT The number of the column
         *  @param  $var MIXED  Reference of the variable to be used
         */
        public function BindColumn($number, &$var);

        /** @brief  Executes the statement
         */
        public function StmtExecute();

        /** @brief  Fetches a single row of the result set
         */
        public function Fetch();

        /** @brief  Disconnects
         */
        public function Disconnect();

    }

?>
