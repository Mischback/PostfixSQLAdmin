<?php

    /** @file   alias.php
     *  @brief  Handles all alias related stuff
     */


    /* handle basic stuff */
    require_once('./lib/basic.php');


    /* Gentlemen, start your engines! */
    require_once('./engine/Alias.class.php');
    require_once('./engine/Domain.class.php');


    /* list aliases
     */
    $alias_list = array();
    if ( isset($_GET['domain']) && ($_GET['domain'] != '') ) {
        $tmp_list = new AliasList($_GET['domain']);
    } else {
        $tmp_list = new AliasList();
    }

    foreach ( $tmp_list as $alias ) {
        $alias_list[] = array(
            'alias_id'      => $alias->getAliasID(),
            'alias_name'    => $alias->getAliasName(),
            'domain_id'     => $alias->getDomainID(),
            'domain_name'   => $alias->getDomainName(),
            'destination'   => $alias->getDestination(),
        );
    }

    $dd_dom_list = array();
    foreach( new DomainList() as $dom ) {
        $dd_dom_list[] = array(
            'id'    => $dom->getDomainID(),
            'name'  => $dom->getDomainName(),
        );
    }

    $frontend->assign('ALIAS_LIST', $alias_list);
    $frontend->assign('DROPDOWN_DOMAIN_LIST', $dd_dom_list);
    $frontend->display('alias_overview.tpl');

?>
