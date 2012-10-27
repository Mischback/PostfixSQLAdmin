{*
    user_overview.tpl
*}
{extends file="user.tpl"}

{block name="user_content"}
<div id="user_overview">
    <h3>Address overview</h3>

    <table class="listing user_list" summary="lists users">
        <tr class="headline {cycle name="listing_row" values="odd,even"}">
            <td class="col1"><img src="./templates/default/gfx/icon_envelope.gif" title="local-part of the mail address" /></td>
            <td class="col2"></td>
            <td class="col3"><img src="./templates/default/gfx/icon_world.gif" title="the name of the domain" /></td>
            <td class="col4"></td>
            <td class="col5"></td>
        </tr>
{section name="row" loop=$USER_LIST}
        <tr class="{cycle name="listing_row" values="odd,even"}">
            <td class="col1">{$USER_LIST[row].username}</td>
            <td class="col2">@</td>
            <td class="col3">{$USER_LIST[row].domain_name}</td>
            <td class="col4 modify">
{include file="user_form_modify.tpl" USER_ID=$USER_LIST[row].user_id}
            </td>
            <td class="col5 delete">
{include file="user_form_delete.tpl" USER_ID=$USER_LIST[row].user_id}
            </td>
        </tr>
{/section}
    </table>
</div>
{/block}
