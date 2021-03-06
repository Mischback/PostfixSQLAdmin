<?php

    /** @file   user.php
     *  @brief  Handles all user related stuff
     */


    /* handle basic stuff */
    require_once('./lib/basic.php');


    /* Gentlemen, start your engines! */
    require_once('./engine/Alias.class.php');
    require_once('./engine/Domain.class.php');
    require_once('./engine/User.class.php');


    /* MAGIC STARTS HERE! */

    /* CREATE new user
     * Creation is splitted in two steps:
     *      01: specify the username and the domain
     *      02: create the new user with his password
     */

    /* step 01 */
    if ( isset($_POST['create_user_username']) && ($_POST['create_user_username'] != '')
        && isset($_POST['create_user_domain']) && ($_POST['create_user_domain'] != '')
        && !isset($_POST['user_password']) ) {

        if ( $_POST['create_user_domain'] === 'NULL') {
            /* no domain selected */
            // TODO: insert smart error handling here!
            die('No domain given!');
        }

        /* validation */
        $tmp_alias = new Alias(NULL, $_POST['create_user_username'], $_POST['create_user_domain']);
        if ( $tmp_alias->getAliasID() !== NULL ) {
            // TODO: insert smart error handling here!
            die('Alias with same address already exists!');
        }

        $tmp_user = new User(NULL, $_POST['create_user_username'], $_POST['create_user_domain']);

        if ( $tmp_user->getUserName() == $_POST['create_user_username']
            && $tmp_user->getDomainID() == $_POST['create_user_domain'] ) {
            /* user already exists! */
            // TODO: insert smart error handling here!
            die('User already exists');
        }

        /* we store the necessary information in the session
         * This data is already validated and checked for plausibility.
         * We will use this to verify the information in step 02
         */
        $_SESSION['create_user'] = array(
            'username'  => $_POST['create_user_username'],
            'domain_id' => $_POST['create_user_domain'],
        );

        /* prepare the display of step 02 */
        $frontend->assign('CREATE_USERNAME', $_POST['create_user_username']);
        $frontend->assign('CREATE_DOMAIN_ID', $_POST['create_user_domain']);
        $frontend->display('user_create_password.tpl');

        die;
    }

    /* step 02 */
    if ( isset($_POST['create_user_username']) && ($_POST['create_user_username'] != '')
        && isset($_POST['create_user_domain']) && ($_POST['create_user_domain'] != '')
        && isset($_POST['user_password']) && ($_POST['user_password'] != '') ) {

        /* SECURITY CHECK
         * Do the given fields match the information of step 01?
         */
        if ( $_POST['create_user_username'] != $_SESSION['create_user']['username']
            || $_POST['create_user_domain'] != $_SESSION['create_user']['domain_id']) {
            /* SECURITY BREAK: POST don't match SESSION */
            die('SECURITY BREAKING DETECTED!');
        }

        /* this should create a new user! */
        $tmp_user = new User(NULL, $_POST['create_user_username'], $_POST['create_user_domain'], $_POST['user_password']);

        if ( $tmp_user->getUserID() === NULL ) {
            // TODO: insert smart error handling here!
            die('User could not be created!');
        }

        /* get rid of the session backup */
        $_SESSION['create_user'] = NULL;
    }


    /* DELETE existing user
     * Deletion is splitted in two steps
     *      01: select the user to be deleted
     *      02: confirm deletion
     */

    /* step 01 */
    if ( isset($_POST['delete_user_id']) && ($_POST['delete_user_id'] != '') ) {

        $tmp_user = new User($_POST['delete_user_id']);

        /* validation */
        if ( $tmp_user->getUserID() != $_POST['delete_user_id'] ) {
            // TODO: insert smart error handling here!
            die('Invalid user ID!');
        }

        /* we store the necessary information in the session
         * We will use this to verify the information in step 02
         */
        $_SESSION['delete_user'] = $_POST['delete_user_id'];

        /* Will this affect any aliases? */
        $alias_list = new AliasList(NULL, $tmp_user->getUserMail());
        if ( count($alias_list) !== 0 ) {
            $del_user_alias = array();
            foreach ( $alias_list as $tmp_alias ) {
                $del_user_alias[] = $tmp_alias->getAlias();
            }
            $frontend->assign('DELETE_USER_ALIAS', $del_user_alias);
        }

        /* prepare the display of step 02 */
        $frontend->assign('DELETE_USER_ID', $_POST['delete_user_id']);
        $frontend->assign('DELETE_USER_MAIL', $tmp_user->getUserMail());
        $frontend->display('user_delete_confirm.tpl');

        die;
    }

    /* step 02 */
    if ( isset($_POST['delete_confirm_id']) && ($_POST['delete_confirm_id'] != '') ) {

        /* SECURITY CHECK
         * Do the given fields match the information of step 01?
         */
        if ( $_POST['delete_confirm_id'] != $_SESSION['delete_user'] ) {
            die('SECURITY BREAKING DETECTED!');
        }

        $tmp_user = new User($_POST['delete_confirm_id']);

        /* delete all corresponding aliases */
        $alias_list = new AliasList(NULL, $tmp_user->getUserMail());
        if ( count($alias_list) !== 0 ) {
            foreach ( $alias_list as $tmp_alias ) {
                $tmp_alias->delete();
            }
        }

        /* this will delete this user */
        $tmp_user->delete();

        /* get rid of the session backup */
        $_SESSION['delete_user'] = NULL;
    }


    /* MODIFY existing user
     * Modification is splitted in two steps
     *      01: select the user to be modified
     *      02: make the changes
     */

    /* step 01 */
    if ( isset($_POST['modify_user_id']) && ($_POST['modify_user_id'] != '')
        && !isset($_POST['modify_user_name']) && !isset($_POST['modify_user_domain']) ) {

        $tmp_user = new User($_POST['modify_user_id']);

        /* validation */
        if ( $tmp_user->getUserID() != $_POST['modify_user_id'] ) {
            // TODO: insert smart error handling here!
            die('Invalid user ID!');
        }

        /* we store the necessary information in the session
         * We will use this to verify the information in step 02
         */
        $_SESSION['modify_user'] = $_POST['modify_user_id'];

        /* Will this affect any aliases? */
        $alias_list = new AliasList(NULL, $tmp_user->getUserMail());
        if ( count($alias_list) !== 0 ) {
            $modify_user_alias = array();
            foreach ( $alias_list as $tmp_alias ) {
                $modify_user_alias[] = $tmp_alias->getAlias();
            }
            $frontend->assign('MODIFY_USER_ALIAS', $modify_user_alias);
        }

        /* prepare the display of step 02 */
        $dd_dom_list = array();
        foreach( new DomainList() as $dom ) {
            $dd_dom_list[] = array(
                'id'    => $dom->getDomainID(),
                'name'  => $dom->getDomainName(),
            );
        }
        $frontend->assign('MODIFY_USER_DOMAIN_DD', $dd_dom_list);

        $frontend->assign('MODIFY_USER_ID', $_POST['modify_user_id']);
        $frontend->assign('MODIFY_USER_NAME', $tmp_user->getUserName());
        $frontend->assign('MODIFY_USER_DOMAIN', $tmp_user->getDomainID());
        $frontend->display('user_modify.tpl');

        die;
    }

    /* step 02 */
    if ( isset($_POST['modify_user_id']) && ($_POST['modify_user_id'] != '')
        && isset($_POST['modify_user_name']) && ($_POST['modify_user_name'] != '')
        && isset($_POST['modify_user_domain']) && ($_POST['modify_user_domain'] != '') ) {

        /* SECURITY CHECK
         * Do the given fields match the information of step 01?
         */
        if ( $_POST['modify_user_id'] != $_SESSION['modify_user'] ) {
            die('SECURITY BREAKING DETECTED!');
        }

        $tmp_alias = new Alias(NULL, $_POST['modify_user_name'], $_POST['modify_user_domain']);
        if ( $tmp_alias->getAliasID() !== NULL ) {
            // TODO: insert smart error handling here!
            die('Alias with same address already exists!');
        }

        $tmp_user = new User($_POST['modify_user_id']);

        /* fetch the corresponding alias list */
        $alias_list = new AliasList(NULL, $tmp_user->getUserMail());

        /* make the changes to the user object */
        $tmp_user->setUserName($_POST['modify_user_name']);
        $tmp_user->setDomainID($_POST['modify_user_domain']);

        /* modify all corresponding aliases */
        if ( count($alias_list) !== 0 ) {
            foreach ( $alias_list as $tmp_alias ) {
                $tmp_alias->setDestination($tmp_user->getUserMail());
                $tmp_alias = NULL;
            }
            $alias_list = NULL;
        }

        $tmp_user = NULL;   /* force update of the user object */

        /* get rid of the session backup */
        $_SESSION['modify_user'] = NULL;
    }


    /* RESET PASSWORDS
     * Resetting is splitted in two steps:
     *      01: Select the account to reset the password
     *      02: Assign new password
     */

    /* step 01 */
    if ( isset($_POST['resetpassword_id']) && ($_POST['resetpassword_id'] != '')
        && !isset($_POST['resetpassword_password']) ) {

        /* validation */
        $tmp_user = new User($_POST['resetpassword_id']);

        if ( $tmp_user->getUserID() != $_POST['resetpassword_id'] ) {
            // TODO: insert smart error handling here!
            die('Invalid user ID!');
        }

        /* we store the necessary information in the session */
        $_SESSION['resetpassword'] = $_POST['resetpassword_id'];

        $frontend->assign('RESETPASSWORD_ID', $_POST['resetpassword_id']);
        $frontend->assign('RESETPASSWORD_NAME', $tmp_user->getUserMail());
        $frontend->display('user_reset_password.tpl');
        die;
    }

    /* step 02 */
    if ( isset($_POST['resetpassword_id']) && ($_POST['resetpassword_id'] != '')
        && isset($_POST['resetpassword_password']) && ($_POST['resetpassword_password'] != '') ) {

        /* SECURITY CHECK
         * Do the given fields match the information of step 01?
         */
        if ( $_POST['resetpassword_id'] != $_SESSION['resetpassword']) {
            die('SECURITY BREAKING DETECTED!');
        }

        /* set the new password */
        $tmp_user = new User($_POST['resetpassword_id']);
        $tmp_user->setPassword($_POST['resetpassword_password']);

        /* get rid of the session backup */
        $_SESSION['resetpassword'] = NULL;
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
