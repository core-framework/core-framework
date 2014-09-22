<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-13 15:47:45
         compiled from "/Users/shalom.s/Sites/CoreFramework/app/Templates/demopages/demo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12034661235411feb4c4a214-34252679%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0df5b95b30e778e961af2c09f0ff6f2c6c4ccaa0' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/app/Templates/demopages/demo.tpl',
      1 => 1410534559,
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
    '7513ab6732892ea395838b373e19c55b1915f1bc' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/app/Templates/demopages/navs.tpl',
      1 => 1410497451,
      2 => 'file',
    ),
    '5ca75efea6237316a842341ecadf5f331a3ef364' => 
    array (
      0 => '/Users/shalom.s/Sites/CoreFramework/app/Templates/demopages/introSection.tpl',
      1 => 1410603447,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12034661235411feb4c4a214-34252679',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_5411feb4e9e1f3_70559666',
  'variables' => 
  array (
    'title' => 0,
    'script' => 0,
    'debugDfltHtml' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5411feb4e9e1f3_70559666')) {function content_5411feb4e9e1f3_70559666($_smarty_tpl) {?><!DOCTYPE html>
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
    
    <link href="/styles/bootstrap-ext.css" type="text/css" rel="stylesheet" />
    <link href="/styles/bootstrap-responsive.css" type="text/css" rel="stylesheet" />
    <link href="/styles/prettify.css" type="text/css" rel="stylesheet" />
    <link href="/styles/demo/demo.css" type="text/css" rel="stylesheet" />

    <!-- Various Icons (Favicon, Touch Icon,... -->
    
    
    
    
    <style type="text/css">
        body {
            padding-bottom: 40px;
        }

        section {padding: 60px 0 0 0;}
    </style>

    <!-- END: Styles -->
    
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    
</head>


    <body data-spy="scroll" data-target=".navbar" id="top">

    
        <!-- ========================= NAVIGATION BAR >> START ========================= -->
        <?php /*  Call merged included template "demopages/navs.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("demopages/navs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '12034661235411feb4c4a214-34252679');
content_541419c94c8fd1_04538113($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "demopages/navs.tpl" */?>
        <!-- ========================= NAVIGATION BAR >> END ========================= -->
    


    <!-- ========================= MAIN CONTAINER >> START ========================= -->
    <div class="container">

    
        <?php if ($_smarty_tpl->tpl_vars['pagename']->value!='demo_home') {?>
            <!-- ========================= SECTION: OVERVIEW >> START ========================= -->
            <?php /*  Call merged included template "demopages/introSection.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("demopages/introSection.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '12034661235411feb4c4a214-34252679');
content_541419c94fd521_14177832($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "demopages/introSection.tpl" */?>
            <!-- ========================= SECTION: OVERVIEW >> END ========================= -->
        <?php }?>
    


    <!-- ========================= SECTION: MARKUP >> START ========================= -->
    <section id="markup">
        <div class="page-header">
            <h1>Markup <small>Markup customization and highlights</small></h1>
        </div>

        <div class="alert"> <a class="close" data-dismiss="alert">×</a> <strong>Warning!</strong> Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.. </div>
        <p>This theme is a fixed layout with two columns. All of the information within the main content area is nested within a div with an id of "primaryContent". The sidebar's (column #2) content is within a div with an id of "secondaryContent".</p>

        <hr />

        <div class="row">
            <div class="span3">
                <h3>General Markup</h3>
                <p> The general template structure is the same throughout the template. Here is the general structure.</p>
            </div>

            <div class="span9">

                <!-- Code Block >> Start -->
<pre class="prettyprint linenums">&lt;!DOCTYPE html PUBLIC &quot;-//W3C//DTD HTML 4.01//EN&quot;
&quot;http://www.w3.org/TR/html4/strict.dtd&quot;&gt;

&lt;html lang=&quot;en&quot;&gt;
&lt;head&gt;
&lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;
&lt;title&gt;untitled&lt;/title&gt;
&lt;meta name=&quot;generator&quot; content=&quot;TextMate http://macromates.com/&quot;&gt;
&lt;meta name=&quot;author&quot; content=&quot;Ivor Padilla&quot;&gt;
&lt;!-- Date: 2012-03-08 --&gt;
&lt;/head&gt;
&lt;body&gt;

&lt;/body&gt;
&lt;/html&gt;</pre>
                <!-- Code Block >> End -->

            </div>
        </div>

        <hr />

        <div class="row">
            <div class="span3">
                <h3>How To Edit Color</h3>
                <p>If you would like to edit the color, font, or style of any elements in one of these columns, you would do the following:</p>
            </div>

            <div class="span9">

                <!-- Code Block >> Start -->
<pre class="prettyprint linenums">#primaryContent a {
  color: #someColor;
}</pre>
                <!-- Code Block >> End -->

            </div>
        </div>

        <hr />

        <div class="row">
            <div class="span3">
                <h3>Change Structure</h3>
                <p>If you find that your new style is not overriding, it is most likely because of a specificity problem. Scroll down in your CSS file and make sure that there isn't a similar style that has more weight.</p>
            </div>

            <div class="span9">

                <!-- Code Block >> Start -->
<pre class="prettyprint linenums">#wrap #primaryContent a {
  color: #someColor;
}</pre>
                <!-- Code Block >> End -->

            </div>
        </div>
    </section>
    <!-- ========================= SECTION: MARKUP >> END ========================= -->



    <!-- ========================= SECTION: STYLES >> START ========================= -->
    <section id="styles">
        <div class="page-header">
            <h1>Styles <small>Styles customization and highlights</small></h1>
        </div>

        <div class="alert alert-info"> <b>Heads up!</b> I'm using two CSS files in this theme. The first one is a generic reset file. Many browser interpret the default behavior of html elements differently. By using a general reset CSS file, we can work round this. This file also contains some general styling, such as anchor tag colors, font-sizes, etc. Keep in mind, that these values might be overridden somewhere else in the file. </div>

        <div class="row">
            <div class="span3">
                <h3>Stylesheets</h3>
                <p>Here's a list of the stylesheet files I'm using with this template, you can find more information opening each file:</p>
            </div>
            <div class="span9">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><code>styles.css</code></td>
                        <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                    </tr>
                    <tr>
                        <td><code>reset.css</code></td>
                        <td>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Cras justo odio.</td>
                    </tr>
                    <tr>
                        <td><code>typography.css</code></td>
                        <td>Sed posuere consectetur est at lobortis.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <hr />

        <div class="row">
            <div class="span3">
                <h3>CSS Structure</h3>
                <p>The second file contains all of the specific stylings for the page. The file is separated into sections using:</p>
            </div>

            <div class="span9">

                <!-- Code Block >> Start -->
<pre class="pre-scrollable prettyprint linenums">/* === Header Section === */

some code

/* === Main Section === */

some code

/* === Sidebar Section === */

some code

/* === Footer === */

some code

etc, etc.</pre>
                <!-- Code Block >> End -->

            </div>
        </div>

    </section>
    <!-- ========================= SECTION: STYLES >> END ========================= -->



    <!-- ========================= SECTION: JAVASCRIPT >> START ========================= -->
    <section id="javascript">

        <div class="page-header">
            <h1>JavaScript <small>JavaScript customization and highlights</small></h1>
        </div>

        <div class="row">
            <div class="span3">
                <h3>JavaScript Files</h3>
                <p>Vestibulum id ligula porta felis euismod semper. Curabitur blandit tempus porttitor. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
            </div>
            <div class="span9">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Tag</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><code>jquery.js</code></td>
                        <td>jQuery is a Javascript library that greatly reduces the amount of code that you must write.</td>
                    </tr>
                    <tr>
                        <td><code>script.js</code></td>
                        <td>Most of the animation in this site is carried out from the customs scripts. There are a few functions worth looking over.</td>
                    </tr>
                    <tr>
                        <td><code>myPlugin.js</code></td>
                        <td>In addition to the custom scripts, I implement a few "tried and true" plugins to create the effects. This plugin is packed, so you won't need to manually edit anything in the file.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <hr />

        <div class="row">
            <div class="span3">
                <h3>Customize Slider</h3>
                <p>If you want to change the slider's speed transition, open up the file <code> scripts.js </code> and change the following code: </p>
            </div>
            <div class="span9">

                <!-- Code Block >> Start -->
<pre class="prettyprint js linenums:103">/* ---------- @ SlidesJS -----------*/
$(&#x27;#banner&#x27;).slides({
  preload: true,
  generateNextPrev: true,
  autoHeight: true,
  effect: &quot;slide&quot;,
  play: 5000
});</pre>
                <!-- Code Block >> End -->

            </div>
        </div>

    </section>
    <!-- ========================= SECTION: JAVASCRIPT >> END ========================= -->



    <!-- ========================= SECTION: PSD >> START ========================= -->
    <section id="psd">
        <div class="page-header">
            <h1>Photoshop Files <small>Photoshop customization and highlights</small></h1>
        </div>
        <p>I've included three psds with this theme:</p>
        <ul class="thumbnails">
            <li class="span3">
                <div class="thumbnail"> <img src="http://placehold.it/260x180" alt="">
                    <div class="thumb-info">
                        <h5>Thumbnail label</h5>
                        <p>Thumbnail caption right here...</p>
                    </div>
                </div>
            </li>
            <li class="span3">
                <div class="thumbnail"> <img src="http://placehold.it/260x180" alt="">
                    <div class="thumb-info">
                        <h5>Thumbnail label</h5>
                        <p>Thumbnail caption right here...</p>
                    </div>
                </div>
            </li>
            <li class="span3">
                <div class="thumbnail"> <img src="http://placehold.it/260x180" alt="">
                    <div class="thumb-info">
                        <h5>Thumbnail label</h5>
                        <p>Thumbnail caption right here...</p>
                    </div>
                </div>
            </li>
            <li class="span3">
                <div class="thumbnail"> <img src="http://placehold.it/260x180" alt="">
                    <div class="thumb-info">
                        <h5>Thumbnail label</h5>
                        <p>Thumbnail caption right here...</p>
                    </div>
                </div>
            </li>
        </ul>
        <p>If you'd like to change the main image in the header, open "header.psd", make the necessary adjustments, and then save the file as "headerBG.png". Do the same for the buttons.</p>

    </section>
    <!-- ========================= SECTION: PSD >> START ========================= -->



    <!-- ========================= SECTION: INSTALLATION >> START ========================= -->
    <section id="installation">
        <div class="page-header">
            <h1>Installation <small>How to Install the Template</small></h1>
        </div>

        <div class="row">
            <div class="span3">
                <h3>1. Install Theme</h3>
                <p>Here's a brief information about how to install your WordPress theme from scratch</p>
            </div>

            <div class="span9">
                <div class="accordion" id="accordion2">
                    <div class="accordion-group">
                        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne"> 1.1) Organize Your Files </a> </div>
                        <div id="collapseOne" class="accordion-body collapse">
                            <div class="accordion-inner">
                                <p>nim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo"> 1.2) Drag Your Files </a> </div>
                        <div id="collapseTwo" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="accordion-heading"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree"> 1.3) Click Activate </a> </div>
                        <div id="collapseThree" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
    <!-- ========================= SECTION: INSTALLATION >> END ========================= -->



    <!-- ========================= SECTION: ALERTS >> START ========================= -->
    <section id="alerts">
        <div class="page-header">
            <h1>Alerts <small>Twitter Bootstrap Alerts</small></h1>
        </div>
        <div class="alert"> <a class="close" data-dismiss="alert">×</a> <strong>Info!</strong> Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.. </div>
        <div class="alert alert-error"> <a class="close" data-dismiss="alert">×</a> <strong>Oh snap!</strong> Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.. </div>
        <div class="alert alert-success"> <a class="close" data-dismiss="alert">×</a> <strong>Well Done!</strong> Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.. </div>
        <div class="alert alert-info"> <a class="close" data-dismiss="alert">×</a> <strong>Heads Up!</strong> Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.. </div>
        <div class="alert alert-block">
            <a class="close" data-dismiss="alert">×</a>
            <h4 class="alert-heading">Warning!</h4>
            <p>Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur..</p>
        </div>

    </section>
    <!-- ========================= SECTION: ALERTS >> END ========================= -->

    <hr />

    <div class="goodbye">
        <p>Once again, thank you so much for purchasing this theme. As I said at the beginning, I'd be glad to help you if you have any questions relating to this theme. No guarantees, but I'll do my best to assist. If you have a more general question relating to the themes on ThemeForest, you might consider visiting the forums and asking your question in the "Item Discussion" section.</p>
    </div>

    <hr />

    <footer>
        <p>&copy; Company 2012</p>
    </footer>

    </div>
    <!-- ========================= MAIN CONTAINER >> END ========================= -->


    
    
        
            
            
        
        

            







            

            
            
            

        
        
            
        
    
    



    
    
        
            
            
        
        
            
            
            
                
                
                
            
            
            
                
            
            
            
                
            
        
        
            
        
    
    

    <!-- loading javascripts -->
    <script src="/scripts/jquery/jquery.js"></script>
    <script src="/scripts/bootstrap/bootstrap.min.js"></script>
    <script src="/scripts/prettify.js"></script>

    <!-- init javascripts -->
    <script src="/scripts/init.js"></script>

    </body>

