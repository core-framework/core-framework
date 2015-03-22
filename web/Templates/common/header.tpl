<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"> <span class="logo-txt"><{$site.appName}></span> <sup
                        class="label label-success"><{$site.appVersion}></sup></a>
        </div>
        <div class="navbar-collapse collapse" style="height: 1px;">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <{if isset($site.user)}>
                    <li><a href="<{$site.user.link}>"><{$site.user.name}></a></li>
                    <li><a href="<{$site.user.logoutLink}>"><{$site.user.name}></a></li>
                <{else}>
                    <li><a data-toggle="modal" data-target="#registerModal" href="#">Register</a></li>
                    <li><a data-toggle="modal" data-target="#loginModal" href="#">Login</a></li>
                <{/if}>
            </ul>
            <!--<form class="navbar-form navbar-right">-->
            <!--<input type="text" class="form-control" placeholder="Search...">-->
            <!--</form>-->
        </div>
    </div>
</nav>

<!-- Login and Registration Modals -->
<{include file="login_register.tpl" }>