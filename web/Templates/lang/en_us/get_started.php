<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 21/10/14
 * Time: 10:41 AM
 */

return $page = [
    'sectionHeader' => 'Getting started guide',
    'subTitle1' => 'Prerequisites',
    'subTitle1_pLink' => 'prerequisites',
    'subBlock1' => '<p class="para">
            Core Framework has few system requirements:
            <ul class="">
                <li>PHP >= 5.4</li>
                <li>NPM (Node Package Manager) & Bower</li>
                <li>Composer</li>
            </ul>
            <strong>Npm</strong> is node.js&apos;s package manager and is basically needed to install bower, which is a front-end package manager. More information on Bower and how to install it can be found at <a href="http://bower.io" rel="nofollow">Bower.io</a>.
            <br/>
            <strong>Composer</strong> is a dependency manager for PHP. More details on composer and how to install it can be found at <a href="http://getcomposer.org" rel="nofollow">getComposer.org</a>.
            <br/><br/>
            On a linux system you can install these dependencies following the simple instructions below:
        </p>
        <pre class="prettyprint">
apt-get install git npm composer</pre>
        <p class="para">
            Or on other systems you can use the available package managers, like <a href="http://brew.sh/" rel="nofollow">HomeBrew</a> to install npm, git and composer.
        </p>
        <p class="para">
            Once npm is installed successfully. Use the below command to install Bower -
        </p>
    <pre class="prettyprint">
npm install bower -g</pre>
        ',
    'subTitle2' => 'Core Framework Installation',
    'subTitle2_pLink' => 'installation',
    'subBlock2' => '<p class="para">
            First, you need to download Core Framework. There are couple of ways to do this. But we&apos;ll use Composer for this example. If all the requirements have been met as mentioned above, then use the below command to install Core Framework -
        </p>
        <pre class="prettyprint">composer create-project core-framework&#47;core-framework {path/to/desired/folder} {version}</pre>
        <p class="para">Ex:</p>
        <pre class="prettyprint">composer create-project core-framework&#47;core-framework /var/www/CoreFramework "v3.0.0"</pre>
        <p class="para">
            Once the Core Framework and it dependencies have been downloaded successfully, move into directory where the framework is installed and run the following command -
        </p>
        <pre class="prettyprint">src&#47;Core&#47;Scripts&#47;Console install</pre>
        <div class="alert alert-warning">
            <strong>Note:</strong> The above command may require "sudo" privileges.
        </div>
        <p class="para">
            During installation the application may ask you a few question. You could choose to answer them or hit the return / enter key to skip and use the default settings.
            <br/><br/>
            At the end of the installation you&apos;ll be prompted to spawn a local hosted server using the below command -
        </p>
        <pre class="prettyprint">php -S 127.0.0.8:8000 -t web/</pre>
        <p class="para">
        Run this command as instructed and then, on your browser navigate to "http://127.0.0.8:8000" and Voila!!! You should see the home screen of the demo application! Now you are all set and can start building your awesome web application.
        </p>
        ',
    'subTitle3' => '',
    'subTitle3_pLink' => '',
    'subBlock3' => ''
];

// Bower is tied into Core Framework for its ease in front-end package management (this may be relaxed in later versions). Bower installs all front-end dependecies in to a folder "bower_components" within the project directory. Core Framework then symlinks these components in the appropriate resource directories (i.e. scripts and style folder) in the DocumentRoot folder (i.e. named "web" ).

// Composer allows you to define your application&apos;s dependencies on other application or libraries in a json file, and then on running a simple command <code>composer install</code> all these packages/dependencies and their dependencies (if any) are all installed into a folder (named "vendor" by default). These packages can then be autoloaded in your application by just including the composer&apos;s <code>autoload.php</code> file in your application.