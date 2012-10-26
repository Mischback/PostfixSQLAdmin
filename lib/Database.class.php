<?php

    /** @file   Database.class.php
     *  @brief  Contains the database interface
     */


    /** @brief  Constant to check settings from config.inc.php
     */
    define('SETTING_DATABASE_MYSQL', 'mysql');
    /** @brief  Constant to check settings from config.inc.php
     */
    define('SETTING_DATABASE_POSTGRE', 'postgre');


    /* fetch our config! */
    require_once('./config/config.inc.php');


    /** @class  DatabaseInterface
     *  @brief  The minimum set of functions a database implementation must provide
     *
     *  Database requests generally follow this sequence:
     *      - prepare the statement __Prepare()__
     *      - bind parameters to the placeholders __BindParam()__
     *      - execute the statement __StmtExecute()__
     *      - assign variables to the result columns __BindColumn()__
     *      - fetch the result's rows __Fetch()__
     *      - close the connection __Disconnect()__
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
         *
         *  Nothing to say here, just execute the statement.
         */
        public function StmtExecute();

        /** @brief  Fetches a single row of the result set
         *
         *  Returns __one__ row of the result set. If the result set contains
         *  more than one line, you have to call this function in a while-loop.
         */
        public function Fetch();

        /** @brief  Disconnects
         *
         *  Kills the database connection.
         *
         *  Please note, that this depends on the real implementation.
         */
        public function Disconnect();

    }


    /** @class  Database
     *  @brief  This class is used to access the database
     *
     *  The application will interact with this class. This class doesn't
     *  implement database access, it merely acts as an interface to real
     *  implementations.
     *
     *  The real implementation of the DatabaseInterface is fetched into the
     *  $engine attribute and then all methods are proxied to the real 
     *  implementation.
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
