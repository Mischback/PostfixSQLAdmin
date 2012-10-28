{*
    user_resetpassword.tpl
*}
{extends file="user.tpl"}

{block name="user_content"}
<div id="user_resetpassword">
    <h3>Reset Password</h3>

    <p>Set new password for {$RESETPASSWORD_NAME}!</p>
    <div id="resetpassword_form_box">
{include file="user_form_resetpassword_input.tpl"}
    </div>
</div>
{/block}
