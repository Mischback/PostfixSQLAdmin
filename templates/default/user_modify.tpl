{*
    user_modify.tpl
*}
{extends file="user.tpl"}

{block name="user_content"}
<div id="user_modify">
    <h3>Modify User</h3>
{if isset($MODIFY_USER_ALIAS)}
    <p>
This will also affect the following aliases:
{section name="row" loop=$MODIFY_USER_ALIAS}
{$MODIFY_USER_ALIAS[row]} 
{/section}
    </p>
{/if}
    <div id="user_modify_form_box">
{include file="form_user_modify.tpl"}
    </div>
</div>
{/block}
