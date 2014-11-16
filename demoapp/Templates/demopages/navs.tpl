<div class="navbar navbar-custom navbar-fixed-top navbar-inverse" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"> <span class="logo-txt"><{$docVarsCom.product.name}></span> <sup class="small bg-green">alpha</sup></a>
        </div>
        <div class="navbar-collapse collapse" style="height: 1px;">
            <ul class="nav navbar-nav navbar-right">
                <{foreach from=$docVarsCom.navs key=k item=i }>
                    <{if $i|is_array}>
                        <li class="dropdown <{$k|replace:" ":"_"|lower}>">
                            <a href="<{$i.link}>" class="dropdown-toggle" data-toggle="dropdown"><{$k}> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <{foreach from=$i key=key item=item }>
                                    <{if $key !== "link" }>
                                        <li class="<{$key|replace:" ":"_"|lower}>">
                                            <a href="<{$item}>"><{$key}></a>
                                        </li>
                                    <{/if}>
                                <{/foreach}>
                            </ul>
                        </li>
                    <{else}>
                        <li class="<{$k|replace:" ":"_"|lower}>">
                            <a href="<{$i}>"><{$k}></a>
                        </li>
                    <{/if}>
                <{/foreach}>
            </ul>
            <!--<form class="navbar-form navbar-right">-->
            <!--<input type="text" class="form-control" placeholder="Search...">-->
            <!--</form>-->
        </div>
    </div>
</div>