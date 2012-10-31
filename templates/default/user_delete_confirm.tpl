{*
    user_delete_confirm.tpl
*}
{extends file="layout.tpl"}
{block name="page_title"}Addresses{/block}

{block name="layout_canvas"}
<div id="page_user">
    <h3>Confirm Deletion of User &quot;{$DELETE_USER_MAIL}&quot;</h3>
{if isset($DELETE_USER_ALIAS)}
    <p>
This will also delete the following aliases:
{section name="row" loop=$DELETE_USER_ALIAS}
{$DELETE_USER_ALIAS[row]} 
{/section}
    </p>
{/if}
    <div id="page_user_confirm_delete">
{include file="form_user_confirm_delete.tpl" USER_ID=$DELETE_USER_ID USER_MAIL=$DELETE_USER_MAIL}
    </div>
</div>
{/block}
