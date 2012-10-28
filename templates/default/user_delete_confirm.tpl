{*
    user_delete_confirm.tpl
*}
{extends file="layout.tpl"}
{block name="page_title"}Addresses{/block}

{block name="layout_canvas"}
<div id="page_user">
    <h3>Confirm Deletion of User &quot;{$DELETE_USER_MAIL}&quot;</h3>
    <div id="page_user_confirm_delete">
{include file="user_form_delete_confirm.tpl" USER_ID=$DELETE_USER_ID USER_MAIL=$DELETE_USER_MAIL}
    </div>
</div>
{/block}
