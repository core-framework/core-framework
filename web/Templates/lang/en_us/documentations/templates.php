<?php

return $page = [
    'mainHeading' => 'Templates',
    'introPara' => '<strong>Templates</strong> in Core Framework is basically Smarty Templates (Additional template support will be added soon). All Smarty template files must reside in <code>{PROJECT_DIR}/web/Templates/</code> directory.
',
    'subTitle1' => 'Basic Folder Structure',
    'subTitle1_pLink' => 'basic-structure',
    'subPara1' => '<p>
        In Core Framework, the <code>Template/</code> directory consist of -
</p>
<pre class="prettyprint">
Templates/
|- common/
|- errors/
|root.tpl
</pre>
<p class="para">
    The root.tpl is the main Template layout file that contains the html skeletal structure. The root.tpl template structure is divided into 3 main blocks (ignoring the other blocks for now) the header, main content wrapper and footer blocks as shown below:
    <br/><br/>
    <img src="../images/CoreFramework-block.jpg" class="img-responsive" alt=""/>
    <br/><br/>
    The header and footer block basically contains the header and footer html code, which have been fragmented out and placed in the header.tpl and footer.tpl files in the <code>{PROJECT_DIR}/web/Templates/common/</code> directory. The <code>&apos;maincontentWrp&apos;</code> block contains the main page html. Smarty template engine enables extending template and have a parent-child relationship between templates. Core Framework displays a certain page by using this feature to override this section in the root.tpl file with the contents of the provided tpl file for that particular page. Thus the provided template file must contain the Smarty <code><{extends file="$layout"}></code> syntax. Which instructs the Smarty template Engine to override the follow block with the block present in the $layout file. By default the <code>$layout</code> value is root.tpl. This layout can be changed by setting it in the View object like so - <code>$this->view->layout = &apos;TEMPLATE_FILE_NAME.tpl&apos;</code>. For more info and available syntax&rsquo;s checkout the <a href="http://www.smarty.net/documentation" rel="nofollow">Smarty Documentation</a>
</p>
<p class="well well-small">
    <strong>Note:</strong> You are free to change the above structure if you choose, but it recommended that you use Smarty&rsquo;s <{extend}> syntax to extend blocks where necessary rather then editing the root.tpl file itself.
</p>
<p class="para">
    In the above mentioned folder structure the <code>{PROJECT_DIR}/web/Templates/errors/</code> directory contains the 404 error page template file.
</p>
'
];