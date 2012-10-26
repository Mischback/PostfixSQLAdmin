<?php

    /** @file   domain.php
     *  @brief  Handles all domain related stuff
     */


    /* handle basic stuff */
    require_once('./lib/basic.php');


    /* we'll need the Domain object */
    require_once('./engine/Domain.class.php');


    /* MAGIC START HERE! */

    /* CREATE new domain
     */
    if ( isset($_POST['create_domain_name']) && ($_POST['create_domain_name'] != '') ) {

        $tmp_dom = new Domain(NULL, $_POST['create_domain_name']);
    }


    /* list all available domains */
    $dom_list = array();
    foreach ( new DomainList() as $dom ) {
        $dom_list[] = array(
            'id'    => $dom->getDomainID(),
            'name'  => $dom->getDomainName(),
            'users' => $dom->getUserCount(),
        );
    }

    $frontend->assign('DOMAIN_LIST', $dom_list);
    $frontend->display('domain_overview.tpl');

?>
