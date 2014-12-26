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
            Core Framework requires that you install bower, Composer &amp; Git before you install this framework. Bower is front-end content management system, and Composer is PHP Dependency Manager, and Git is a version control system. To install bower first ensure you have the Node Packaged Modules manager aka npm &amp; Git installed. If you are running Linux based systems you can use the following command to install npm, git &amp; composer phar.
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
        <p class="para">
            Once bower has installed successfully we can now go ahead with Core Framework installation. For more information on
            <a href="http://bower.io/" rel="nofollow">Bower</a> or <a href="https://getcomposer.org/doc/" rel="nofollow">Composer</a> you can check them out on there specific links.
        </p>',
    'subTitle2' => 'Installation',
    'subTitle2_pLink' => 'installation',
    'subBlock2' => '<p class="para">
            If all the required packages have been installed as mentioned above, then use the below command to install Core Framework -
        </p>
        <pre class="prettyprint">composer create-project core-framework/CoreFramework {path/to/desired/folder} {version}</pre>
        <p class="para">Ex:</p>
        <pre class="prettyprint">composer create-project core-framework/CoreFramework /var/www/CoreFramework "v1.2.4-alpha"</pre>
        <p class="para">
            Once the Core Framework and it dependencies have been downloaded successfully, move into directory where the framework is install and run the following command -
        </p>
        <pre class="prettyprint">src/Core/Scripts/Console install</pre>
        <p class="para">
            The above command will setup the default demoapp and then prompt you to setup your web application. You can choose to say yes and setup your web application or you can say no and set it up later using the following command -
        </p>
        <pre class="prettyprint">src/Core/Scripts/Console setupApp {yourAppName}</pre>
        <p class="para">
            For now lets ignore application setup and proceed with a "no". Once default web application (demoapp) OR your web application has been setup successfully. The Console cli prompts you with the command you can run to setup your virtual host. You can either use these commands to setup the virtual host or you could do this the way you choose and are comfortable with. If you have already setup your virtual host (or once you have done so) you can check if your domain resolves in the browser to show the Core Framework home page.
        </p>',
    'subTitle3' => 'Post Installation',
    'subTitle3_pLink' => 'post-installation',
    'subBlock3' => '<p class="para">
            Now if everything has been setup correctly and if you see your domain resolve, now you could go ahead and setup your own application. Open up your console and move into the root directory where Core Framework has been installed. Once there type <code>corecon</code>. If you get an error or if the command doesn&rsquo;t exist then this is likely because Core Framework&rsquo;s attempt at aliasing <code>src/Core/Scripts/Console</code> probably failed. You can easily remedy this by typing the following command in console - <code>alias corecon="src/Core/Scripts/Console"</code>**
        </p>
        <p class="para">
            **Path will change if you are not in Core Framework&rsquo;s Root
</p>
        <p class="para">
Now type in <code>corecon</code> again in your console, and this time you should get command options help displayed. The help displayed shows you the set of commands that can be used and what they do. Now go ahead set up your web application using the following command -
        </p>
        <pre class="prettyprint">corecon setupApp</pre>
        <p class="para">
This will run the setup process, and the cli will prompt you to enter your web applications domain name. Here you can either enter a full fledged valid domain name if this is for production, or you can simply enter the keyword of your choice.
        </p>
        <p class="well well-small">
            <strong>Note:</strong> The domain you enter essentially also becomes the folder name with the dots (".") replaced with dashes ("-"). Thus if your domain name you entered is <code>coreframework.in</code>, then your web application folder name will be <code>coreframework-in</code>
        </p>'
];