<?php


return $page = [
    'mainHeading' => 'Controllers',
    'introPara' => '<strong>Controllers</strong> are used to determine what to do next with the available ( pre-defined ) data from the URL path ( or query string ).
        Conttroller class files must be present in <code>{YOUR_APP}/Controllers/</code> directory. If for some reason you want the controllers to reside in the directory of your choosing, you can do so by adding the following line, <code class="prettyprint">$core->setControllerDir({YOUR_DIR_NAME});</code>, in your applications index.php file, just before the <code class="prettyprint">$core->Load();</code> line.',

    'subTitle1' => 'Controller Example',
    'subTitle1_pLink' => 'controller-example',
    'subPara1' => '<p class="para">
        As mentioned previously, the core application logic resides in the controller defined by you. An example of a simple controller can be seen below -
        </p>
        <pre class="prettyprint linenums lang-php">
namespace Core&#92;Controllers;

class testController extends controller
{
    public function indexAction()
    {
        echo "hello World";
        exit;
    }
}
        </pre>
        <p class="para">
            In the above example the controller would simply output <code>hello World</code>. The syntax <code class="prettyprint" >exit;</code> is used because in Core Framework every GET request requires a template to be associated with it as View. Hence, it is essential to stop the code propagation to avoid Smarty from throwing a <code>Fatal Error</code>.
            <br/>
            The controller file name and class name should follow <code>{name}Controller</code> pattern. And both class name and file name should be identical ( not considering the file extension, ofcourse ).
        </p>',

    'subTitle2' => 'Advanced Controllers',
    'subTitle2_pLink' => 'advanced-controllers',
    'subPara2' => '<p class="para">
            In cases where you have dynamic URL parameters, i.e if you have defined your path in <code>routes.conf.php</code> as follows :-
        </p>
        <pre class="prettyprint linenums">
    &#39;/test/hello/{name}&#39; => [
        &#39;pageName&#39; => &#39;test&#39;,
        &#39;pageTitle&#39; => &#39;Test&#39;,
        &#39;argReq&#39; => [&#39;name&#39; => &#39;[&#92;w]&#39;],
        &#39;argDefault&#39; => &#39;name&#39;,
        &#39;method&#39; => &#39;GET&#39;,
        &#39;controller&#39; => &#39;\\Core\\Controllers:testController:helloAction&#39;
    ]</pre>
        <p class="para">
            Then your dynamic parameter <code>{name}</code> will be available in your controller as a payload, which is basically a associative array with <code>&#39;name&#39;</code> as key (in this case).
            <br/>
            An example of a controller for the above defined route can be seen below :-
        </p>
        <pre class="prettyprint linenums">
namespace Core&#92;Controllers;

class testController extends controller
{
    public function helloAction($payload)
    {
        $this->response[&#39;tpl&#39;] = "simple.tpl";
        $this->response[&#39;vars&#39;][&#39;name&#39;] = $payload[&#39;name&#39;];
        return $this->getResponse();
    }

}</pre>
    <p class="para">
        As you can see the <code>{name}</code> URL parameter value is available in the controller as an associative array, with the array key as the URL parameter name used ( i.e. <code class="prettyprint">$payload[&#39;name&#39;]</code> ).
        <br/><br/>
        Also note that all defined controllers must extend the class controller, which essentially is the base controller.
        <br/><br/>
        In case of controllers that have a view associated with it, it is essential that the smarty template (view) it must render is defined. As seen above (line 7 - 9) all information (or data) to be passed to the view must be defined to <code class="prettyprint">$this->response</code>, which essentially (again) is an associative array.
        <br/><br/>
        The template must be defined to <code class="prettyprint">$this->response[&#39;tpl&#39;]</code> as seen on line 7 above.
        The smarty template directory is defined during your application setup. Thus when defining the path it must be relative to the template directory. For more info on smarty checkout <a href="http://www.smarty.net/documentation" rel="nofollow">Smarty&#39;s Documentation</a>.
        <br/><br/>
        All other template variables must be defined to <code class="prettyprint">$this->response[&#39;vars&#39;][{VARIABLE_NAME}]</code> and in the smarty template file it will be available as <code class="prettyprint"><{${VARIABLE_NAME}}></code>, i.e. in the above example, as seen on line 8, the VARIABLE_NAME <code class="prettyprint">&#39;name&#39;</code> is used, and the URL parameter value is assigned to this. This value will be available in the Smarty template file as <code class="prettyprint"><{$name}></code>
    </p>
    <p class="well wells-small">
        <strong>NOTE:</strong> HTML meta values like page title, keywords and description, if defined in <code>routes.conf.php</code>,  are available in the template by default.
    </p>
    '
];