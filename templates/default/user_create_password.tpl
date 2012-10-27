{*
    user_create_password.tpl
*}
{extends file="user.tpl"}

{block name="user_content"}
<div id="user_create">
    <h3>Create New Address - Set Password</h3>
{include file="user_form_password.tpl" CREATE_USER_BUTTON_CAPTION="create user"}
</div>
{/block}
