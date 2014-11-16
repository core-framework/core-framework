<section id="overview">

    <div class="hero-unit">
        <h1>Welcome to <{$docVarsCom.product.name}></h1>
        <p class="introPara" ><{$home.intro_para}></p>
        <br/>
        <p class="whatNextTitle"><{$home.what_next_title}></p>
        <p class="whatNextOptions"><{$home.what_next_options}></p>
        <br/>
        <p class="well well-small"><{$home.intro_note}></p>
        <{*<div class="row-fluid">*}>
            <{*<div class="span3"><a href="#nowhere" class="btn btn-primary btn-large btn-block">Item Support</a></div>*}>
            <{*<div class="span3"><a href="#nowhere" class="btn btn-inverse btn-large btn-block">Support Forum</a></div>*}>
            <{*<div class="span3"><a href="#changelog" role="button" class="btn btn-success btn-large btn-block" data-toggle="modal">Changelog</a></div>*}>
            <{*<div class="span3"><a href="#credits" role="button" class="btn btn-info btn-large btn-block" data-toggle="modal">Credits</a></div>*}>
        <{*</div>*}>
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