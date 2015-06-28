<?php

return $view = [
    'mainHeading' => 'Models',
    'introPara' => '<strong>Models</strong> in Core Framework are data objects. The Model directly manages the application&apos;s data, logic (for data manupilation) and rules. A model stores data that is retrieved to the Controller and displayed in the View. Whenever there is a change to the data it is updated by the controller. In simpler terms the Model is tied to the data stored in the database, and is essentially a wrapper for that data. Thus, whenever data needs to be retrieved, manipulated or deleted this should always be done by a model. You must never place database connections within a controller. Controllers must only call upon the models to retreive or edit data on the database.',

    'subTitle1' => 'Database Configuration',
    'subTitle1_pLink' => 'db_config',
    'subPara1' => '<p class="para">
            Before you can use the models you need to make sure that your mysql database is set up and Core Framework has access to that database. In Core Framework the database access details are stored in the <code>{PROJECT_FOLDER}/web/config/db.conf.php</code> file. The contents of the file are shown below:
        </p>

        <pre class="prettyprint linenums">
$db = [
    &apos;pdoDriver&apos; => &apos;mysql&apos;,
    &apos;db&apos; => &apos;test&apos;,
    &apos;host&apos; => &apos;127.0.0.1&apos;,
    &apos;user&apos; => &apos;root&apos;,
    &apos;pass&apos; => &apos;somePassword&apos;
];

return $db;
</pre>

    <p class="para">
        The contents of this file can be edited directly with the correct values required for the models to make the database connection successfully. Alternatively you can let Core Framework make the changes for you by running the following command in your terminal (from the project root).
    </p>

    <pre class="prettyprint">
~$: src/Core/Scripts/Console setupDb
</pre>

    <p class="para">
        Core Framework will ask you a few questions and based on the answers provided will build the contents of <code>db.conf.php</code> file.
    </p>
    ',

    'subTitle2' => 'Creating Models',
    'subTitle2_pLink' => 'creating_models',
    'subPara2' => '
        <p class="para">
            In Core Framework all model classes must extend the <code>Model</code> class. All models must reside in the <code>{PROJECT_FOLDER}/web/Models/</code> directory and must be namespaced as <code>namespace web\Models;</code>. Also on top of the Model class file, below the namespace the <code>use Core\Models\Model;</code> must be used for the auto loader to be able to load the Model Classes correctly. Below is an example pseudo code of a Model Class.
        </p>

        <pre class="prettyprint linenums lang-php">
namespace web\Models;

use Core\Models\Model;

class User extends Model {
    protected static $tableName = &apos;user&apos;;
    protected static $primaryKey = &apos;userId&apos;;
    protected static $dbName = &apos;test&apos;;

    public $userId;
    public $property2;
    ...
    ...


    public function __construct(userData = [])
    {
        if (!empty($userData)) {
            self::configure($this, $userData);

            // Do some stuff
        }

        parent::__construct();
    }


    public function save()
    {
        // Do some stuff

        $this->unsetBeforeSave();
        return parent::save();
    }

    public function update()
    {
        // Do some stuff
        $this->unsetBeforeSave();
        return parent::update();
    }

    public function unsetBeforeSave()
    {
        // remove some stuff before save
    }
}
</pre>

    <p class="para">
        As seen above you must define the table name, primaryKey and database name as static properties in your Model Class. If not defined then default will be used. There is no restriction on the properties you can define. But every model must implement the abstract methods of the BaseModel. The <code>save()</code> method must be used to insert the current data row (contained within the Model object) into the database. Similarly the <code>update()</code> method must be used to update the current data row in the database. The <code>unsetBeforeSave()</code> method must be used unset non-required properties or to perform any other required common instruction across your models.
    </p>
    ',

    'subTitle3' => 'Using a Model',
    'subTitle3_pLink' => 'using_model',
    'subPara3' => '
        <p class="para">
            Before you can start using your model in a controller you must use the <code>use</code> syntax in php to import your Model Class into the current namespace. This essential for the auto loader to successfully include your Model in the Controller. An pseudo code example of using the above Model in a controller is shown below:
        </p>

        <pre class="prettyprint linenums lang-php">
namespace web\Controllers;

use web\Models\User;

class someController extends BaseController {

    public $someGlobalProperty;
    ...
    ...

    public function indexAction()
    {
        $userData = $this->POST;
        // Add user with given data
        $newUser = new User($userData);

        // Save user to database
        $newUser->save();
    }

    public function someAction()
    {
        // retrieve one user&apos;s data from database
        $user = new User();
        // $userObj = $user->getOneRow([&apos;parameterName&apos; => &apos;parameterValue&apos;]);
        $userObj = $user->getOneRow([&apos;userId&apos; => &apos;userId1220&apos;]);
        // to convert object to array
        $userArr = $userObj->toArray();

        // retrieve all user objects
        $allUsers = User::getAll();

    }

}
    </pre>
    <p class="para">
        As you can see the Model class provides with a non query base solution to access the data from the database. Should the need arise how ever to right your own queries you can use the <code>get()</code> method. The <code>get</code> method takes two parameters, the first being the query as a string.
        <br/>
        <strong>Note:</strong> The query must be written without actually passing the parameters in the query, similar to writing queries when using the PDO class. Parameters names must instead be passed in the query string prepended by a colon (:). The parameter values must be passed as an associative array with the key being the colon included parameter names. An example implementation is given below:
    </p>

    <pre class="prettyprint lang-php">
$userData = User::get(&apos;SELECT id, fname, email from userTable WHERE id = :id&apos;, array(&apos;:id&apos; => &apos;userId989&apos;));
</pre>

    <p class="para">
        A more extensive list of methods available in a Model class is present in the <a href="/documentation/api">API section</a>.
    </p>
    '
];