{*
    alias_delete_confirm.tpl
*}
{extends file="layout.tpl"}
{block name="page_title"}Aliases{/block}

{block name="layout_canvas"}
<div id="page_alias">
    <h3>Confirm Deletion of Alias &quot;{$DELETE_ALIAS_FULL}&quot;</h3>
    <div id="page_alias_confirm_delete">
{include file="form_alias_delete_confirm.tpl" USER_ID=$DELETE_ALIAS_ID USER_MAIL=$DELETE_ALIAS_FULL}
    </div>
</div>
{/block}
