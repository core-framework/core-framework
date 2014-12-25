<section id="overview">

    <div class="hero-unit">
        <h1>Welcome to <{$docVarsCom.product.name}></h1>
        <{if isset($showProd) && $showProd === true}>
            <p class="introPara"><{$home.intro_para_prod}></p>
        <{else}>
            <p class="introPara"><{$home.intro_para}></p>
        <{/if}>
        <br/>

        <p class="queryTitle"><{$home.why_core_title}></p>

        <p class="queryAns"><{$home.why_core_options}></p>

        <p class="queryTitle"><{$home.what_next_title}></p>

        <p class="queryAns"><{$home.what_next_options}></p>
        <br/><br/>

        <p class="well well-small"><{$home.intro_note}></p>

        <div class="row-fluid addLinks">
            <a href="https://github.com/shalomsam/Core/issues" class="btn btn-danger btn-lg"><{$home.track_issues}></a>
            <a href="https://github.com/shalomsam/Core/fork" class="btn btn-success btn-lg"><{$home.contribute}></a>
            <a href="https://github.com/shalomsam/Core/blob/master/changelog" role="button"
               class="btn btn-primary btn-lg" data-toggle="modal"><{$home.change_logs}></a>
            <a href="/about#credits" role="button" class="btn btn-info btn-lg"><{$home.credits}></a>
        </div>
    </div>
    <hr>
    <div class="row center-block productInfo">
        <div class="col-xs-12 col-lg-4 row center-block">
            <div class="row">
                <div class="col-lg-3 visible-xs-inline bold-xs visible-lg-block">
                    Author:
                </div>
                <div class="col-lg-9 visible-xs-inline visible-lg-block">
                    <{$docVarsCom.author.name}>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 visible-xs-inline bold-xs visible-lg-block">
                    Contact:
                </div>
                <div class="col-lg-9 visible-xs-inline visible-lg-block">
                    <a href="#"><{$docVarsCom.author.email}></a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-4 row center-block">
            <div class="row">
                <div class="col-lg-4 visible-xs-inline bold-xs visible-lg-block">
                    Author URL:
                </div>
                <div class="col-lg-8 visible-xs-inline visible-lg-block">
                    <a href="<{$docVarsCom.author.url}>"><{$docVarsCom.author.url|replace:"http://":""}></a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 visible-xs-inline bold-xs visible-lg-block">
                    Core Version:
                </div>
                <div class="col-lg-8 visible-xs-inline visible-lg-block">
                    <{$docVarsCom.product.current_ver}>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-4 center-block">
            <div class="row">
                <div class="visible-xs-inline bold-xs col-lg-6 visible-lg-block">
                    Documentation Version:
                </div>
                <div class="visible-xs-inline col-lg-4 visible-lg-block">
                    <{$docVarsCom.product.doc_ver}>
                </div>
            </div>
            <div class="row">
                <div class="visible-xs-inline bold-xs col-lg-6 visible-lg-block">
                    Product Created:
                </div>
                <div class="visible-xs-inline col-lg-4 visible-lg-block">
                    <{$docVarsCom.product.created_on}>
                </div>
            </div>
        </div>
    </div>

    <hr>

</section>