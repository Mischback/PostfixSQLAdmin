{*
    form_alias_create.tpl
*}
<form action="alias.php" method="post">
    <table class="create_new_alias">
        <tr>
            <td class="col1"><input name="create_alias_name" placeholder="new aliasname" type="text" /></td>
            <td class="col2">@</td>
            <td class="col3">
                <select name="create_alias_domain" size="1">
{include file="dropdown_domain_list.tpl"}
                </select>
            </td>
            <td class="col4"><br /><br /></td>
        </tr>
        <tr>
            <td class="col1" colspan="3">forward to: <input name="create_alias_destination" placeholder="new alias destination" type="text" /></td>
            <td class="col4">
{include file="button_inline.tpl" BUTTON_CAPTION="create"}
            </td>
        </tr>
    </table>
</form>
