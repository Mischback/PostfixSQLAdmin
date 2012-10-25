<?php

    /** @file   config.inc.php
     *  @brief  Contains configuration options
     */


    /** @brief  The skin
     *
     *  This is not only the name of the skin, but the folder inside the
     *  template directory
     */
    define('CFG_SKIN', 'default');


    /** @brief  A custom logo may be specified here
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
     */
    define('CFG_DATABASE_PDO', true);

    /** @brief  The host of the database
     */
    define('CFG_DATABASE_HOST', 'localhost');

    /** @brief  The user to connect to the database
     */
    define('CFG_DATABASE_USER', 'root');

    /** @brief  The database user's password
     */
    define('CFG_DATABASE_PASS', '');

    /** @brief  The name of the database
     */
    define('CFG_DATABASE_BASE', 'postfix');

?>
