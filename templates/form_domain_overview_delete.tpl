{*
    form_domain_overview_delete.tpl
*}
<form action="domain.php" method="post">
    <input name="delete_domain_id" value="{$DOMAIN_ID}" type="hidden" />
{include file="button_inline.tpl" BUTTON_CAPTION="delete"}
</form>
