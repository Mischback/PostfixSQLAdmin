{*
    form_user_modify.tpl
*}
<form action="user.php" method="post">
    <table>
        <tr>
            <td class="col1"><input name="modify_user_name" value="{$MODIFY_USER_NAME}" type="text" /></td>
            <td class="col2">@</td>
            <td class="col3">
                <select name="modify_user_domain" size="1">
{include file="dropdown_domain_list.tpl" DROPDOWN_DOMAIN_LIST=$MODIFY_USER_DOMAIN_DD DROPDOWN_PRESELECT=$MODIFY_USER_DOMAIN}
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <input name="modify_user_id" value="{$MODIFY_USER_ID}" type="hidden" />
{include file="button_confirm.tpl" BUTTON_CAPTION="confirm"}
{include file="button_decline.tpl" BUTTON_LOCATION="user.php" BUTTON_CAPTION="discard" BUTTON_TITLE="take me back"}
            </td>
        </tr>
    </table>
</form>
