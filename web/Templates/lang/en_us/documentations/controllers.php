<?php


return $page = [
    'mainHeading' => 'Controllers',
    'introPara' => '<strong>Controllers</strong> are used to define the core logic behind the purticular request, i.e. what to do next with the available (pre-defined) data from the URI and/or the query string, what model to load and/or what changes to make to the view. Controller class files must be present in <code>{PROJECT_FOLDER}/web/Controllers/</code> directory and must be given the same namespace, <code>namespace web&#92;Controllers;</code>. Also when you extend your controller with BaseController, its namespace must be also added with a <code>use</code> command as shown in the example below, i.e. <code>use Core\Controllers\BaseController;</code>. This is to enable autoloader to autoload these classes properly without having to use <code>include {FILE};</code> everywhere. Also all controller names must be suffixed with the "Controller" keyword. For ex: <code>siteController</code>, <code>errorController</code>',
    'subTitle1' => 'Controller Example',
    'subTitle1_pLink' => 'controller-example',
    'subPara1' => '<p class="para">
        An example of a simple controller can be seen below -
        </p>
        <pre class="prettyprint linenums lang-php">
namespace web&#92;Controllers;

class siteController extends BaseController
{
    public function indexAction()
    {
        $this->view->disable();
        echo "hello World";
    }
}
        </pre>
        <p class="para">
            In the above example the controller would simply output <code>hello World</code>. The syntax <code>$this->view->disable()</code> is used because in Core Framework every GET request requires a template to be associated with it as View. In this case there is no view or template to render. Hence, it is essential to stop the code propagation to avoid Smarty from throwing a <code>Fatal Error</code>.
            <br/><br/>
            The controller file name and class name should follow <code>{name}Controller</code> pattern. And both class name and file name should be identical. While all methods must follow the <code>{name}Action</code> pattern. All your controllers must extend the BaseController. The BaseController is the <a href="https://en.wikipedia.org/wiki/Front_Controller_pattern" rel="nofollow">Front Controller</a> in Core Framework application.
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
        &#39;argReq&#39; => [&#39;name&#39; => &#39;:alpha&#39;],
        &#39;method&#39; => &#39;GET&#39;,
        &#39;controller&#39; => &#39;\\Core\\Controllers:testController:helloAction&#39;
    ]</pre>
        <p class="para">
            Then your dynamic parameter <code>{name}</code> will be available in your controller as a payload, which is basically a associative array with <code>&#39;name&#39;</code> as key (in this case).
            <br/>
            An example of a controller for the above defined route can be seen below:
        </p>
        <pre class="prettyprint linenums">
namespace web&#92;Controllers;

class testController extends controller
{
    public function helloAction($payload)
    {
        $this->view->setTemplate(\'simple.tpl\');
        $this->view->setTemplateVars(\'name\', $payload[\'name\']);
    }

}</pre>
    <p class="para">
        As you can see the value of the dynamic URL parameter <code>{name}</code> is available in the controller as an associative array, with the array key as the URL parameter name.
        <br/><br/>
        In case of controllers that have a view associated with it, it is essential that the smarty template (view), it must render is defined. As seen above (line 7 & 8) the template file must be set and the dynamic parameters required by the template must also be set, so as to prevent smarty from throwing Exceptions. If the view class need not be used for a request, as explained above it can be disabled using <code>$this->view->disable()</code> syntax.
        <br/><br/>
        The template can be defined my using the <code>$this->view->setTemplate($tpl)</code> method, with the template name as argument. All other template parameters must be defined using the <code>$this->view->setTemplateVars($key, $value)</code> method, with the $key being the variable name and $value being the value of the variable, and in the smarty template file it will be available as <code><{${VARIABLE_NAME}}></code>. More about Views and Smarty will be explained in the <a href="/documentation/view">View Documentation</a>.
    </p>
    '
];