</html><?php }} ?>
<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-13 15:47:45
         compiled from "/Users/shalom.s/Sites/CoreFramework/app/Templates/common/header.tpl" */ ?>
<?php if ($_valid && !is_callable('content_541419c946b2e0_51401752')) {function content_541419c946b2e0_51401752($_smarty_tpl) {?><div class="centralize">
    <div id="logo" class="logowrap lfloat">MyTrackingApp</div>
    <ul class="rfloat menu">
        <li>home</li>
        <li>plans</li>
        <li>contact</li>
        <li>about</li>
    </ul>
    <div class="clear"></div>
</div><?php }} ?>
<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-13 15:47:45
         compiled from "/Users/shalom.s/Sites/CoreFramework/app/Templates/common/footer.tpl" */ ?>
<?php if ($_valid && !is_callable('content_541419c9487e67_43366631')) {function content_541419c9487e67_43366631($_smarty_tpl) {?><div class="ftrText">
    This app is powered by WebApps
</div><?php }} ?>
<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-13 15:47:45
         compiled from "/Users/shalom.s/Sites/CoreFramework/app/Templates/demopages/navs.tpl" */ ?>
<?php if ($_valid && !is_callable('content_541419c94c8fd1_04538113')) {function content_541419c94c8fd1_04538113($_smarty_tpl) {?><div class="navbar navbar-fixed-top navbar-inverse">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
            <a class="brand" href="#overview">Core Framework</a>
            <div class="nav-collapse">
                <ul class="nav">
                    <?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['docVarsCom']->value['navs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value) {
$_smarty_tpl->tpl_vars['i']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
                        <li>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div><?php }} ?>
<?php /* Smarty version Smarty-3.1.19-dev, created on 2014-09-13 15:47:45
         compiled from "/Users/shalom.s/Sites/CoreFramework/app/Templates/demopages/introSection.tpl" */ ?>
<?php if ($_valid && !is_callable('content_541419c94fd521_14177832')) {function content_541419c94fd521_14177832($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/Users/shalom.s/Sites/CoreFramework/vendor/smarty/smarty/distribution/libs/plugins/modifier.replace.php';
?><section id="overview">

    <div class="hero-unit">
        <h1><?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['product']['name'];?>
 Documentation</h1>
        <p><?php echo $_smarty_tpl->tpl_vars['demo_home']->value['created_by_txt'];?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['author']['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['author']['name'];?>
</a></p>
        <p><?php echo $_smarty_tpl->tpl_vars['demo_home']->value['intro_para'];?>
</p>
        <br/>
        <p class="well well-small"><?php echo $_smarty_tpl->tpl_vars['demo_home']->value['intro_note'];?>
</p>
        
            
            
            
            
        

    </div>

    <hr>

    <div class="row-fluid">
        <div class="span3">
            <table width="100%">
                <tr>
                    <td>Author:</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['author']['name'];?>
</td>
                </tr>
                <tr>
                    <td>Contact:</td>
                    <td><a href="#nowhere"><?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['author']['email'];?>
</a></td>
                </tr>
            </table>
        </div>
        <div class="span3">
            <table width="100%">
                <tr>
                    <td>Author URL:</td>
                    <td><a href="<?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['author']['url'];?>
"><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['docVarsCom']->value['author']['url'],"http://",'');?>
</a></td>
                </tr>
                <tr>
                    <td>Item URL:</td>
                    <td><a href="<?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['product']['url'];?>
"><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['docVarsCom']->value['product']['url'],"http://",'');?>
</a></td>
                </tr>
            </table>
        </div>
        <div class="span3">
            <table width="100%">
                <tr>
                    <td>Core Version:</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['product']['current_ver'];?>
</td>
                </tr>
                <tr>
                    <td>Documentation Version</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['product']['doc_ver'];?>
</td>
                </tr>
            </table>
        </div>
        <div class="span3">
            <table width="100%">
                <tr>
                    <td>Product Created:</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['docVarsCom']->value['product']['created_on'];?>
</td>
                </tr>
                <tr>
                    <td>Modified:</td>
                    <td>------</td>
                </tr>
            </table>
        </div>
    </div>

    <hr>

</section><?php }} ?>
