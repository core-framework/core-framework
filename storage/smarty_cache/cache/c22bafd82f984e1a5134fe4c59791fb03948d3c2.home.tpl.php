<?php
/* Smarty version 3.1.30, created on 2016-09-17 20:22:41
  from "/Users/shalom.s/Sites/CoreFramework/web/Templates/home.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_57dd58b9246996_48616730',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1ed6f46bc2da8cb8da1fb083c17fac8d669e16db' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/web/Templates/home.tpl',
      1 => 1444299605,
      2 => 'file',
    ),
    '0d34c3af682b3d348d55e8e0e4f22c64ee63d6d1' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/web/Templates/root.tpl',
      1 => 1473707376,
      2 => 'file',
    ),
    '566f6e7fb3c0f549e05dd11d892bc3583fac2dea' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/web/Templates/common/header.tpl',
      1 => 1473707376,
      2 => 'file',
    ),
    '5533dccba9d11bcbcda6581446bd2a831984b520' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/web/Templates/login_register.tpl',
      1 => 1473707376,
      2 => 'file',
    ),
    '566b86665e69ad868e56b03ce39dac09929e1eca' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/web/Templates/common/footer.tpl',
      1 => 1444299605,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 60,
),true)) {
function content_57dd58b9246996_48616730 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>

	<head>
		
			<title>Demo Home Page</title>
		
		<!-- Metas -->
		
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">
												<meta name="keywords" content="test, keywords, for test"/>
																<meta name="description" content="This is a test description"/>
																<meta name="author" content="Shalom Sam"/>
														
		
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
							
					<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"> <span class="logo-txt">YourApp</span> <sup
                        class="label label-success">v1</sup></a>
        </div>
        <div class="navbar-collapse collapse" style="height: 1px;">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                                    <li><a data-toggle="modal" data-target="#registerModal" href="#">Register</a></li>
                    <li><a data-toggle="modal" data-target="#loginModal" href="#">Login</a></li>
                            </ul>
            <!--<form class="navbar-form navbar-right">-->
            <!--<input type="text" class="form-control" placeholder="Search...">-->
            <!--</form>-->
        </div>
    </div>
</nav>

<!-- Login and Registration Modals -->
<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="col-sm-6">
                            <h4 class="modal-title" id="myModalLabel">Register</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <p class="text-grey">*All fields are required</p>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-sm-12">
                            <div class="alert alert-warning">
                                <strong>Note:</strong> This modal can be edited at: <code>/Users/shalom.s/Sites/CoreFramework/app
                                    /Templates/login_register.tpl</code>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="registerErrBlock" class="notice alert" style="display: none;">
                    <!-- error block -->
                </div>
                <form id="registerForm" class="container-fluid" action="/user/register">
                    <input type="hidden" name="csrf-token" value="b7a60581ef7421275a4b5a805ec571d9" />
                    <div class="row-fluid">
                        <div class="col-md-6 col-xs-12">
                            <input type="text" name="fname" placeholder="First Name *" required/>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <input type="text" name="lname" placeholder="Last Name *" required/>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-xs-12">
                            <input type="email" name="email" placeholder="Email Address *" required/>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-md-6 col-xs-12">
                            <input id="password" type="password" name="password" placeholder="Password *" required/>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <input id="password_confirm" type="password" name="password_confirm"
                                   placeholder="Confirm Password *" required/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="col-sm-12 text-center">
                            <button id="registerBtn" data-loading-text="Registering..." type="button"
                                    class="btn btn-default btn-primary btn-fluid">REGISTER
                            </button>
                        </div>
                        <div class="col-sm-12 signin-wrap text-center">
                            <p>By clicking 'REGISTER' you agree to our <a href="/terms">Terms & Conditions</a></p>

                            <p>Already have an account? <a id="loginLink" href="#login">Sign in</a></p>
                        </div>
                    </div>
                </div>

                
                
            </div>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="col-sm-6">
                            <h4 class="modal-title" id="myModalLabel">Login</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <p class="text-grey">*All fields are required</p>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-sm-12">
                            <div class="alert alert-warning">
                                <strong>Note:</strong> This modal can be edited at: <code>/Users/shalom.s/Sites/CoreFramework/app
                                    /Templates/login_register.tpl</code>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="loginErrBlock" class="notice alert" style="display: none;">
                    <!-- error block -->
                </div>
                <form id="loginForm" class="container-fluid" action="/user/login">
                    <input type="hidden" name="csrf" value="" />
                    <div class="row-fluid">
                        <div class="col-xs-12">
                            <input type="email" name="email" placeholder="Email Address *" required/>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="col-xs-12">
                            <input type="password" name="password" placeholder="Password *" required/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="col-sm-12 text-center">
                            <button id="loginBtn" data-loading-text="Verifying..." type="button"
                                    class="btn btn-default btn-primary btn-fluid">LOGIN
                            </button>
                        </div>
                        <div class="col-sm-12 signin-wrap text-center">
                            <p>Do not have an account? <a id="registerLink" href="#register">Register now</a></p>
                        </div>
                    </div>
                </div>

                
                
            </div>
        </div>
        <div class="forgot-pass-wrap text-center">
            <a id="forgotpass" href="#forgotpass">Forgot your password?</a>
        </div>
    </div>
</div>

<!-- forgot password modal -->
<div class="modal fade" id="forgotPassModal" tabindex="-1" role="dialog" aria-labelledby="forgotPassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="col-sm-6">
                            <h4 class="modal-title" id="forgotPassLabel">Forgot Password</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                            <p class="text-grey">*All fields are required</p>
                        </div>
                    </div>
                </div>
                <div id="fpMsgBlock" class="notice alert" style="display: none;">
                    <!-- error block -->
                </div>
                <form id="forgotPassForm" class="container-fluid" action="/user/forgotpass">
                    <input type="hidden" name="csrf" value="" />
                    <div class="row-fluid">
                        <div class="col-xs-12">
                            <input type="email" name="email" placeholder="Email Address *" required />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="col-sm-12 text-center">
                            <button id="forgotPassBtn" data-loading-text="Sending Email..." type="button" class="btn btn-default btn-gold btn-fluid" >RESET PASSWORD</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
				
						
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
	
			
			<footer class="footer">
				<div class="container">
    <p class="pull-left">© MyApp 2015</p>

    <p class="pull-right">Powered by <a href="http://www.coreframework.in/" rel="external">Core Framework</a></p>
</div>
			</footer>
		
	
    <!-- Scripts -->
    
        <script type="text/javascript" src="/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/scripts/init.min.js"></script>
    
    <!-- END: Scripts -->

    
            

    
            
    </body>

</html><?php }
}
