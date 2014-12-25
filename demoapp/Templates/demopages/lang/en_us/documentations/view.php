<?php

return $view = [
    'mainHeading' => 'View',
    'introPara' => '<strong>View</strong> in Core Framework is data holder object. The View object simply holds data such as the Template file to render and the dynamic key/value pair required by the specific template',
    'subTitle1' => 'View Example',
    'subTitle1_pLink' => 'view-example',
    'subPara1' => '<p class="para">
        View parameters must be set within the specific Controller the route is associated with. An example of this can be seen below -
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
            As seen the View object is available within the Controller using the <code>$this->view</code>. The <code>setTemplate($var)</code> method is used to define the template to be used by Smarty and the <code>setTemplateVars($key, $value)</code> method is used to store the template variable values. The <code>setTemplateVars(...)</code> method accepts key as dot seperated array path reference. That is you can use the below method:
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
            Additional information on the available View methods can be found <a href="/documentation/api/class-Core.Views.View.html">here</a>
        </p>'

];