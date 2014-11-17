<section id="overview">

    <div class="hero-unit">
        <h1>Welcome to <{$docVarsCom.product.name}></h1>
        <{if isset($showProd) && $showProd === true}>
            <p class="introPara" ><{$home.intro_para_prod}></p>
        <{else}>
            <p class="introPara" ><{$home.intro_para}></p>
        <{/if}>
        <br/>
        <p class="whatNextTitle"><{$home.what_next_title}></p>
        <p class="whatNextOptions"><{$home.what_next_options}></p>
        <br/>
        <p class="well well-small"><{$home.intro_note}></p>
        <div class="row-fluid addLinks">
            <a href="https://github.com/shalomsam/Core/issues" class="btn btn-danger btn-lg"><{$home.track_issues}></a>
            <a href="https://github.com/shalomsam/Core/fork" class="btn btn-success btn-lg"><{$home.contribute}></a>
            <a href="https://github.com/shalomsam/Core/blob/master/changelog" role="button" class="btn btn-primary btn-lg" data-toggle="modal"><{$home.change_logs}></a>
            <a href="/about#credits" role="button" class="btn btn-info btn-lg"><{$home.credits}></a>
        </div>
    </div>
    <hr>
    <div class="container center-block productInfo">
        <div class="col-xs-12 col-lg-4 row center-block">
            <div class="row">
                <div class="col-xs-6 col-lg-3">
                    Author:
                </div>
                <div class="col-xs-6 col-lg-9">
                    <{$docVarsCom.author.name}>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-lg-3">
                    Contact:
                </div>
                <div class="col-xs-6 col-lg-9">
                    <a href="#"><{$docVarsCom.author.email}></a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-4 row center-block">
            <div class="row">
                <div class="col-xs-6 col-lg-4">
                    Author URL:
                </div>
                <div class="col-xs-6 col-lg-8">
                    <a href="<{$docVarsCom.author.url}>"><{$docVarsCom.author.url|replace:"http://":""}></a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-lg-4">
                    Core Version:
                </div>
                <div class="col-xs-6 col-lg-8">
                    <{$docVarsCom.product.current_ver}>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-4 center-block">
            <div class="row">
                <div class="col-xs-6">
                    Documentation Version:
                </div>
                <div class="col-xs-6">
                    <{$docVarsCom.product.doc_ver}>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    Product Created:
                </div>
                <div class="col-xs-6">
                    <{$docVarsCom.product.created_on}>
                </div>
            </div>
        </div>
    </div>

    <hr>

</section>