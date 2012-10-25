<?php

    /** @file   index.php
     *  @brief  TODO: insert smart description here!
     */


    /* fetch the FrontEnd */
    require_once('./engine/FrontEnd.class.php');
    $frontend = new FrontEnd();

    $frontend->display('home.tpl');

?>
