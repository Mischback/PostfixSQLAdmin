{*
    user_form_password.tpl
*}
<form action="user.php" method="post">
    <input name="create_user_username" value="{$CREATE_USERNAME}" type="hidden" />
    <input name="create_user_domain" value="{$CREATE_DOMAIN_ID}" type="hidden" />
    <input name="user_password" placeholder="set user password" type="password" /><br />
{if isset($CREATE_USER_BUTTON_CAPTION)}
    {include file="button_confirm.tpl" BUTTON_CAPTION=$CREATE_USER_BUTTON_CAPTION}
{else}
    {include file="button_confirm.tpl" BUTTON_CAPTION="update password"}
{/if}
</form>
