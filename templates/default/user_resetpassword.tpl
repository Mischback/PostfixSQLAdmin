{*
    user_resetpassword.tpl
*}
{extends file="user.tpl"}

{block name="user_content"}
<div id="user_resetpassword">
    <h3>Reset Password for {$RESETPASSWORD_NAME}</h3>

    <div class="resetpassword_form_box">
{include file="user_form_resetpassword_input.tpl"}
    </div>
</div>
{/block}
