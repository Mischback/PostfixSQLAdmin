{*
    form_alias_create.tpl
*}
<form action="alias.php" method="post">
    <table class="create_new_alias">
        <tr>
            <td class="col1"><input name="modify_alias_name" value="{$MODIFY_ALIAS_NAME}" type="text" /></td>
            <td class="col2">@</td>
            <td class="col3">
                <select name="modify_alias_domain" size="1">
{include file="dropdown_domain_list.tpl" DROPDOWN_DOMAIN_LIST=$MODIFY_ALIAS_DOMAIN_DD DROPDOWN_PRESELECT=$MODIFY_ALIAS_DOMAIN}
                </select>
            </td>
            <td class="col4"><br /><br /></td>
        </tr>
        <tr>
            <td class="col1" colspan="4">forward to: <input name="modify_alias_destination" value="{$MODIFY_ALIAS_DESTINATION}" type="text" /></td>
        </tr>
        <tr>
            <td class="col1 buttons" colspan="4">
                <input name="modify_alias_id" value="{$MODIFY_ALIAS_ID}" type="hidden" />
{include file="button_confirm.tpl" BUTTON_CAPTION="confirm"}
{include file="button_decline.tpl" BUTTON_LOCATION="user.php" BUTTON_CAPTION="discard" BUTTON_TITLE="take me back"}
            </td>
        </tr>
    </table>
</form>
