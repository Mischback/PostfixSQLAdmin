{*
    form_user_create.tpl
*}
<form action="user.php" method="post">
    <table class="create_new_user">
        <tr>
            <td class="col1"><input name="create_user_username" placeholder="new username" type="text" /></td>
            <td class="col2">@</td>
            <td class="col3">
                <select name="create_user_domain" size="1">
{include file="dropdown_domain_list.tpl"}
                </select>
            </td>
            <td class="col4">
{include file="button_inline.tpl" BUTTON_CAPTION="create"}
            </td>
        </tr>
    </table>
</form>
