<section id="overview" class="row">
    <h2 class="sectionHeader"><{$get_started.sectionHeader}></h2>
    <h3 class="subTitle">
        <{$get_started.subtitle1}>
        <a class="permalink" href="#<{$get_started.subTitle1_pLink}>"></a>
    </h3>
    <div class="block">
        <p class="para">
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
        </p>
    </div>
    <h3 class="subTitle">
        Installation
        <a class="permalink" href="#installation"></a>
    </h3>
    <div class="block">
       git  <p class="para">
            If all the required packages have been installed as mentioned above, then use the below command to install Core Framework -
        </p>
        <pre class="prettyprint">composer create-project shalomsam/core {path/to/desired/folder} {version}</pre>
        <p class="para">Ex:</p>
        <pre class="prettyprint">composer create-project shalomsam/core /var/www/CoreFramework "v1.2.4-alpha"</pre>
    </div>
</section>