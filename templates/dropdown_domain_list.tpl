{*
    dropdown_domain_list.tpl
*}
{if !isset($DROPDOWN_PRESELECT)}
<option value="NULL">Please select a domain...</option>
{/if}
{section name="row" loop=$DROPDOWN_DOMAIN_LIST}
<option value="{$DROPDOWN_DOMAIN_LIST[row].id}"{if isset($DROPDOWN_PRESELECT) && ($DROPDOWN_PRESELECT == $DROPDOWN_DOMAIN_LIST[row].id)} selected="selected"{/if}>{$DROPDOWN_DOMAIN_LIST[row].name}</option>
{/section}
