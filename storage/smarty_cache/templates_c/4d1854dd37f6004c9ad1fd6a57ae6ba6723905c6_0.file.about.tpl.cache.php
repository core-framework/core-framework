<?php
/* Smarty version 3.1.30, created on 2016-09-17 12:27:52
  from "/Users/shalom.s/Sites/CoreFramework/web/Templates/about.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57dce9705204c9_04477876',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4d1854dd37f6004c9ad1fd6a57ae6ba6723905c6' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/web/Templates/about.tpl',
      1 => 1444299605,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57dce9705204c9_04477876 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
$_smarty_tpl->compiled->nocache_hash = '210572702657dce9705029f7_62898315';
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_190048387557dce97051e639_67070512', "maincontent");
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['layout']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block "maincontent"} */
class Block_190048387557dce97051e639_67070512 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="container">
        <div class="row">
            <h1 class="heading">About</h1>
        </div>
        <div class="row">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab assumenda, atque beatae blanditiis cum
                deleniti
                doloremque impedit minus quidem totam! Beatae deserunt excepturi illo ipsa minima officia possimus
                provident
                sunt.
            </p>
        </div>
    </div>
<?php
}
}
/* {/block "maincontent"} */
}
