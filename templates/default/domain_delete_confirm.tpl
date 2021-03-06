{*
    domain_delete_confirm.tpl
*}
{extends file="layout.tpl"}
{block name="page_title"}Domains{/block}

{block name="layout_canvas"}
<div id="page_domain">
    <h3>Confirm Deletion of Domain &quot;{$DELETE_DOMAIN_NAME}&quot;</h3>
    <div id="page_domain_confirm_delete">
        <p>The deletion of <i>{$DELETE_DOMAIN_NAME}</i> will also delete <strong>{$DELETE_DOMAIN_USERS} mail accounts</strong> and <strong>{$DELETE_DOMAIN_ALIASES} mail aliases</strong>!</p>
{include file="form_domain_confirm_delete.tpl" DOMAIN_ID=$DELETE_DOMAIN_ID DOMAIN_NAME=$DELETE_DOMAIN_NAME}
    </div>
</div>
{/block}
