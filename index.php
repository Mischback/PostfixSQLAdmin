<?php

    /** @file   index.php
     *  @brief  The main document. Handles static pages aswell.
     */


    /* fetch the FrontEnd */
    require_once('./engine/FrontEnd.class.php');
    $frontend = new FrontEnd();

    $frontend->display('home.tpl');

?>
