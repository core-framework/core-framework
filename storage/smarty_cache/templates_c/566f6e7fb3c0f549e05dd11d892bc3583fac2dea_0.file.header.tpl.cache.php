<?php
/* Smarty version 3.1.30, created on 2016-09-17 12:27:48
  from "/Users/shalom.s/Sites/CoreFramework/web/Templates/common/header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57dce96cb4df56_52988357',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '566f6e7fb3c0f549e05dd11d892bc3583fac2dea' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/web/Templates/common/header.tpl',
      1 => 1473707376,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:login_register.tpl' => 1,
  ),
),false)) {
function content_57dce96cb4df56_52988357 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '24202000657dce96cb14a69_09493187';
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
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
<?php $_smarty_tpl->_subTemplateRender("file:login_register.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
