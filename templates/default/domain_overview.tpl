{*
    domain_overview.tpl
*}
{extends file="domain.tpl"}

{block name="domain_content"}
<div id="domain_overview">
    <h3>Domain Overview</h3>

    <table class="listing domain_list" summary="lists all available domains">
{section name="row" loop=$DOMAIN_LIST}
        <tr class="{cycle name="listing_row" values="odd,even"}">
            <td class="col1">{$DOMAIN_LIST[row].name}</td>
            <td class="col2">{$DOMAIN_LIST[row].users}</td>
            <td class="col3 button_col">
{include file="domain_form_modify.tpl" DOMAIN_ID=$DOMAIN_LIST[row].id}
            </td>
            <td class="col4 button_col">
{include file="domain_form_delete.tpl" DOMAIN_ID=$DOMAIN_LIST[row].id}
            </td>
        </tr>
{/section}
    </table>


    <h3>Create New Domain</h3>

    <div id="create_new_domain">
{include file="domain_form_create.tpl"}
    </div>

</div>
{/block}
