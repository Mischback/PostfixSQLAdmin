<?php

    /** @file   alias.php
     *  @brief  Handles all alias related stuff
     */


    /* handle basic stuff */
    require_once('./lib/basic.php');


    /* Gentlemen, start your engines! */
    require_once('./engine/Alias.class.php');
    require_once('./engine/Domain.class.php');


    /* CREATE NEW ALIAS
     */
    if ( isset($_POST['create_alias_name']) && ($_POST['create_alias_name'] != '')
        && isset($_POST['create_alias_domain']) && ($_POST['create_alias_domain'] != '')
        && isset($_POST['create_alias_destination']) && ($_POST['create_alias_destination'] != '') ) {

        if ( $_POST['create_alias_domain'] === 'NULL' ) {
            /* no domain selected */
            // TODO: insert smart error handling here!
            die('No domain given!');
        }

        /* validation */
        $tmp_alias = new Alias(NULL, $_POST['create_alias_name'], $_POST['create_alias_domain'], $_POST['create_alias_destination']);

        if ( $tmp_alias->getDestination() != $_POST['create_alias_destination'] ) {
            /* alias already exists! */
            // TODO: insert smart error handling here!
            die('Alias already exists!');
        }
    }


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
