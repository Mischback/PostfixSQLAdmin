{*
    basic.tpl - The xHTML-skeleton

    Blocks:
        page_title  - Website title.
        basic_body  - The content of the <body>-tag.
*}
<?xml version="1.0" encoding="utf-8" ?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">

    <head>
        <title>{block name="page_title"}page_title{/block}</title>
    </head>

    <body>
{block name="basic_body"}
        <strong>basic.tpl - basic_body</strong><br />
        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
{/block}
    </body>

</html>
