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
            <{foreach from=$metas key=k item=v}>
                <{if not empty($v) }>
                    <meta name="<{$k}>" content="<{$v}>"/>
                <{/if}>
            <{/foreach}>
        <{/block}>
        <!-- END: Metas -->
        <!-- Styles -->
        <{block name="styles"}>
            <link href="/styles/bootstrap/bootstrap.min.css" type="text/css" rel="stylesheet"/>
            <link rel="stylesheet" href="/styles/demo.css"/>
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
    <{block name="maincontentWrp"}>
        <div class="midContent">
            <{if $showHeader === true }>
                <{block name="header"}>
                    <{include file="common/header.tpl"}>
                <{/block}>
            <{/if}>
            <{block name="maincontent"}> <{/block}>
        </div>
    <{/block}>
    <{if $showFooter === true }>
        <{block name="footer"}>
            <footer class="footer">
                <{include file="common/footer.tpl"}>
            </footer>
        <{/block}>
    <{/if}>

    <!-- Scripts -->
    <{block name="scripts"}>
        <script type="text/javascript" src="/scripts/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="/scripts/bootstrap/bootstrap.js"></script>
        <script type="text/javascript" src="/scripts/init.js"></script>
    <{/block}>
    <!-- END: Scripts -->

    <{block name="injected"}>
        <{if isset($script)}>
            <{$script}>
        <{/if}>
    <{/block}>

    <{block name="devMode"}>
        <{if isset($debugHtml)}>
            <link rel="stylesheet" href="/styles/base.css"/>
            <{$debugHtml}>
        <{/if}>
    <{/block}>
    </body>
<{/block}>
</html>