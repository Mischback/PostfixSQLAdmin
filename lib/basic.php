<?php

    /** @file   basic.php
     *  @brief  Contains some boring but necessary stuff
     *
     *  These things are necessary for every page, that is meant to be 
     *  accessed directly.
     *
     *  It handles the FrontEnd and will be used for user identification.
     */


    /* we'll need a FrontEnd */
    require_once('./engine/FrontEnd.class.php');
    $frontend = new FrontEnd();

?>
