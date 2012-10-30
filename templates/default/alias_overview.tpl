{*
    alias_overview.tpl
*}
{extends file="alias.tpl"}

{block name="alias_content"}
<div id="alias_overview">
    <h3>Alias Overview</h3>

    <table class="listing alias_list" summary="lists aliases">
        <tr class="headline {cycle name="listing_row" values="odd,even"}">
            <td class="col1"><img src="./templates/default/gfx/icon_envelope.gif" title="local-part of the alias" /></td>
            <td class="col2"></td>
            <td class="col3"><img src="./templates/default/gfx/icon_world.gif" title="the name of the domain" /></td>
            <td class="col4"><img src="./templates/default/gfx/icon_hand.gif" title="destination of the alias" /></td>
            <td class="col5"></td>
            <td class="col6"></td>
        </tr>
{section name="row" loop=$ALIAS_LIST}
        <tr class="{cycle name="listing_row" values="odd,even"}">
            <td class="col1">{$ALIAS_LIST[row].alias_name}</td>
            <td class="col2">@</td>
            <td class="col3">{$ALIAS_LIST[row].domain_name}</td>
            <td class="col4">{$ALIAS_LIST[row].destination}</td>
            <td class="col5 modify">
{include file="form_alias_overview_modify.tpl" ALIAS_ID=$ALIAS_LIST[row].alias_id}
            </td>
            <td class="col6 delete">
{include file="form_alias_overview_delete.tpl" ALIAS_ID=$ALIAS_LIST[row].alias_id}
            </td>
        </tr>
{/section}
    </table>

    <h3>Create New Alias</h3>
{include file="form_alias_create.tpl"}
</div>
{/block}
