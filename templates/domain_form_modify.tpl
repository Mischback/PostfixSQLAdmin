{*
    domain_form_modify.tpl
*}
<form action="domain.php" method="post">
    <input name="modify_domain_id" value="{$DOMAIN_ID}" type="hidden" />
{include file="button_inline.tpl" BUTTON_CAPTION="modify"}
</form>
