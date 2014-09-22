<{extends file="root.tpl"}>

<{block name="styles"}>
    <link href="/styles/bootstrap/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <{*<link href="/styles/bootstrap-responsive.css" type="text/css" rel="stylesheet" />*}>
    <link href="/styles/prettify.css" type="text/css" rel="stylesheet" />
    <link href="/styles/demo/demo.css" type="text/css" rel="stylesheet" />
<{/block}>


<{block name="bodyBlock"}>
    <body id="top" class="<{$pagename}>">

    <div class="mainWrp clearfix">
        <{block name="header"}>
            <!--  NAVIGATION BAR START  -->
            <{include file="demopages/navs.tpl"}>
            <!--  NAVIGATION BAR END  -->
        <{/block}>


        <!--  MAIN CONTAINER START  -->
        <div class="container midWrp">

            <{block name="maincontentWrp" }>
                <{if $pagename eq 'home'}>
                    <!-- SECTION: OVERVIEW START -->
                    <{include file="demopages/introSection.tpl"}>
                    <!-- SECTION: OVERVIEW END -->
                <{elseif not isset($page) && isset($error)}>
                    <{include file="errors/404.tpl"}>
                <{/if}>
            <{/block}>

        </div>
        <!--  MAIN CONTAINER END  -->
        <{block name="footer"}>
            <{include file="demopages/footer.tpl"}>
        <{/block}>
    </div>

    <!-- loading javascripts -->
    <{block name="scripts" }>
        <script src="/scripts/jquery/jquery.js"></script>
        <script src="/scripts/bootstrap/bootstrap.min.js"></script>
        <script src="/scripts/prettify.js"></script>
        <!-- init javascripts -->
        <script src="/scripts/init.js"></script>
    <{/block}>

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