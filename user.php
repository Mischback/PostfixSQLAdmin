<?php

    /** @file   user.php
     *  @brief  Handles all user related stuff
     */


    /* handle basic stuff */
    require_once('./lib/basic.php');


    /* Gentlemen, start your engines! */
    require_once('./engine/User.class.php');
    require_once('./engine/Domain.class.php');


    /* list users
     *
     */
    $user_list = array();
    if ( isset($_GET['domain']) && ($_GET['domain'] != '') ) {
        $tmp_list = new UserList($_GET['domain']);
    } else {
        $tmp_list = new UserList();
    }

    foreach( $tmp_list as $user ) {
        $user_list[] = array(
            'user_id'       => $user->getUserID(),
            'username'      => $user->getUserName(),
            'usermail'      => $user->getUserMail(),
            'domain_id'     => $user->getDomainID(),
            'domain_name'   => $user->getDomainName(),
        );
    }

    $dd_dom_list = array();
    foreach( new DomainList() as $dom ) {
        $dd_dom_list[] = array(
            'id'    => $dom->getDomainID(),
            'name'  => $dom->getDomainName(),
        );
    }

    $frontend->assign('USER_LIST', $user_list);
    $frontend->assign('DROPDOWN_DOMAIN_LIST', $dd_dom_list);
    $frontend->display('user_overview.tpl');
?>
