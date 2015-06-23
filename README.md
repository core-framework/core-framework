Core Framework
===============
---

**Core Framework** is a PHP web application framework, that makes build a web application simple and easy. CoreFramework is light weight PHP framework eliminating the complexity and overhead of most modern frameworks.

Pre-requisites
===============
---

To install **Core Framework** you must first ensure that you have installed [Bower](http://bower.io/), [Composer](https://getcomposer.org/) and git on your system. Bower is a front-end dependency management system, while Composer is a PHP dependency management system and Git is a version control tool. If you are running Linux based systems you can use the following command to install npm, git &amp; composer phar.

```$
apt-get install git npm composer
```

**OR**

```$
yum install git npm composer
```

Depending on the package manager you are using on your system.


Get Started
================
---

Once Bower, Composer and git are installed on your system, the CoreFramework code can be downloaded/installed using Composer as show below:

```$
composer create-project core-framework/CoreFramework {path to directory of your choice} "{version of your choice}"
```

**Example:**

```$
composer create-project core-framework/CoreFramework /var/www/CoreFramework "v3.0.0"
```

Once the project has been created, navigate to the folder and then type the below command to install/setup CoreFramework

```$
src/Core/Scripts/Console install
```

Depending on your privileges/permissions you have on your system you may be required to run the above command with `sudo`. If this is your first install, the script may ask you a series of questions to help setup the database. You could set your database at this point or just hit return to use the default settings and then change this later if required.

Once the above installation is complete you can simply start a local server using the below command

```$
php -S 127.0.0.8:8000 -t web/
```

And then navigate to http://localhost:8000 on your web browser of choice and voila!! You'll see a test app set up and ready. You can now go ahead and start building your web application.


For additional details and full documentation go to [http://coreframework.in](http://coreframework.in)