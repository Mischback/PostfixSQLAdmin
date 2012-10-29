{*
    form_user_reset_password.tpl
*}
<form action="user.php" method="post">
    <input name="resetpassword_id" value="{$RESETPASSWORD_ID}" type="hidden" />
    <input name="resetpassword_password" placeholder="set new password" type="password" /><br />
{include file="button_confirm.tpl" BUTTON_CAPTION="set new password"}
</form>
