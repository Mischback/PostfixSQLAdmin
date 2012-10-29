{*
    user_create_password.tpl
*}
{extends file="user.tpl"}

{block name="user_content"}
<div id="user_create">
    <h3>Create New Address - Set Password</h3>

    <p>Assign a password for the new user!</p>
    <div id="user_create_form_box">
{include file="form_user_create_password.tpl" CREATE_USER_BUTTON_CAPTION="create user"}
    </div>
</div>
{/block}
