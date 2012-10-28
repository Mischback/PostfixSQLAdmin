{*
    user_modify.tpl
*}
{extends file="user.tpl"}

{block name="user_content"}
<div id="user_modify">
    <h3>Modify User</h3>

    <div id="user_modify_form_box">
{include file="user_form_modification.tpl"}
    </div>
</div>
{/block}
