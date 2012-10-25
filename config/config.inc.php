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

?>
