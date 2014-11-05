<?php


return $page = [
    'mainHeading' => 'Routing',
    'introPara' => '<strong class="initialism">Routing</strong> is used to determine what URL path (or query string) results in what output (or view) in a larger sense of things.
        But essentially every URL path is associated with a Controller which in turn determines the output.
        This association is typically defined in a config file. In case of Core Framework all routing configuration are defined in <code>{PROJECT_DIR}/config/routes.conf.php</code>',

    'subTitle1' => 'Routing Example',
    'subTitle1_pLink' => 'routing-example',
    'subPara1' => '<p class="para">
        The contents of the <code>{PROJECT_DIR}/config/routes.conf.php</code> is a basic php associative array as shown below.
    </p>
    <pre class="prettyprint linenums">return $routes = [
        &#39;/&#39; => [
            &#39;pageName&#39; => &#39;demo&#39;,
            &#39;pageTitle&#39; => &#39;Demo Home Page&#39;,
            &#39;controller&#39; => &#39;\\demoapp\\Controllers:demoController:indexAction&#39;
        ],

        &#39;/about&#39; => [
            &#39;pageName&#39; => &#39;demo&#39;,
            &#39;pageTitle&#39; => &#39;Demo about Page&#39;,
            &#39;controller&#39; => &#39;\\demoapp\\Controllers:demoController:aboutAction&#39;
        ]
    ];
    </pre>
    <p class="para">
        The routes here consist of 2 parts. The first part, <code class="prettyprint" >&#39;/&#39;</code> or <code class="prettyprint" >&#39;/about&#39;</code> is the <abbr title="defines the URL path">route definition</abbr> and comprises the relative URL i.e. <code>yourwebsite.com</code> or <code>yourwebsite.com/about</code>
    </p>
    <div class="well well-sm">
        <strong>NOTE:</strong> <code class="prettyprint" >&#39;/&#39;</code> represents the root URL path or in other words the homepage.
    </div>
    <p class="para">
        The second part :-
    </p>
    <pre class="prettyprint linenums:2">
        [
            &#39;pageName&#39; => &#39;demo&#39;,
            &#39;pageTitle&#39; => &#39;Demo Home Page&#39;,
            &#39;controller&#39; => &#39;\\demoapp\\Controllers:demoController:indexAction&#39;
        ]
    </pre>
    <p class="para">
        Is called the route vars or route variables. This part essentially holds the data required to further compute the page. Most components of the route vars like <code class="prettyprint">&#39;pageName&#39;</code> and <code class="prettyprint">&#39;pageTitle&#39;</code>, are self explanatory. Here the important part is the <code class="prettyprint">&#39;controller&#39;</code>. The <code class="prettyprint">&#39;controller&#39;</code> defines which controller the URL is associated with.
        <br/><br/>
        The <code class="prettyprint">&#39;controller&#39;</code> consists of the 3 parts separated by a <code>:</code>.
        <br/><br/>
        The first part, <code class="prettyprint">&#39;\\demoapp\\Controllers&#39;</code>, is the complete namespace to the controller ( following psr-4 standards with the PROJECT_DIR being the root ).
        <br/>
        The second part, <code class="prettyprint">&#39;demoController&#39;</code>, is the controller class name. The controller class names ( must ) always follow the <code>{pagename}Controller</code> pattern.
        <br/>
        And finally the third part, <code class="prettyprint">&#39;indexAction&#39;</code>, is the method to call in the controller class. This part if not specified defaults to <code class="prettyprint">&#39;indexAction&#39;</code>. The method or action name ( must ) always follow the <code>{action-name}Action</code> pattern.
    </p>',

    'subTitle2' => 'Advanced Routing',
    'subTitle2_pLink' => 'advanced-routing',
    'subPara2' => '<p class="para">
        In some cases it may become essential to have certain values from the URL path ( or query string ) available in the controller for advanced computing of some sort or to simply pass that value to the databases and fetch data accordingly.
        <br/><br/>
        Example :-
    </p>
    <pre class="prettyprint linenums">
    &#39;/test/hello/{name}&#39; => [
        &#39;pageName&#39; => &#39;test&#39;,
        &#39;pageTitle&#39; => &#39;Test&#39;,
        &#39;argReq&#39; => [&#39;name&#39; => &#39;[&#92;w]&#39;],
        &#39;argDefault&#39; => &#39;name&#39;,
        &#39;method&#39; => &#39;GET&#39;,
        &#39;controller&#39; => &#39;\\Core\\Controllers:testController&#39;
    ]</pre>

    <p class="para">
        As you can see there are three additional route variables required for advanced routing. The <code class="prettyprint">&#39;argReq&#39;</code> parameter contains an array of the dynamic parameters with alpha-numeric or numeric filter pattern, i.e. [&#92;w] if the dynamic URL parameter <code>{name}</code> should be alphanumeric or [&#92;d] if the dynamic parameter should only be numeric values.
        <br/><br/>
        The <code class="prettyprint">&#39;argDefault&#39;</code> parameter specifies what default value to pass if no value is specified in place of the dynamic URL parameter <code>{name}</code>. Hence if you enter the URL <code>htttp://{projectDomain}/test/hello</code> in the browser, in this case you&#39;ll get an output <code>Hello name</code> as <code class="prettyprint">&#39;argDefault&#39; => &#39;name&#39;</code> is the defined default.
        <br/><br/>
        The <code class="prettyprint">&#39;method&#39;</code> defines the method of access to the URL. The supported methods are the GET, POST, PUT and DELETE. Access to the URL with the only the defined method will be allowed, i.e. in this case as GET is the defined method access will be allowed only using the GET method.
    </p>',

    'subTitle3' => 'Additional support',
    'subTitle3_pLink' => 'additional_support',
    'subPara3' => '
    <p class="para">
        Other than the <code class="prettyprint">&#39;pageTitle&#39;</code> and <code class="prettyprint">&#39;pageName&#39;</code> route variables, Core Framework supports <code class="prettyprint">&#39;metaKeywords&#39;</code>, <code class="prettyprint">&#39;metaDescription&#39;</code> and <code class="prettyprint">&#39;model&#39;</code>. Most of these route variables are self explanatory. The <code class="prettyprint">&#39;pageTitle&#39;</code> is to set the title of the page. And similarly <code class="prettyprint">&#39;metaDescription&#39;</code> and <code class="prettyprint">&#39;metaKeywords&#39;</code> are used to set the respective meta values. The <code class="prettyprint">&#39;model&#39;</code> is used to autoload the defined model, which then is available in the defined controller as <code class="prettyprint">$this->model</code>
    </p>
    '
];