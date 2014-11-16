<{extends file="root.tpl"}>

<{block name="styles"}>
    <link href="/styles/bootstrap/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="/styles/prettify.css" type="text/css" rel="stylesheet" />
    <link href="/styles/demo/demo.css" type="text/css" rel="stylesheet" />
<{/block}>


<{block name="bodyBlock"}>
    <body id="top" class="<{$pageName}> <{if isset($mainPage)}><{$mainPage}><{/if}> <{if isset($subPage) && $subPage === true  }>subpage<{/if}> ">

    <div class="mainWrp clearfix">
        <{block name="header"}>
            <!--  NAVIGATION BAR START  -->
            <{include file="demopages/navs.tpl"}>
            <!--  NAVIGATION BAR END  -->
        <{/block}>


        <!--  MAIN CONTAINER START  -->
        <{if isset($customServePath) }>
            <div class="customServeWrp">
                <{fetch file=$customServePath }>
            </div>
        <{else}>
            <div class="container midWrp">

                <{block name="maincontentWrp" }>
                    <{if isset($includeTpl) }>
                        <{include file=$includeTpl }>
                    <{elseif not isset($includeTpl) && not isset($customServePath) && isset($error)}>
                        <{include file="errors/404.tpl"}>
                    <{/if}>
                <{/block}>

            </div>
        <{/if}>
        <!--  MAIN CONTAINER END  -->

        <{block name="footer"}>
            <{include file="demopages/footer.tpl"}>
        <{/block}>
    </div>

    <!-- loading javascripts -->
    <{block name="scripts" }>
        <script src="/scripts/jquery/jquery.min.js"></script>
        <script src="/scripts/bootstrap/bootstrap.min.js"></script>
        <script src="/scripts/prettify.js"></script>
        <!-- init javascripts -->
        <script src="/scripts/init.js"></script>
    <{/block}>

    <{block name="injected"}>
        <{if isset($script)}>
            <{$script}>
        <{/if}>
    <{/block}>

    <{block name="devMode"}>
        <{if isset($debugDfltHtml)}>
            <{$debugDfltHtml}>
        <{/if}>
    <{/block}>

    </body>
<{/block}>