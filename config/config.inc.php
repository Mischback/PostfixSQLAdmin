<?php

    /** @file   config.inc.php
     *  @brief  Contains configuration options
     *
     *  The application is customizable by this configuration file.
     *
     *  You will have to make certain changes, to tie the application to your
     *  installation.
     */


    /** @brief  The skin
     *
     *  This is not only the name of the skin, but the folder inside the
     *  template directory
     */
    define('CFG_SKIN', 'default');


    /* @brief  A custom logo may be specified here
     */
    // define('CFG_LOGO', 'logo.jpg');


    /** @brief  The path to the Smarty library
     *
     *  This specifies the path to the Smarty library.
     *
     *  You should only adjust this, if you have installed Smarty to a different
     *  location
     */
    define('CFG_SMARTY_PATH', './lib/smarty/');


    /** @brief  Controls, which database type should be used
     *
     *  Possible values are:
     *      * mysql
     *      * postgre TODO: not yet implemented
     */
    define('CFG_DATABASE_TYPE', 'mysql');

    /** @brief  Toggle the usage of PDO
     *
     *  By default, the application relies on PHP Data Objects (PDO). If you 
     *  don't want to use PDO, set this to false.
     *
     *  Possible values:
     *      * true
     *      * false
     */
    define('CFG_DATABASE_PDO', true);

    /** @brief  The host of the database
     *
     *  Specify the host of your database server. You can specify it as
     *  IP-address or DNS-name.
     *
     *  In most cases 'localhost' will be correct.
     */
    define('CFG_DATABASE_HOST', 'localhost');

    /** @brief  The user to connect to the database
     *
     *  Specify the user to use for the database connection.
     *
     *  DO NOT USE your database root-account!
     *
     *  The application will need the following privileges for its database
     *  access:
     *      * SELECT
     *      * UPDATE
     *      * INSERT
     *      * DELETE
     *
     *  It is highly recommended to create a specific user for the application!
     */
    define('CFG_DATABASE_USER', 'root');

    /** @brief  The database user's password
     *
     *  The password of the user specified by CFG_DATABASE_USER
     */
    define('CFG_DATABASE_PASS', '');

    /** @brief  The name of the database
     *
     *  This must be the database, that is used by your Postfix
     */
    define('CFG_DATABASE_BASE', 'postfix');

?>
