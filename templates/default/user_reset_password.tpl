{*
    user_reset_password.tpl
*}
{extends file="user.tpl"}

{block name="user_content"}
<div id="user_resetpassword">
    <h3>Reset Password</h3>

    <p>Set new password for {$RESETPASSWORD_NAME}!</p>
    <div id="resetpassword_form_box">
{include file="form_user_reset_password.tpl"}
    </div>
</div>
{/block}
