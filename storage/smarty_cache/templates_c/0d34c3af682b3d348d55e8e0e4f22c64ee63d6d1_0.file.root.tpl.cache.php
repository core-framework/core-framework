<?php
/* Smarty version 3.1.30, created on 2016-09-17 12:27:48
  from "/Users/shalom.s/Sites/CoreFramework/web/Templates/root.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57dce96cab1e21_82008062',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0d34c3af682b3d348d55e8e0e4f22c64ee63d6d1' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/web/Templates/root.tpl',
      1 => 1473707376,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/header.tpl' => 1,
    'file:common/footer.tpl' => 1,
  ),
),false)) {
function content_57dce96cab1e21_82008062 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
$_smarty_tpl->compiled->nocache_hash = '69940654157dce96ca0ca60_53714804';
?>
<!DOCTYPE html>
<html>
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_51923909357dce96ca6bea8_71389794', "headBlock");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_119400505857dce96caafc01_42388969', "bodyBlock");
?>

</html><?php }
/* {block "title"} */
class Block_127643811157dce96ca34d96_73054799 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

			<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
		<?php
}
}
/* {/block "title"} */
/* {block "metas"} */
class Block_56995186057dce96ca5e993_25712359 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['metas']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
				<?php if (!empty($_smarty_tpl->tpl_vars['v']->value)) {?>
					<meta name="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" content="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"/>
				<?php }?>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		<?php
}
}
/* {/block "metas"} */
/* {block "styles"} */
class Block_187266591157dce96ca64480_65072018 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

			<link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
			<link rel="stylesheet" href="/styles/demo.min.css"/>
		<?php
}
}
/* {/block "styles"} */
/* {block "IECondn"} */
class Block_114055312257dce96ca69e27_05612413 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

			<!--[if lt IE 9]>
			<?php echo '<script'; ?>
 src="//html5shim.googlecode.com/svn/trunk/html5.js"><?php echo '</script'; ?>
>
			<![endif]-->
		<?php
}
}
/* {/block "IECondn"} */
/* {block "headBlock"} */
class Block_51923909357dce96ca6bea8_71389794 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<head>
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_127643811157dce96ca34d96_73054799', "title", $this->tplIndex);
?>

		<!-- Metas -->
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_56995186057dce96ca5e993_25712359', "metas", $this->tplIndex);
?>

		<!-- END: Metas -->
		<!-- Styles -->
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_187266591157dce96ca64480_65072018', "styles", $this->tplIndex);
?>

		<!-- END: Styles -->
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_114055312257dce96ca69e27_05612413', "IECondn", $this->tplIndex);
?>

	</head>
<?php
}
}
/* {/block "headBlock"} */
/* {block "header"} */
class Block_75806031857dce96ca7c889_56216715 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

					<?php $_smarty_tpl->_subTemplateRender("file:common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

				<?php
}
}
/* {/block "header"} */
/* {block "maincontent"} */
class Block_84845521557dce96ca828c9_89106084 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php
}
}
/* {/block "maincontent"} */
/* {block "maincontentWrp"} */
class Block_189365261157dce96ca846f7_84319330 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<div class="midContent">
			<?php if ($_smarty_tpl->tpl_vars['showHeader']->value === true) {?>
				<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_75806031857dce96ca7c889_56216715', "header", $this->tplIndex);
?>

			<?php }?>
			<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_84845521557dce96ca828c9_89106084', "maincontent", $this->tplIndex);
?>

		</div>
	<?php
}
}
/* {/block "maincontentWrp"} */
/* {block "footer"} */
class Block_78500101857dce96ca905e4_20862683 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

			<footer class="footer">
				<?php $_smarty_tpl->_subTemplateRender("file:common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

			</footer>
		<?php
}
}
/* {/block "footer"} */
/* {block "scripts"} */
class Block_93176368757dce96ca96f79_22742013 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <?php echo '<script'; ?>
 type="text/javascript" src="/bower_components/jquery/dist/jquery.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="/bower_components/bootstrap/dist/js/bootstrap.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="/scripts/init.min.js"><?php echo '</script'; ?>
>
    <?php
}
}
/* {/block "scripts"} */
/* {block "injected"} */
class Block_33156757657dce96caa1e06_33449469 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <?php if (isset($_smarty_tpl->tpl_vars['script']->value)) {?>
            <?php echo $_smarty_tpl->tpl_vars['script']->value;?>

        <?php }?>
    <?php
}
}
/* {/block "injected"} */
/* {block "devMode"} */
class Block_68099289257dce96caad490_68565839 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <?php if (isset($_smarty_tpl->tpl_vars['debugHtml']->value)) {?>
            <link rel="stylesheet" href="/styles/base.css"/>
            <?php echo $_smarty_tpl->tpl_vars['debugHtml']->value;?>

        <?php }?>
    <?php
}
}
/* {/block "devMode"} */
/* {block "bodyBlock"} */
class Block_119400505857dce96caafc01_42388969 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<body>
	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_189365261157dce96ca846f7_84319330', "maincontentWrp", $this->tplIndex);
?>

	<?php if ($_smarty_tpl->tpl_vars['showFooter']->value === true) {?>
		<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_78500101857dce96ca905e4_20862683', "footer", $this->tplIndex);
?>

	<?php }?>

    <!-- Scripts -->
    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_93176368757dce96ca96f79_22742013', "scripts", $this->tplIndex);
?>

    <!-- END: Scripts -->

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_33156757657dce96caa1e06_33449469', "injected", $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_68099289257dce96caad490_68565839', "devMode", $this->tplIndex);
?>

    </body>
<?php
}
}
/* {/block "bodyBlock"} */
}
