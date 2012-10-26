{*
    domain_modify.tpl
*}
{extends file="domain.tpl"}

{block name="domain_content"}
<div id="domain_modify">
    <h3>Modify Domain</h3>
    <p>The modification of <i>{$MODIFY_DOMAIN_NAME}</i> will affect <strong>{$MODIFY_DOMAIN_USERS} mail accounts</strong>!</p>

    <div id="domain_modify_form_box">
{include file="domain_form_modification.tpl" DOMAIN_ID=$MODIFY_DOMAIN_ID DOMAIN_NAME=$MODIFY_DOMAIN_NAME}
    </div>

</div>
{/block}