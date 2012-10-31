<?php

    /** @file   domain.php
     *  @brief  Handles all domain related stuff
     *
     *  This page is directly called by users. It manages all actions related
     *  to Domain objects. This includes creation, deletion and modification
     *  of Domain objects.
     */


    /* handle basic stuff */
    require_once('./lib/basic.php');


    /* we'll need the Domain object */
    require_once('./engine/Domain.class.php');


    /* MAGIC STARTS HERE! */

    /* CREATE new domain
     */
    if ( isset($_POST['create_domain_name']) && ($_POST['create_domain_name'] != '') ) {

        $tmp_dom = new Domain(NULL, $_POST['create_domain_name']);
    }


    /* DELETE existing domain
     * Deletion is splitted into two steps: 
     *      01: select the domain to delete
     *      02: confirm deletion
     */

    /* Step 01 */
    if ( isset($_POST['delete_domain_id']) && ($_POST['delete_domain_id'] != '') ) {

        $tmp_dom = new Domain($_POST['delete_domain_id']);

        /* validation */
        if ( $tmp_dom->getDomainID() != $_POST['delete_domain_id'] ) {
            // TODO: insert smart error handling here!
            die('Invalid domain ID!');
        }

        $_SESSION['delete_domain'] = $_POST['delete_domain_id'];

        $frontend->assign('DELETE_DOMAIN_ID', $_POST['delete_domain_id']);
        $frontend->assign('DELETE_DOMAIN_NAME', $tmp_dom->getDomainName());
        $frontend->assign('DELETE_DOMAIN_USERS', $tmp_dom->getUserCount());
        $frontend->assign('DELETE_DOMAIN_ALIASES', $tmp_dom->getAliasCount());
        $frontend->display('domain_delete_confirm.tpl');

        die;
    }

    /* Step 02 */
    if ( isset($_POST['delete_confirm_id']) && ($_POST['delete_confirm_id'] != '') ) {

        /* SECURITY CHECK
         * Do the given fields match the information of step 01?
         */
        if ( $_POST['delete_confirm_id'] != $_SESSION['delete_confirm'] ) {
            die('SECURITY BREAKING DETECTED!');
        }

        $tmp_dom = new Domain($_POST['delete_confirm_id']);
        $tmp_dom->deleteDomain();

        $_SESSION['delete_domain'] = NULL;
    }


    /* MODIFY existing domain
     * Modification is splitted into two steps:
     *      01: show the form to modify a domain
     *      02: make the necessary changes
     */

    /* Step 01 */
    if ( isset($_POST['modify_domain_id']) && ($_POST['modify_domain_id'] != '')
        && !isset($_POST['modify_domain_name']) ) {

        $tmp_dom = new Domain($_POST['modify_domain_id']);

        /* validation */
        if ( $tmp_dom->getDomainID() != $_POST['modify_domain_id'] ) {
            // TODO: insert smart error handling here!
            die('Invalid domain ID!');
        }

        $_SESSION['modify_domain'] = $_POST['modify_domain_id'];

        $frontend->assign('MODIFY_DOMAIN_ID', $_POST['modify_domain_id']);
        $frontend->assign('MODIFY_DOMAIN_NAME', $tmp_dom->getDomainName());
        $frontend->assign('MODIFY_DOMAIN_USERS', $tmp_dom->getUserCount());
        $frontend->assign('MODIFY_DOMAIN_ALIASES', $tmp_dom->getAliasCount());
        $frontend->display('domain_modify.tpl');

        die;
    }

    /* Step 02 */
    if ( isset($_POST['modify_domain_id']) && ($_POST['modify_domain_id'] != '')
        && isset($_POST['modify_domain_name']) && ($_POST['modify_domain_name'] != '') ) {

        /* SECURITY CHECK
         * Do the given fields match the information of step 01?
         */
        if ( $_POST['modify_domain_id'] != $_SESSION['modify_domain'] ) {
            die('SECURITY BREAKING DETECTED!');
        }

        $tmp_dom = new Domain($_POST['modify_domain_id']);
        $tmp_dom->setDomainName($_POST['modify_domain_name']);
        $tmp_dom = NULL;    /* force the update! TODO: without forced update strange things are happening! */

        $_SESSION['modify_domain'] = NULL;
    }


    /* list all available domains */
    $dom_list = array();
    foreach ( new DomainList() as $dom ) {
        $dom_list[] = array(
            'id'    => $dom->getDomainID(),
            'name'  => $dom->getDomainName(),
            'users' => $dom->getUserCount(),
            'aliases' => $dom->getAliasCount(),
        );
    }

    $frontend->assign('DOMAIN_LIST', $dom_list);
    $frontend->display('domain_overview.tpl');

?>
