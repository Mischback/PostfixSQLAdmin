<?php

    /** @file   domain.php
     *  @brief  Handles all domain related stuff
     */


    /* we'll need the Domain object */
    require_once('./engine/Domain.class.php');


    /* list all available domains */

    foreach ( new DomainList() as $dom ) {
        echo $dom->getDomainName()."<br />\n";
    }

?>
