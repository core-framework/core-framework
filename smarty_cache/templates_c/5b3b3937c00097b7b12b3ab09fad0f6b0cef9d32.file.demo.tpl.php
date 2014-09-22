<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-22 09:14:57
         compiled from "/Users/shalom.s/Sites/CoreFramework/demoapp/Templates/demopages/demo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:56886190854152f263c5b67-38102687%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b3b3937c00097b7b12b3ab09fad0f6b0cef9d32' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/demoapp/Templates/demopages/demo.tpl',
      1 => 1411329812,
      2 => 'file',
    ),
    'f3eb2434bbfe6110b0d9abfd4de0922de1dea582' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/demoapp/Templates/root.tpl',
      1 => 1410885270,
      2 => 'file',
    ),
    '0e8ffd8389e87c8d4b2df31cd7b8b41afea66d92' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/demoapp/Templates/common/header.tpl',
      1 => 1408739406,
      2 => 'file',
    ),
    'fb9a56ec72c3036464710ed2262c65521c3763f0' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/demoapp/Templates/common/footer.tpl',
      1 => 1408739351,
      2 => 'file',
    ),
    'bbd75fab47c4e4b4930e3425c5df2468ccba4c6f' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/demoapp/Templates/demopages/navs.tpl',
      1 => 1410705664,
      2 => 'file',
    ),
    '43a294ddd7f509863ac7eb4bc7e627b6cb21443a' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/demoapp/Templates/demopages/introSection.tpl',
      1 => 1411105638,
      2 => 'file',
    ),
    '6df91459c612c032b3c11a449589371188aee53f' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/demoapp/Templates/errors/404.tpl',
      1 => 1411329430,
      2 => 'file',
    ),
    '6a2f1ad61fc26926b136c0c09fa0b5ef2fcea845' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/demoapp/Templates/demopages/footer.tpl',
      1 => 1410710235,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '56886190854152f263c5b67-38102687',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_54152f265b17e9_16508763',
  'variables' => 
  array (
    'title' => 0,
    'script' => 0,
    'debugDfltHtml' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54152f265b17e9_16508763')) {function content_54152f265b17e9_16508763($_smarty_tpl) {?><!DOCTYPE html>
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
    
    <link href="/styles/prettify.css" type="text/css" rel="stylesheet" />
    <link href="/styles/demo/demo.css" type="text/css" rel="stylesheet" />

    <!-- END: Styles -->
    
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    
</head>


    <body id="top" class="<?php echo $_smarty_tpl->tpl_vars['pagename']->value;?>
">

    <div class="mainWrp clearfix">
        
            <!--  NAVIGATION BAR START  -->
            <?php /*  Call merged included template "demopages/navs.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("demopages/navs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '56886190854152f263c5b67-38102687');
content_541f9b3a3424d5_47301604($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "demopages/navs.tpl" */?>
            <!--  NAVIGATION BAR END  -->
        


        <!--  MAIN CONTAINER START  -->
        <div class="container midWrp">

            
                <?php if ($_smarty_tpl->tpl_vars['pagename']->value=='home') {?>
                    <!-- SECTION: OVERVIEW START -->
                    <?php /*  Call merged included template "demopages/introSection.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("demopages/introSection.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '56886190854152f263c5b67-38102687');
content_541f9b3a4aa6d9_89128590($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "demopages/introSection.tpl" */?>
                    <!-- SECTION: OVERVIEW END -->
                <?php } elseif (!isset($_smarty_tpl->tpl_vars['page']->value)&&isset($_smarty_tpl->tpl_vars['error']->value)) {?>
                    <?php /*  Call merged included template "errors/404.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("errors/404.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '56886190854152f263c5b67-38102687');
content_541f9b3a5dbe63_85181588($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "errors/404.tpl" */?>
                <?php }?>
            

        </div>
        <!--  MAIN CONTAINER END  -->
        
            <?php /*  Call merged included template "demopages/footer.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("demopages/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '56886190854152f263c5b67-38102687');
content_541f9b3a631e60_03388021($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "demopages/footer.tpl" */?>
        
    </div>

    <!-- loading javascripts -->
    
        <script src="/scripts/jquery/jquery.js"></script>
        <script src="/scripts/bootstrap/bootstrap.min.js"></script>
        <script src="/scripts/prettify.js"></script>
        <!-- init javascripts -->
        <script src="/scripts/init.js"></script>
    

    
        <?php if ($_smarty_tpl->tpl_vars['script']->value) {?>
            <?php echo $_smarty_tpl->tpl_vars['script']->value;?>

        <?php }?>
    

    
        <?php if ($_smarty_tpl->tpl_vars['debugDfltHtml']->value) {?>
            <?php echo $_smarty_tpl->tpl_vars['debugDfltHtml']->value;?>

        <?php }?>
    

    </body>

</html><?php }} ?>
<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-22 09:14:58
         compiled from "/Users/shalom.s/Sites/CoreFramework/demoapp/Templates/common/header.tpl" */ ?>
