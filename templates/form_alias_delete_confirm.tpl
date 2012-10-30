{*
    form_alias_delete_confirm.tpl
*}
<form action="alias.php" method="post">
    <input name="delete_confirm_id" value="{$USER_ID}" type="hidden" />
{include file="button_confirm.tpl" BUTTON_CAPTION="Yes, I really want to delete the alias $USER_MAIL"}
{include file="button_decline.tpl" BUTTON_LOCATION="user.php" BUTTON_CAPTION="Nope!" BUTTON_TITLE="take me back"}
</form>
