{*
    form_alias_overview_delete.tpl
*}
<form action="alias.php" method="post">
    <input name="delete_alias_id" value="{$ALIAS_ID}" type="hidden" />
{include file="button_inline.tpl" BUTTON_CAPTION="delete"}
</form>
