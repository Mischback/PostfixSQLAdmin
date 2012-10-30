{*
    alias_modify.tpl
*}
{extends file="alias.tpl"}

{block name="alias_content"}
<div id="alias_modify">
    <h3>Modify Alias</h3>

    <div id="alias_modify_form_box">
{include file="form_alias_modify.tpl"}
    </div>
</div>
{/block}
