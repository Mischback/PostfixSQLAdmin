<?php

    /** @file   user.php
     *  @brief  Handles all user related stuff
     */


    /* handle basic stuff */
    require_once('./lib/basic.php');


    /* Gentlemen, start your engines! */
    require_once('./engine/User.class.php');
    require_once('./engine/Domain.class.php');


    /* MAGIC STARTS HERE! */


    /* CREATE new user
     * Creation is splitted in two steps:
     *      01: specify the username and the domain
     *      02: create the new user with his password
     */

    /* step 01 */
    if ( isset($_POST['create_user_username']) && ($_POST['create_user_username'] != '')
        && isset($_POST['create_user_domain']) && ($_POST['create_user_domain'] != '') ) {

        if ( $_POST['create_user_domain'] === 'NULL') {
            /* no domain selected */
            // TODO: insert smart error handling here!
        }

        $tmp_user = new User(NULL, $_POST['create_user_username'], $_POST['create_user_domain']);

        if ( $tmp_user->getUserName() == $_POST['create_user_username']
            && $tmp_user->getDomainID() == $_POST['create_user_domain'] ) {
            /* user already exists! */
            // TODO: insert smart error handling here!
        } else {
            $frontend->assign('CREATE_USERNAME', $_POST['create_user_username']);
            $frontend->assign('CREATE_DOMAIN_ID', $_POST['create_user_domain']);
            $frontend->display('user_create_password.tpl');
            die;
        }
    }


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
