{*
    domain_overview.tpl
*}
{extends file="domain.tpl"}

{block name="domain_content"}
<div id="domain_overview">
    <h3>Domain Overview</h3>

    <table class="listing domain_list" summary="lists all available domains">
        <tr class="headline {cycle name="listing_row" values="odd,even"}">
            <td class="col1"><img src="./templates/default/gfx/icon_world.gif" title="the name of the domain" /></td>
            <td class="col2"><img src="./templates/default/gfx/icon_envelope.gif" title="number of all users of this domain" /></td>
            <td></td>
            <td></td>
        </tr>
{section name="row" loop=$DOMAIN_LIST}
        <tr class="{cycle name="listing_row" values="odd,even"}">
            <td class="col1">{$DOMAIN_LIST[row].name}</td>
            <td class="col2">{$DOMAIN_LIST[row].users}</td>
            <td class="col3 modify">
{include file="form_domain_overview_modify.tpl" DOMAIN_ID=$DOMAIN_LIST[row].id}
            </td>
            <td class="col4 delete">
{include file="form_domain_overview_delete.tpl" DOMAIN_ID=$DOMAIN_LIST[row].id}
            </td>
        </tr>
{/section}
    </table>


    <h3>Create New Domain</h3>

    <div id="create_new_domain">
{include file="form_domain_create.tpl"}
    </div>

</div>
{/block}
