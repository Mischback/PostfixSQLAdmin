{*
    user_form_delete.tpl
*}
<form action="user.php" method="post">
    <input name="delete_user_id" value="{$USER_ID}" type="hidden" />
{include file="button_inline.tpl" BUTTON_CAPTION="delete"}
</form>
