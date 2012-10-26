<?php

    /** @file   DatabasePDO.class.php
     *  @brief  Contains the implementations of the DatabaseInterface using PDO
     */


    /* fetch our config! */
    require_once('./config/config.inc.php');


    /** @class  DatabasePDO
     *  @brief  Abstract class of PDO implementation
     *
     *  PHP Data Objects (PDO) provide a consistent interface to access
     *  different types of databases. Because of the standardised interface
     *  provided by PDO, most of the implementation can be done in this
     *  abstract class.
     *
     *  To improve the performance, database connections are not closed 
     *  immediatly after finishing the request. 
     *
     *  The connections are reused. For this purpose a list of instances
     *  ($intanceList) is kept. When a statement is finished, it will be marked
     *  as available and can be used for another statement.
     *
     *  Of course, if a second connection is necessary, a second connection 
     *  will be created.
     */
    abstract class DatabasePDO implements DatabaseInterface {

        /** @brief  This array is used to manage multiple instances of the implementation
         *
         *  This is not really a Singleton, but it merely reduces the number of
         *  connections to the database server.
         *
         *  It relies on the $stmt attribute below. If it is NULL, it will be 
         *  assumed, that the connection is unused and this instance will be
         *  reused for the statement.
         *
         *  Make sure to call Disconnect after you completed a request, to free
         *  the $stmt variable.
         */
        private static $instanceList = NULL;

        /** @brief  Returns a instance of this class
         *
         *  It will reuse existing database connections or create new 
         *  connection, if there is no reusable connection.
         */
        public static function getInstance() {

            $className = get_called_class();

            /* there is no instance created yet */
            if ( self::$instanceList === NULL ) {
                self::$instanceList = array();
                self::$instanceList[] = new $className();
                return self::$instanceList[0];
            }

            /* look for a reusable instance */
            foreach ( self::$instanceList as $k => $v ) {
                if ( $v->stmt === NULL ) {
                    return $v;
                }
            }

            /* create a new instance */
            self::$instanceList[$k+1] = new $className();
            return self::$instanceList[$k+1];
        }


        /** @brief  The connection of this instance
         */
        protected $conn = NULL;

        /** @brief  The statement to be processed currently.
         */
        private $stmt = NULL;


        /** @brief  The constructor
         *
         *  No magic here, because it merely prepares the establishing of a
         *  connection, but doesn't perform the real connect.
         */
        private function __construct() {
            
            $this->host = CFG_DATABASE_HOST;
            $this->user = CFG_DATABASE_USER;
            $this->pass = CFG_DATABASE_PASS;
            $this->base = CFG_DATABASE_BASE;

            $this->connect();
        }


        /** @brief  Prepares a statement
         *
         *  @todo   some error handling here?
         */
        public function Prepare($sql) {
            $this->stmt = $this->conn->prepare($sql);
        }

        /** @brief  Binds a parameter to a statement's placeholder
         *
         *  @todo   some error handling here?
         */
        public function BindParam($number, $var, $type = PDO::PARAM_STR) {
            $this->stmt->bindValue($number, $var, $type);
        }

        /** @brief  Binds a result column to a variable
         *
         *  @todo   some error handling here?
         */
        public function BindColumn($number, &$var) {
            $this->stmt->bindColumn($number, $var);
        }

        /** @brief  Executes a prepared statement
         *
         *  @todo   some error handling here?
         */
        public function StmtExecute() {
            $this->stmt->execute();
        }

        /** @brief  Fetches a row of the results
         *
         *  @todo   some error handling here?
         */
        public function Fetch($type = PDO::FETCH_BOUND) {
            return $this->stmt->fetch($type);
        }

        /** @brief  Resets the statement and frees this connection
         *
         *  The name of the function is misleading. Actually it only assures, 
         *  that this connection can be used by another statement.
         *
         *  Make sure to call this function after a finished statment.
         *
         *  @todo   some error handling here?
         */
        public function Disconnect() {
            $this->stmt = NULL;
        }

        protected abstract function connect();
    }


    /** @class  DatabasePDOMySQL
     *  @brief  The DatabasePDO implementation for MySQL
     */
    class DatabasePDOMySQL extends DatabasePDO {


        /** @brief  Performs the connect to a MySQL database using PDO
         *
         *  @todo   some error handling here?
         */
        protected function connect() {
    		$this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->base, $this->user, $this->pass);
        }
    }
?>
