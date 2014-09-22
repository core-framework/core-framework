<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-12 01:39:09
         compiled from "/Users/shalom.s/Sites/CoreFramework/app/Templates/errors/404.tpl" */ ?>
<?php /*%%SmartyHeaderCode:150805568954120165c9ba98-44937227%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bfb93fa57ee921802da30fa7cc24d3e3e50037ee' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/app/Templates/errors/404.tpl',
      1 => 1409466179,
      2 => 'file',
    ),
    'a053d7f11d3134c792c76966d3c50c78335beda7' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/app/Templates/root.tpl',
      1 => 1410463730,
      2 => 'file',
    ),
    'b02954defedd852f2eadddec724175c97b0104df' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/app/Templates/common/header.tpl',
      1 => 1408739406,
      2 => 'file',
    ),
    'a5b704379ee0e8db013c3a33e180abe8bbbb28b2' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/app/Templates/common/footer.tpl',
      1 => 1408739351,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '150805568954120165c9ba98-44937227',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'script' => 0,
    'debugDfltHtml' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_54120165ea6ab9_50638253',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54120165ea6ab9_50638253')) {function content_54120165ea6ab9_50638253($_smarty_tpl) {?><!DOCTYPE html>
<html>

<head>
    
        <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
    
    <!-- Metas -->
    
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Documentation for Core Framework">
        <meta name="author" content="Shalom Sam">
    
    <!-- END: Metas -->
    <!-- Styles -->
    
        <link href="/styles/bootstrap/bootstrap.min.css" type="text/css" rel="stylesheet" />
    
    <!-- END: Styles -->
    
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    
</head>


<body ng-app="siteOptimizeApp">
    
        <a id="top"></a>
        <div class="header">
            <?php /*  Call merged included template "common/header.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '150805568954120165c9ba98-44937227');
content_54120165d6a0f1_40354838($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "common/header.tpl" */?>
        </div>
    
    
        <div class="midContent">
            
    <div class="page">
        <h1>Oops something went wrong! Page not found.</h1>
    </div>

        </div>
    
    
        <div class="footer">
            <?php /*  Call merged included template "common/footer.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '150805568954120165c9ba98-44937227');
content_54120165de6038_62757100($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "common/footer.tpl" */?>
        </div>
        <a id="bottom"></a>
    

    <!-- Scripts -->
    
        
        
    
    <!-- END: Scripts -->

    
        <?php if ($_smarty_tpl->tpl_vars['script']->value) {?>
            <?php echo $_smarty_tpl->tpl_vars['script']->value;?>

        <?php }?>
    

    
        <?php if ($_smarty_tpl->tpl_vars['debugDfltHtml']->value) {?>
            <?php echo $_smarty_tpl->tpl_vars['debugDfltHtml']->value;?>

        <?php }?>
    
</body>

</html><?php }} ?>
<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-12 01:39:09
         compiled from "/Users/shalom.s/Sites/CoreFramework/app/Templates/common/header.tpl" */ ?>
<?php if ($_valid && !is_callable('content_54120165d6a0f1_40354838')) {function content_54120165d6a0f1_40354838($_smarty_tpl) {?><div class="centralize">
    <div id="logo" class="logowrap lfloat">MyTrackingApp</div>
    <ul class="rfloat menu">
        <li>home</li>
        <li>plans</li>
        <li>contact</li>
        <li>about</li>
    </ul>
    <div class="clear"></div>
</div><?php }} ?>
<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-12 01:39:09
         compiled from "/Users/shalom.s/Sites/CoreFramework/app/Templates/common/footer.tpl" */ ?>
<?php if ($_valid && !is_callable('content_54120165de6038_62757100')) {function content_54120165de6038_62757100($_smarty_tpl) {?><div class="ftrText">
    This app is powered by WebApps
</div><?php }} ?>
