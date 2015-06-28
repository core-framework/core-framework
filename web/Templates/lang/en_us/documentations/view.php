<?php

return $view = [
    'mainHeading' => 'View',
    'introPara' => '<strong>View</strong> in Core Framework is a wrapper around the templating engine, which is Smarty (Support for other templating engines will be added soon). The View object simply holds data such as the Template file to render and the dynamic parameter(s) required by the specific template',
    'subTitle1' => 'View Example',
    'subTitle1_pLink' => 'view-example',
    'subPara1' => '<p class="para">
        View parameters must be set within the specific Controller the route is mapped to. An example of this can be seen below -
        </p>
        <pre class="prettyprint linenums lang-php">
class testController extends Controller
{

    /**
     * Method to print hello {name}. Where {name} is the dynamic route variable in the URL
     *
     * @param $payload
     * @return mixed
     */
    public function helloAction($payload)
    {
        $this->view->setTemplate(\'simple.tpl\');
        $this->view->setTemplateVars(\'name\', $payload[\'name\']);
    }

}
        </pre>
        <p class="para">
            As seen the View object is available within the Controller using the <code>$this->view</code> syntax. The <code>setTemplate($template_name)</code> method is used to define the template to be used by Smarty and the <code>setTemplateVars($key, $value)</code> method is used to set the template parameter values. The <code>setTemplateVars(...)</code> method accepts key as dot separated array path reference. That is you can use the below method as well:
        </p>
        <pre class="prettyprint linenums lang-php">
$this->view->setTemplateVars(\'metas.google-site-verification\', $googleVerification);
$this->view->setTemplateVars(\'metas.someName\', \'someValue\');</pre>

        <p class="para">
            And in the smarty template it will be available as follows -
        </p>

        <pre class="prettyprint linenums lang-php">
//Use In template file
<{foreach from=$metas key=k item=v}>
    <{if not empty($v) }>
        &lt;meta name="<{$k}>" content="<{$v}>" /&gt;
    <{/if}>
<{/foreach}>
//OR
&lt;meta name="<{$meta.someName}>" content="<{$meta.someValue}>" /&gt;
        </pre>

        <p class="para">
            Additional information on the available View methods can be found in the <a href="/documentation/api">API</a> section.
        </p>',

];