<?php if ($_valid && !is_callable('content_541f9b3a208559_99833658')) {function content_541f9b3a208559_99833658($_smarty_tpl) {?><div class="centralize">
    <div id="logo" class="logowrap lfloat">MyTrackingApp</div>
    <ul class="rfloat menu">
        <li>home</li>
        <li>plans</li>
        <li>contact</li>
        <li>about</li>
    </ul>
    <div class="clear"></div>
</div><?php }} ?>
<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-22 09:14:58
         compiled from "/Users/shalom.s/Sites/CoreFramework/demoapp/Templates/common/footer.tpl" */ ?>
<?php if ($_valid && !is_callable('content_541f9b3a2670d3_98493144')) {function content_541f9b3a2670d3_98493144($_smarty_tpl) {?><div class="ftrText">
    This app is powered by WebApps
</div><?php }} ?>
<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-22 09:14:58
         compiled from "/Users/shalom.s/Sites/CoreFramework/demoapp/Templates/demopages/navs.tpl" */ ?>
<?php if ($_valid && !is_callable('content_541f9b3a3424d5_47301604')) {function content_541f9b3a3424d5_47301604($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/Users/shalom.s/Sites/CoreFramework/vendor/smarty/smarty/distribution/libs/plugins/modifier.replace.php';
?>
    
        
            
                
            
            
            
                
                    
                        
                            
                        
                    
                
            
        
    


<div class="navbar navbar-custom navbar-fixed-top navbar-inverse" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['product']['name'];?>
 <sup class="small bg-green">alpha</sup></a>
        </div>
        <div class="navbar-collapse collapse" style="height: 1px;">
            <ul class="nav navbar-nav navbar-right">
                <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['docVarsCom']->value['navs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value) {
$_smarty_tpl->tpl_vars['i']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
                    <li class="<?php echo mb_strtolower(smarty_modifier_replace($_smarty_tpl->tpl_vars['k']->value," ","_"), 'UTF-8');?>
">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
</a>
                    </li>
                <?php } ?>
            </ul>
            <!--<form class="navbar-form navbar-right">-->
            <!--<input type="text" class="form-control" placeholder="Search...">-->
            <!--</form>-->
        </div>
    </div>
</div><?php }} ?>
<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-22 09:14:58
         compiled from "/Users/shalom.s/Sites/CoreFramework/demoapp/Templates/demopages/introSection.tpl" */ ?>
<?php if ($_valid && !is_callable('content_541f9b3a4aa6d9_89128590')) {function content_541f9b3a4aa6d9_89128590($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/Users/shalom.s/Sites/CoreFramework/vendor/smarty/smarty/distribution/libs/plugins/modifier.replace.php';
?><section id="overview" class="row">

    <div class="hero-unit">
        <h1>Welcome to <?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['product']['name'];?>
</h1>
        <p><?php echo $_smarty_tpl->tpl_vars['home']->value['created_by_txt'];?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['author']['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['author']['name'];?>
</a></p>
        <p><?php echo $_smarty_tpl->tpl_vars['home']->value['intro_para'];?>
</p>
        <br/>
        <p class="well well-small"><?php echo $_smarty_tpl->tpl_vars['home']->value['intro_note'];?>
</p>
        
            
            
            
            
        

    </div>

    <hr>

    <div class="container center-block productInfo">
        <div class="col-xs-12 col-lg-4 row center-block">
            <div class="row">
                <div class="col-xs-6 col-lg-3">
                    Author:
                </div>
                <div class="col-xs-6 col-lg-9">
                    <?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['author']['name'];?>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-lg-3">
                    Contact:
                </div>
                <div class="col-xs-6 col-lg-9">
                    <a href="#"><?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['author']['email'];?>
</a>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-4 row center-block">
            <div class="row">
                <div class="col-xs-6 col-lg-4">
                    Author URL:
                </div>
                <div class="col-xs-6 col-lg-8">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['author']['url'];?>
"><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['docVarsCom']->value['author']['url'],"http://",'');?>
</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-lg-4">
                    Core Version:
                </div>
                <div class="col-xs-6 col-lg-8">
                    <?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['product']['current_ver'];?>

                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-4 center-block">
            <div class="row">
                <div class="col-xs-6">
                    Documentation Version:
                </div>
                <div class="col-xs-6">
                    <?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['product']['doc_ver'];?>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    Product Created:
                </div>
                <div class="col-xs-6">
                    <?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['product']['created_on'];?>

                </div>
            </div>
        </div>
    </div>

    <hr>

</section><?php }} ?>
<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-22 09:14:58
         compiled from "/Users/shalom.s/Sites/CoreFramework/demoapp/Templates/errors/404.tpl" */ ?>
<?php if ($_valid && !is_callable('content_541f9b3a5dbe63_85181588')) {function content_541f9b3a5dbe63_85181588($_smarty_tpl) {?>


    <div class="page">
        <h1>Oops something went wrong! Page not found.</h1>
    </div>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-22 09:14:58
         compiled from "/Users/shalom.s/Sites/CoreFramework/demoapp/Templates/demopages/footer.tpl" */ ?>
<?php if ($_valid && !is_callable('content_541f9b3a631e60_03388021')) {function content_541f9b3a631e60_03388021($_smarty_tpl) {?><div class="footerWrp">
    <footer class="container center-block">
        <p>&copy; <?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['product']['name'];?>
 2014</p>
    </footer>
</div><?php }} ?>
