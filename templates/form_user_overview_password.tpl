{*
    form_user_overview_password.tpl
*}
<form action="user.php" method="post">
    <input name="resetpassword_id" value="{$USER_ID}" type="hidden" />
{include file="button_inline.tpl" BUTTON_CAPTION="reset password"}
</form>
