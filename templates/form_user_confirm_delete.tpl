{*
    form_user_confirm_delete.tpl
*}
<form action="user.php" method="post">
    <input name="delete_confirm_id" value="{$USER_ID}" type="hidden" />
{include file="button_confirm.tpl" BUTTON_CAPTION="Yes, I really want to delete the user $USER_MAIL"}
{include file="button_decline.tpl" BUTTON_LOCATION="user.php" BUTTON_CAPTION="Nope!" BUTTON_TITLE="take me back"}
</form>
