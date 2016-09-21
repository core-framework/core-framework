<?php /* Smarty version Smarty-3.1.19-dev, created on 2016-09-13 01:31:09
         compiled from "/Users/shalom.s/Sites/CoreFramework/web/Templates/home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:47872842257d7098590fac6-02477236%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd41acf444d96acdd81097db8145f3777c0aeb633' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/web/Templates/home.tpl',
      1 => 1444299605,
      2 => 'file',
    ),
    '4275f26c16fa7240a069959f6d3747c523c8228b' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/web/Templates/root.tpl',
      1 => 1473707376,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '47872842257d7098590fac6-02477236',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'layout' => 0,
    'title' => 0,
    'metas' => 0,
    'v' => 0,
    'k' => 0,
    'showHeader' => 0,
    'showFooter' => 0,
    'script' => 0,
    'debugHtml' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_57d70985cc6480_45543358',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57d70985cc6480_45543358')) {function content_57d70985cc6480_45543358($_smarty_tpl) {?><!DOCTYPE html>
<html>

	<head>
		
			<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
		
		<!-- Metas -->
		
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['metas']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
				<?php if (!empty($_smarty_tpl->tpl_vars['v']->value)) {?>
					<meta name="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" content="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"/>
				<?php }?>
			<?php } ?>
		
		<!-- END: Metas -->
		<!-- Styles -->
		
			<link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
			<link rel="stylesheet" href="/styles/demo.min.css"/>
		
		<!-- END: Styles -->
		
			<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<![endif]-->
		
	</head>


	<body>
	
		<div class="midContent">
			<?php if ($_smarty_tpl->tpl_vars['showHeader']->value===true) {?>
				
					<?php echo $_smarty_tpl->getSubTemplate ("common/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				
			<?php }?>
			
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

		</div>
	
	<?php if ($_smarty_tpl->tpl_vars['showFooter']->value===true) {?>
		
			<footer class="footer">
				<?php echo $_smarty_tpl->getSubTemplate ("common/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			</footer>
		
	<?php }?>

    <!-- Scripts -->
    
        <script type="text/javascript" src="/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/scripts/init.min.js"></script>
    
    <!-- END: Scripts -->

    
        <?php if (isset($_smarty_tpl->tpl_vars['script']->value)) {?>
            <?php echo $_smarty_tpl->tpl_vars['script']->value;?>

        <?php }?>
    

    
        <?php if (isset($_smarty_tpl->tpl_vars['debugHtml']->value)) {?>
            <link rel="stylesheet" href="/styles/base.css"/>
            <?php echo $_smarty_tpl->tpl_vars['debugHtml']->value;?>

        <?php }?>
    
    </body>

</html><?php }} ?>
