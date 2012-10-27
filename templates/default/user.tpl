{*
    user.tpl
*}
{extends file="layout.tpl"}

{block name="page_title"}Addresses{/block}

{block name="layout_canvas"}
<div id="page_user">

{include file="navigation.tpl"}

    <div id="content">
{block name="user_content"}
        <strong>user.tpl - user_content</strong>
        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
{/block}
    </div>
    <br style="clear: both" />
</div>
{/block}
