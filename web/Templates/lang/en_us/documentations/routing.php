<?php

return $page = [
    'mainHeading' => 'Routing',
    'introPara' => '<strong class="initialism">Routing</strong> is used to determine what URL path (or query string) results in what output (view or html). But essentially every URI has a Controller it is mapped to, which in turn determines the output (the View). This association is typically defined in a config file. In case of Core Framework all routing configuration are defined in <code>{PROJECT_DIR}/web/config/routes.conf.php</code>. As you&apos;ll see, in Core Framework all config files reside in this config folder and are appended with a ".conf.php".',
    'subTitle1' => 'Routing Example',
    'subTitle1_pLink' => 'routing-example',
    'subPara1' => '<p class="para">
        The contents of the <code>routes.conf.php</code> is a basic php associative array as shown below:
    </p>
    <pre class="prettyprint linenums">return $routes = [
        &#39;/&#39; => [
            &#39;pageName&#39; => &#39;demo&#39;,
            &#39;pageTitle&#39; => &#39;Demo Home Page&#39;,
            &#39;controller&#39; => &#39;\\web\\Controllers:siteController:indexAction&#39;
        ],

        &#39;/about&#39; => [
            &#39;pageName&#39; => &#39;demo&#39;,
            &#39;pageTitle&#39; => &#39;Demo about Page&#39;,
            &#39;controller&#39; => &#39;\\web\\Controllers:siteController:aboutAction&#39;
        ]
    ];
    </pre>
    <p class="para">
        The <code>routes.conf.php</code> file as seen consists of a key/value pair, associative array, with the key in the array being the <abbr title="The relative URI">Route Definition</abbr> i.e. the relative URL. Thus the key <code>/about</code> would match for the URL <code>yourwebsite.com/about</code>.
    </p>
    <div class="well well-sm">
        <strong>NOTE:</strong> <code>&#39;/&#39;</code> represents the root URL path or in other words the homepage.
    </div>
    <p class="para">
        Now the value of the key in the array, is also an array, that contains some preliminary (configurable) parameters about the routes, like the page title, page name, and the controller &amp; method the route is mapped to. The full list of configurable parameters for the route and more details about it can be found <a href="">here</a>.
        <br/><br/>
        These parameters, referred to as "Route Params", determines how the application further computes the page. The common <abbr title="Route Parameters set in config">route params</abbr> like pageTitle determine the title of the page for the defined URI and the pageName, as it implies determines the pageName to be used (generally used for css). The Controller on the other hand has three parts, <code>{namespaceOfController}:{controller}:{method}</code>. The namespace being the namespace of the controller, this must follow the directory structure to enable autoloading in PHP. Read more about <a href="http://www.php-fig.org/psr/psr-0/" rel="nofollow">PSR-0</a> and <a href="http://www.php-fig.org/psr/psr-4/" rel="nofollow">PSR-4</a> to get a better understanding. The controller ofcourse being the controller name and method being the controller class&apos;s method to invoke/execute.
    </p>',
    'subTitle2' => 'Advanced Routing',
    'subTitle2_pLink' => 'advanced-routing',
    'subPara2' => '<p class="para">
        In some cases dynamic parameters or values maybe required to be passed to the controller from the route to determine the associated view or data to be fetched.
        <br>
        In Core Framework this can be achieved by placing parameter name in curly brackets(<code>{}</code>) within your <abbr title="Route Parameters set in config">route params</abbr> as shown in the example below:
    </p>
    <pre class="prettyprint linenums">
    &#39;/test/hello/{name}&#39; => [
        &#39;pageName&#39; => &#39;test&#39;,
        &#39;pageTitle&#39; => &#39;Test&#39;,
        &#39;argReq&#39; => array(&#39;name&#39; => &#39;:any&#39;),
        &#39;httpMethod&#39; => &#39;GET&#39;,
        &#39;controller&#39; => &#39;\\Core\\Controllers:testController&#39;
    ]</pre>
    <p class="para">
        As you can see there is an additional route parameters required for advanced routing. The <code>&#39;argReq&#39;</code> parameter contains an array of the dynamic parameter(s) with the match type. The available match types are <code>:alpha</code>, to match only letters, <code>:num</code>, to match only numeric values and <code>:any</code>, match any character.
    </p>',
    'subTitle3' => 'Route Parameters',
    'subTitle3_pLink' => 'route_parameters',
    'subPara3' => '
    <p class="para">
        Route Parameters as mentioned above is a an array of configureable parameters that can be set for a route or URI.
        A complete list of the available configureable parameters available are mentioned below (with examples):
        <br/><br/>
        <strong>pageName</strong>: This defines the name of the current route or page shown. This will be set as the class to the body tag.
        <br/><br/>
        <strong>pageTitle</strong> or <strong>title</strong>: Page title can also be defined outside of the <code>metas</code> array.
        <br/><br/>
        <strong>controller</strong>: The controller parameter is divided into three parts by colons(:), the namespace for the controller class, the controller class name and the controller class method to be invoked.
        <br/><br/>
        <strong>metas</strong>: All html metas can be defined as an array of <code>$key => $value</code> pairs as shown below -
    </p>
    <pre class="prettyprint linenums">
    &#39;/&#39; => [
        &#39;pageName&#39; => &#39;demo&#39;,
        &#39;controller&#39; => &#39;\\web\\Controllers:demoController:indexAction&#39;,
        &#39;metas&#39; => [
            &#39;pageTitle&#39; => &#39;Demo Home Page&#39;,
            &#39;keywords&#39; => &#39;test, keywords, for test&#39;,
            &#39;description&#39; => &#39;This is a test description&#39;,
            &#39;author&#39; => &#39;Shalom Sam&#39;
        ]
    ]
    </pre>
    <p class="para">
        And they will be filled in html as <code class="prettyprint html">&lt;meta name="$key" content="$value" /&gt;</code>
    </p>
    <div class="alert alert-warning" role="alert"><strong>NOTE</strong>: The page title defined in metas (as <code>pageTitle</code> or <code>title</code>) takes precedence over the page title defined as &#39;pageTitle&#39; above or outsite metas.
    </div>
    <p class="para">
        <strong>httpMethod</strong>: Defines the method of access to the URL. The supported methods are the GET, POST, PUT and DELETE. Access to the URL with the only the defined method will be allowed, i.e. in this case as GET is the defined method access will be allowed only using the GET method. If no method is defined then the default GET is assumed.
        <br><br>
        <strong>serveAsIs</strong>: This parameter accepts a boolean value and is used to serve micro sites within the main site. This parameter must be used in conjunction with <code>referencePath</code>, <code>showHeader</code>, <code>showFooter</code> and <code>serveIframe</code>
        <br/><br/>
        <strong>referencePath</strong>: The reference path must contain the (relative) path to the folder, whose contents must be served as a micro site. If <code>serveIframe</code> is set to true then <code>referencePath</code> must contain the (relative) URL to the main index file or in other words, url to the micro site&#39;s home page.
        <br/><br/>
        <strong>serveIframe</strong>: If the contents of a route or page has to served as Iframe from another part of the site, then this must be set as true. This also requires that 2 routes be defined for this purpose (logically). One for the path that serves the iframe. And another for the content to be served through iframe. The below example will make this clearer -
    </p>
    <pre class="prettyprint linenums">
        &#39;/documentation/api&#39; => [
            &#39;pageName&#39; => &#39;api&#39;,
            &#39;pageTitle&#39; => &#39;Core Framework API&#39;,
            &#39;serveAsIs&#39; => true,
            &#39;serveIframe&#39; => true,
            &#39;referencePath&#39; => &#39;/documentation/api/index.html&#39;,
            &#39;controller&#39; => &#39;&#92;&#92;demoapp&#92;&#92;Controllers:demoController:apiAction&#39;,
            &#39;showHeader&#39; => true
        ],

        &#39;/documentation/api/{page}&#39; => [
            &#39;pageName&#39; => &#39;api&#39;,
            &#39;argReq&#39; => [&#39;page&#39; => &#39;[&#92;S]&#39;],
            &#39;argDefault&#39; => &#39;index.html&#39;,
            &#39;method&#39; => &#39;GET&#39;,
            &#39;serveAsIs&#39; => true,
            &#39;referencePath&#39; => &#39;Templates/api&#39;,
            &#39;controller&#39; => &#39;&#92;&#92;demoapp&#92;&#92;Controllers:demoController:apiAction&#39;,
            &#39;showHeader&#39; => false,
            &#39;showFooter&#39; => false
        ],
    </pre>
    <div class="alert alert-warning">
        <strong>NOTE</strong>: It is necessary to set <code>serveAsIs</code> as true even when setting <code>serveIframe</code> as true.
    </div>
    <p class="para">
        <strong>showHeader</strong>: This parameter accepts a boolean value. If set, determines if the Header should be shown for the current URL path.
        <br/><br/>
        <strong>showFooter</strong>: This parameter accepts a boolean value. If set, determines if the footer should be shown for the current URL path.
    </p>
    '
];
