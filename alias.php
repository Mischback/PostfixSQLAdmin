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


    /* DELETE EXISTING ALIAS
     * Deletion is splitted in two steps:
     *      01: select the alias to be deleted
     *      02: confirm deletion
     */

    /* step 01 */
    if ( isset($_POST['delete_alias_id']) && ($_POST['delete_alias_id'] != '') ) {

        $tmp_alias = new Alias($_POST['delete_alias_id']);

        /* validation */
        if ( $tmp_alias->getAliasID() != $_POST['delete_alias_id'] ) {
            // TODO: insert smart error handling here!
            die('Invalid alias ID');
        }

        /* store the necessary information in the session */
        $_SESSION['delete_alias'] = $_POST['delete_alias_id'];

        /* prepare the display of step 02 */
        $frontend->assign('DELETE_ALIAS_ID', $_POST['delete_alias_id']);
        $frontend->assign('DELETE_ALIAS_FULL', $tmp_alias->getAlias());
        $frontend->assign('DELETE_ALIAS_DESTINATION', $tmp_alias->getDestination());
        $frontend->display('alias_delete_confirm.tpl');

        die;
    }

    /* step 02 */
    if ( isset($_POST['delete_confirm_id']) && ($_POST['delete_confirm_id'] != '') ) {

        /* SECURITY CHECK
         * Do the given fields match the information of step 01?
         */
        if ( $_POST['delete_confirm_id'] != $_SESSION['delete_alias'] ) {
            die('SECURITY BREAKING DETECTED!');
        }

        $tmp_alias = new Alias($_POST['delete_confirm_id']);

        /* this will delete this alias */
        $tmp_alias->delete();

        /* get rid of the session backup */
        $_SESSION['delete_alias'] = NULL;
    }


    /* MODIFY EXISTING ALIAS
     * Modification is splitted in tow steps:
     *      01: select the alias to be modified
     *      02: make changes
     */

    /* step 01 */
    if ( isset($_POST['modify_alias_id']) && ($_POST['modify_alias_id'] != '')
        && !isset($_POST['modify_alias_name']) && !isset($_POST['modify_alias_domain'])
        && !isset($_POST['modify_alias_destination']) ) {

        $tmp_alias = new Alias($_POST['modify_alias_id']);

        /* validation */
        if ( $tmp_alias->getAliasID() != $_POST['modify_alias_id'] ) {
            // TODO: insert smart error handling here!
            die('Invalid alias ID');
        }

        /* store the necessary information in the session */
        $_SESSION['modify_alias'] = $_POST['modify_alias_id'];

        /* prepare the display of step 02 */
        $dd_dom_list = array();
        foreach( new DomainList() as $dom ) {
            $dd_dom_list[] = array(
                'id'    => $dom->getDomainID(),
                'name'  => $dom->getDomainName(),
            );
        }
        $frontend->assign('MODIFY_ALIAS_DOMAIN_DD', $dd_dom_list);

        /* prepare the display of step 02 */
        $frontend->assign('MODIFY_ALIAS_ID', $_POST['modify_alias_id']);
        $frontend->assign('MODIFY_ALIAS_NAME', $tmp_alias->getAliasName());
        $frontend->assign('MODIFY_ALIAS_DOMAIN', $tmp_alias->getDomainID());
        $frontend->assign('MODIFY_ALIAS_DESTINATION', $tmp_alias->getDestination());
        $frontend->display('alias_modify.tpl');

        die;
    }

    /* step 02 */
    if ( isset($_POST['modify_alias_id']) && ($_POST['modify_alias_id'] != '')
        && isset($_POST['modify_alias_name']) && ($_POST['modify_alias_name'] != '')
        && isset($_POST['modify_alias_domain']) && ($_POST['modify_alias_domain'] != '')
        && isset($_POST['modify_alias_destination']) && ($_POST['modify_alias_destination'] != '') ) {

        /* SECURITY CHECK
         * Do the given fields match the information of step 01?
         */
        if ( $_POST['modify_alias_id'] != $_SESSION['modify_alias'] ) {
            die('SECURITY BREAKING DETECTED!');
        }

        $tmp_alias = new Alias($_POST['modify_alias_id']);

        /* make the changes to the alias object */
        $tmp_alias->setAliasName($_POST['modify_alias_name']);
        $tmp_alias->setDomainID($_POST['modify_alias_domain']);
        $tmp_alias->setDestination($_POST['modify_alias_destination']);

        $tmp_alias = NULL;
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
