<{*<div class="navbar navbar-fixed-top navbar-inverse">*}>
    <{*<div class="navbar-inner">*}>
        <{*<div class="container">*}>
            <{*<a type="btn btn-navbar" class="navbar-toggle btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">*}>
                <{*<span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>*}>
            <{*</a>*}>
            <{*<a class="nav-brand" href="/">Core Framework <em class="small bg-green" >alpha</em></a>*}>
            <{*<div class="nav-collapse collapse">*}>
                <{*<ul class="nav">*}>
                    <{*<{foreach from=$docVarsCom.navs key=k item=i }>*}>
                        <{*<li>*}>
                            <{*<a href="<{$i}>"><{$k}></a>*}>
                        <{*</li>*}>
                    <{*<{/foreach}>*}>
                <{*</ul>*}>
            <{*</div>*}>
        <{*</div>*}>
    <{*</div>*}>
<{*</div>*}>

<div class="navbar navbar-custom navbar-fixed-top navbar-inverse" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><{$docVarsCom.product.name}> <sup class="small bg-green">alpha</sup></a>
        </div>
        <div class="navbar-collapse collapse" style="height: 1px;">
            <ul class="nav navbar-nav navbar-right">
                <{foreach from=$docVarsCom.navs key=k item=i }>
                    <li class="<{$k|replace:" ":"_"|lower}>">
                        <a href="<{$i}>"><{$k}></a>
                    </li>
                <{/foreach}>
            </ul>
            <!--<form class="navbar-form navbar-right">-->
            <!--<input type="text" class="form-control" placeholder="Search...">-->
            <!--</form>-->
        </div>
    </div>
</div>