<?php

    /** @file   domain.php
     *  @brief  Handles all domain related stuff
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
        if ( $tmp_dom->getDomainID() == $_POST['delete_domain_id'] ) {
            $frontend->assign('DELETE_DOMAIN_ID', $_POST['delete_domain_id']);
            $frontend->assign('DELETE_DOMAIN_NAME', $tmp_dom->getDomainName());
            $frontend->assign('DELETE_DOMAIN_USERS', $tmp_dom->getUserCount());
            $frontend->display('domain_delete_confirm.tpl');
            die;
        } else {
            // TODO: insert smart error handling here!
        }
    }

    /* Step 02 */
    if ( isset($_POST['delete_confirm_id']) && ($_POST['delete_confirm_id'] != '') ) {

        $tmp_dom = new Domain($_POST['delete_confirm_id']);

        /* validation */
        if ( $tmp_dom->getDomainID() == $_POST['delete_confirm_id'] ) {
            $tmp_dom->deleteDomain();
        } else {
            // TODO: insert smart error handling here!
        }
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
