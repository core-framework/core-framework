<?php
/* Smarty version 3.1.30, created on 2016-09-17 12:27:48
  from "/Users/shalom.s/Sites/CoreFramework/web/Templates/home.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57dce96c9c8de3_28324240',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1ed6f46bc2da8cb8da1fb083c17fac8d669e16db' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/web/Templates/home.tpl',
      1 => 1444299605,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_57dce96c9c8de3_28324240 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
$_smarty_tpl->compiled->nocache_hash = '176351433857dce96c850e25_66739018';
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_148404027957dce96c9c2fe5_41423911', "maincontent");
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['layout']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block "maincontent"} */
class Block_148404027957dce96c9c2fe5_41423911 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="jumbotron">
        <div class="container">
            <h1>Congratulations!!</h1>

            <p>You have successfully setup a Core Framework demo application.</p>

            <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more »</a></p>
        </div>
    </div>
    <div class="container">
        <!-- Example row of columns -->
        <div class="row">
            <div class="col-md-4">
                <h2>Heading</h2>

                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor
                    mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna
                    mollis euismod. Donec sed odio dui. </p>

                <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
            </div>
            <div class="col-md-4">
                <h2>Heading</h2>

                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor
                    mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna
                    mollis euismod. Donec sed odio dui. </p>

                <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
            </div>
            <div class="col-md-4">
                <h2>Heading</h2>

                <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula
                    porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh,
                    ut fermentum massa justo sit amet risus.</p>

                <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
            </div>
        </div>

        <hr>
    </div>
<?php
}
}
/* {/block "maincontent"} */
}
