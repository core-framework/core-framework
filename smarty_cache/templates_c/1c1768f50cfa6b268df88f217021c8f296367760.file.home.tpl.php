<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-11 16:50:55
         compiled from "/Users/shalom.s/Sites/CoreFramework/app/Templates/homepage/home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4422667735411859737ab93-15542939%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c1768f50cfa6b268df88f217021c8f296367760' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/app/Templates/homepage/home.tpl',
      1 => 1410433288,
      2 => 'file',
    ),
    'a053d7f11d3134c792c76966d3c50c78335beda7' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/app/Templates/root.tpl',
      1 => 1410433332,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4422667735411859737ab93-15542939',
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
  'unifunc' => 'content_541185974ed305_02088122',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_541185974ed305_02088122')) {function content_541185974ed305_02088122($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
    
        <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
    
    <!-- Metas -->
    
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- END: Metas -->
    <!-- Styles -->
    
        <link href="/styles/bootstrap/bootstrap.min.css" type="text/css" rel="stylesheet" />
        <link href="/styles/style.css" type="text/css" rel="stylesheet" />
    
    <!-- END: Styles -->
</head>
<body ng-app="siteOptimizeApp">
    
        <a id="top"></a>
        <div class="header">
            <?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </div>
    
    
        <div class="midContent" ng-controller="MainController">
            <div ng-cloak class="error-msg global login" ng-show="globalErr">
                <span class="errMsg">{{msg}}</span>
            </div>
            
    <div class="page <?php echo $_smarty_tpl->tpl_vars['pageName']->value;?>
">
        <div class="Banners">

        </div>
        <div class="pricing">
            <div class="plansWrap">
                <form action="/checkout" method="post">
                    <ul class="products">
                        <li><input id="mousetracker" type="checkbox" value="mousetracker" /><label for="mousetracker">Mouse Tracker</label></li>
                        <li><input id="clicktracker" type="checkbox" value="clicktracker" /><label for="clicktracker">Click Tracker</label></li>
                        <li><input id="userprofile" type="checkbox" value="userprofile" /><label for="userprofile">User profile</label></li>
                    </ul>
                </form>
            </div>
        </div>
        <div class="extra">

        </div>
    </div>

        </div>
    
    
        <div class="footer">
            <?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

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
