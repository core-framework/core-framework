<!DOCTYPE html>
<html>
<{block name="headBlock"}>
<head>
    <{block name="title"}>
        <title><{$title}></title>
    <{/block}>
    <!-- Metas -->
    <{block name="metas"}>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <{if isset($metaKeywords)}>
            <meta name="keywords" content="<{$metaKeywords}>">
        <{/if}>
        <{if isset($metaDescription)}>
            <meta name="description" content="<{$metaDescription}>">
        <{/if}>
        <meta name="author" content="Shalom Sam">
    <{/block}>
    <!-- END: Metas -->
    <!-- Styles -->
    <{block name="styles"}>
        <link href="/styles/bootstrap/bootstrap.min.css" type="text/css" rel="stylesheet" />
        <link href="/styles/prettify.css" type="text/css" rel="stylesheet" />
    <{/block}>
    <!-- END: Styles -->
    <{block name="IECondn"}>
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <{/block}>
</head>
<{/block}>
<{block name="bodyBlock"}>
<body>
    <{if $showHeader === true }>
        <{block name="header"}>
            <a id="top"></a>
            <div class="header">
                <{include file="common/header.tpl"}>
            </div>
        <{/block}>
    <{/if}>
    <{block name="maincontentWrp"}>
        <div class="midContent">
            <{block name="maincontent"}> <{/block}>
        </div>
    <{/block}>
    <{if $showFooter === true }>
        <{block name="footer"}>
            <div class="footer">
                <{include file="common/footer.tpl"}>
            </div>
            <a id="bottom"></a>
        <{/block}>
    <{/if}>

    <!-- Scripts -->
    <{block name="scripts"}>
        <script type="text/javascript" src="/scripts/prettify.js"></script>
        <script type="text/javascript" src="/scripts/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="/scripts/bootstrap/bootstrap.js"></script>
        <script type="text/javascript">
            $(document).ready( function() {
                prettyPrint();
            });
        </script>
    <{/block}>
    <!-- END: Scripts -->

    <{block name="injected"}>
        <{if $script}>
            <{$script}>
        <{/if}>
    <{/block}>

    <{block name="devMode"}>
        <{if $debugDfltHtml}>
            <{$debugDfltHtml}>
        <{/if}>
    <{/block}>
</body>
<{/block}>
</html>