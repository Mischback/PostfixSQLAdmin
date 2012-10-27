{*
    user_form_modify.tpl
*}
<form action="user.php" method="post">
    <input name="modify_user_id" value="{$USER_ID}" type="hidden" />
{include file="button_inline.tpl" BUTTON_CAPTION="modify"}
</form>
