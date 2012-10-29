{*
    form_domain_modify.tpl
*}
<form action="domain.php" method="post">
    <input name="modify_domain_id" value="{$DOMAIN_ID}" type="hidden" />
    <input name="modify_domain_name" value="{$DOMAIN_NAME}" type="text" />
    <br />
{include file="button_confirm.tpl" BUTTON_CAPTION="confirm"}
{include file="button_decline.tpl" BUTTON_LOCATION="domain.php" BUTTON_CAPTION="discard" BUTTON_TITLE="take me back"}
</form>
