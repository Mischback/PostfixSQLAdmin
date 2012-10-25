{*
    layout.tpl
*}

{extends file="basic.tpl"}

{block name="basic_body"}
<div id="layout">
    <div>
        <div id="header"><div><div><div><div>
            <a href="index.php" title="toStartPage">
                <img src="{if isset($CFG_LOGO)}{$CFG_LOGO}{else}templates/{$CFG_SKIN}/gfx/logo.jpg{/if}" alt="Logo" title="toStartPage" />
            </a>

        </div></div></div></div></div>

        <div id="content">
{block name="layout_content"}
    <strong>layout.tpl - layout_content</strong><br />
    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
{/block}
        </div>

    </div>
</div>

<div id="footer">
    <a href="index.php" title="toStartPage">{$SOFTWARE_NAME}</a>
</div>
{/block}
