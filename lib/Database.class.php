<?php

    /** @file   Database.class.php
     *  @brief  Contains the database interface
     */


    define('SETTING_DATABASE_MYSQL', 'mysql');
    define('SETTING_DATABASE_POSTGRE', 'postgre');


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


    /** @class  Database
     *  @brief  This class is used to access the database
     *
     *  The application will interact with this class. This class doesn't
     *  implement database access, it merely acts as an interface to real
     *  implementations.
     */
    class Database implements DatabaseInterface {

        /** @brief  The real implementation of the database access
         */
        private $engine = NULL;


        /** @brief  The constructor
         */
        public function __construct() {

            if ( CFG_DATABASE_PDO ) {
                require_once('./lib/DatabasePDO.class.php');

                if ( CFG_DATABASE_TYPE == SETTING_DATABASE_MYSQL ) {
                    $this->engine = DatabasePDOMySQL::getInstance();
                }
            }
        }


        public function Prepare($sql) {
            $this->engine->Prepare($sql);
        }

        public function BindParam($number, $val) {
            $this->engine->BindParam($number, $val);
        }

        public function BindColumn($number, &$var) {
            $this->engine->BindColumn($number, $var);
        }

        public function StmtExecute() {
            $this->engine->StmtExecute();
        }

        public function Fetch() {
            return $this->engine->Fetch();
        }

        public function Disconnect() {
            $this->engine->Disconnect();
        }
    }

?>
