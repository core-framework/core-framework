<?php /* Smarty version Smarty-3.1.19-dev, created on 2016-09-13 01:31:09
         compiled from "/Users/shalom.s/Sites/CoreFramework/web/Templates/common/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:51019764157d70985ce8894-76181421%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '43ef43fd8fe85ac382d818adf4c7eb824500609f' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/web/Templates/common/header.tpl',
      1 => 1473707376,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '51019764157d70985ce8894-76181421',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'site' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_57d70985d52644_62518096',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d70985d52644_62518096')) {function content_57d70985d52644_62518096($_smarty_tpl) {?><nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"> <span class="logo-txt"><?php echo $_smarty_tpl->tpl_vars['site']->value['appName'];?>
</span> <sup
                        class="label label-success"><?php echo $_smarty_tpl->tpl_vars['site']->value['appVersion'];?>
</sup></a>
        </div>
        <div class="navbar-collapse collapse" style="height: 1px;">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <?php if (isset($_SESSION['user'])) {?>
                    
                    <li><a href="/"><?php echo $_SESSION['user']['name'];?>
</a></li>
                    <li><a href="/user/logout">Logout</a></li>
                <?php } else { ?>
                    <li><a data-toggle="modal" data-target="#registerModal" href="#">Register</a></li>
                    <li><a data-toggle="modal" data-target="#loginModal" href="#">Login</a></li>
                <?php }?>
            </ul>
            <!--<form class="navbar-form navbar-right">-->
            <!--<input type="text" class="form-control" placeholder="Search...">-->
            <!--</form>-->
        </div>
    </div>
</nav>

<!-- Login and Registration Modals -->
<?php echo $_smarty_tpl->getSubTemplate ("login_register.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
