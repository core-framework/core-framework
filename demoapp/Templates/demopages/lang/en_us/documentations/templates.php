<?php

return $page = [
    'mainHeading' => 'Templates',
    'introPara' => '<strong>Templates</strong> in Core Framework is basically Smarty Templates. All Smarty tpl files must reside in <code>{your-App}/Templates/</code> directory. If for some reason you need the templates to be in some other location, then in your applications index.php file you must add the following line before <code>$core->Load()</code> -
    <pre class="prettyprint">$core->setTemplateDir({path/to/dir});</pre>
    Where the path must be a relative path, relative to the Core Framework root folder. For more information on Smarty please refer to the <a href="http://www.smarty.net/" rel="nofollow">Smarty website</a>.
',
    'subTitle1' => 'Basic Structure',
    'subTitle1_pLink' => 'basic-structure',
    'subPara1' => '<p>
        In Core Framework, the <code>Template/</code> directory consist of -
</p>
<pre class="prettyprint">
Templates/
|- common/
|- errors/
|- root/
|root.tpl
</pre>
<p class="para">
    The root.tpl is the main Template file that contains the html skeletal structure. The root.tpl template structure is divided into 3 main blocks (ignoring the other blocks for now) the header, maincontentWrp and footer blocks. The header and footer block basically contains the header and footer html code, which have been fragmented out placed in the header.tpl and footer.tpl files in the <code>common/</code> directory. The maincontentWrp block contains the main page html. Core Framework displays a certain page by overriding this section in the root.tpl file with the contents of the provided tpl file for that particular page. For this the provided tpl file must contain the Smarty <code><{extends file="root.tpl"}></code> syntax. Which instructs the Smarty template Engine to override the follow block with the block present in the root.tpl file. For more info and available syntax&rsquo;s checkout the <a href="http://www.smarty.net/documentation" rel="nofollow">Smarty Documentation</a>
</p>
<p class="well well-small">
<strong>Note:</strong> You are free to change the above structure if you choose, but it recommended that you use Smarty&rsquo;s <{extend}> syntax to extend blocks where necessary rather then editing the root.tpl file itself.
</p>
<p class="para">
    In the above mentioned structure the <code>errors/</code> directory contains the 404 error page tpl file. And the <code>root/</code> folder contains all the root components like favicon, etc. Even files to be served under the domains root must be placed in this folder.
</p>
'
];