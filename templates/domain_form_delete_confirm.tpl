{*
    domain_form_delete_confirm.tpl
*}
<form action="domain.php" method="post">
    <input name="delete_confirm_id" value="{$DOMAIN_ID}" type="hidden" />
{include file="button_confirm.tpl" BUTTON_CAPTION="Yes, I really want to delete the domain $DOMAIN_NAME"}
{include file="button_decline.tpl" BUTTON_LOCATION="domain.php" BUTTON_CAPTION="Nope!" BUTTON_TITLE="take me back"}
</form>
