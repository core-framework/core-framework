<?php
// source: phar:///Users/shalom.s/Sites/apigen.phar/src/ApiGen/DI/config.neon 

/**
 * @property Nette\Application\Application $application
 * @property Nette\Caching\Storages\FileStorage $cacheStorage
 * @property Nette\DI\Container $container
 * @property Nette\Http\Request $httpRequest
 * @property Nette\Http\Response $httpResponse
 * @property Nette\Bridges\Framework\NetteAccessor $nette
 * @property Nette\Application\Routers\RouteList $router
 * @property Nette\Http\Session $session
 * @property Nette\Security\User $user
 */
class SystemContainer extends Nette\DI\Container
{

	protected $meta = array(
		'types' => array(
			'nette\\object' => array(
				'nette',
				'nette.cacheJournal',
				'cacheStorage',
				'nette.httpRequestFactory',
				'httpRequest',
				'httpResponse',
				'nette.httpContext',
				'session',
				'nette.userStorage',
				'user',
				'application',
				'nette.presenterFactory',
				'router',
				'nette.mailer',
				'nette.templateFactory',
				'apigen.configuration',
				'apigen.charsetConvertor',
				'apigen.generator',
				'apigen.elementResolver',
				'apigen.relativePathResolver',
				'apigen.scanner',
				'apigen.sourceCodeHighlighter',
				'apigen.console.progressBar',
				'apigen.memoryLimitChecker',
				'apigen.event.0',
				'apigen.event.1',
				'apigen.event.2',
				'apigen.event.3',
				'apigen.event.4',
				'apigen.templateFactory',
				'apigen.latte.filter.0',
				'apigen.latte.filter.1',
				'apigen.latte.filter.2',
				'apigen.latte.filter.3',
				'apigen.latte.filter.4',
				'apigen.latte.filter.5',
				'apigen.finder',
				'apigen.zip',
				'apigen.wiper',
				'container',
			),
			'nette\\bridges\\framework\\netteaccessor' => array('nette'),
			'nette\\caching\\storages\\ijournal' => array('nette.cacheJournal'),
			'nette\\caching\\storages\\filejournal' => array('nette.cacheJournal'),
			'nette\\caching\\istorage' => array('cacheStorage'),
			'nette\\caching\\storages\\filestorage' => array('cacheStorage'),
			'nette\\http\\requestfactory' => array('nette.httpRequestFactory'),
			'nette\\http\\irequest' => array('httpRequest'),
			'nette\\http\\request' => array('httpRequest'),
			'nette\\http\\iresponse' => array('httpResponse'),
			'nette\\http\\response' => array('httpResponse'),
			'nette\\http\\context' => array('nette.httpContext'),
			'nette\\http\\session' => array('session'),
			'nette\\security\\iuserstorage' => array('nette.userStorage'),
			'nette\\http\\userstorage' => array('nette.userStorage'),
			'nette\\security\\user' => array('user'),
			'nette\\application\\application' => array('application'),
			'nette\\application\\ipresenterfactory' => array('nette.presenterFactory'),
			'nette\\application\\presenterfactory' => array('nette.presenterFactory'),
			'nette\\utils\\arraylist' => array('router'),
			'traversable' => array('router', 'console.helperSet'),
			'iteratoraggregate' => array('router', 'console.helperSet'),
			'countable' => array('router'),
			'arrayaccess' => array('router'),
			'nette\\application\\irouter' => array('router'),
			'nette\\application\\routers\\routelist' => array('router'),
			'nette\\mail\\imailer' => array('nette.mailer'),
			'nette\\mail\\sendmailmailer' => array('nette.mailer'),
			'nette\\bridges\\applicationlatte\\ilattefactory' => array('nette.latteFactory'),
			'nette\\application\\ui\\itemplatefactory' => array('nette.templateFactory'),
			'nette\\bridges\\applicationlatte\\templatefactory' => array('nette.templateFactory'),
			'apigen\\configuration\\configuration' => array('apigen.configuration'),
			'apigen\\charset\\charsetconvertor' => array('apigen.charsetConvertor'),
			'apigen\\generator\\generator' => array('apigen.generator'),
			'apigen\\generator\\htmlgenerator' => array('apigen.generator'),
			'apigen\\generator\\resolvers\\elementresolver' => array('apigen.elementResolver'),
			'apigen\\generator\\resolvers\\relativepathresolver' => array('apigen.relativePathResolver'),
			'apigen\\generator\\scanner' => array('apigen.scanner'),
			'apigen\\generator\\phpscanner' => array('apigen.scanner'),
			'fshl\\output' => array('apigen.fshl.output'),
			'fshl\\output\\html' => array('apigen.fshl.output'),
			'fshl\\lexer' => array('apigen.fshl.lexter'),
			'fshl\\lexer\\php' => array('apigen.fshl.lexter'),
			'fshl\\highlighter' => array('apigen.fshl.highlighter'),
			'apigen\\generator\\sourcecodehighlighter' => array('apigen.sourceCodeHighlighter'),
			'apigen\\generator\\fshlsourcecodehighlighter' => array('apigen.sourceCodeHighlighter'),
			'michelf\\_markdownextra_tmpimpl' => array('apigen.markdown'),
			'michelf\\markdown' => array('apigen.markdown'),
			'michelf\\markdowninterface' => array('apigen.markdown'),
			'michelf\\markdownextra' => array('apigen.markdown'),
			'apigen\\generator\\markups\\markup' => array('apigen.markdownMarkup'),
			'apigen\\generator\\markups\\markdownmarkup' => array('apigen.markdownMarkup'),
			'kdyby\\console\\application' => array(
				'apigen.application',
				'console.application',
			),
			'symfony\\component\\console\\application' => array(
				'apigen.application',
				'console.application',
			),
			'apigen\\console\\application' => array('apigen.application'),
			'symfony\\component\\console\\command\\command' => array('apigen.command.0', 'apigen.command.1'),
			'apigen\\command\\generatecommand' => array('apigen.command.0'),
			'apigen\\command\\selfupdatecommand' => array('apigen.command.1'),
			'apigen\\console\\progressbar' => array('apigen.console.progressBar'),
			'apigen\\metrics\\memorylimitchecker' => array('apigen.memoryLimitChecker'),
			'apigen\\metrics\\simplememorylimitchecker' => array('apigen.memoryLimitChecker'),
			'kdyby\\events\\subscriber' => array(
				'apigen.event.0',
				'apigen.event.1',
				'apigen.event.2',
				'apigen.event.3',
				'apigen.event.4',
			),
			'doctrine\\common\\eventsubscriber' => array(
				'apigen.event.0',
				'apigen.event.1',
				'apigen.event.2',
				'apigen.event.3',
				'apigen.event.4',
			),
			'apigen\\events\\progressbarincrement' => array('apigen.event.0'),
			'apigen\\events\\memorylimitcheckeronprogress' => array('apigen.event.1'),
			'apigen\\events\\loadelementresolver' => array('apigen.event.2'),
			'apigen\\events\\loadrelativepathresolver' => array('apigen.event.3'),
			'apigen\\events\\injectconfig' => array('apigen.event.4'),
			'apigen\\templating\\templatefactory' => array('apigen.templateFactory'),
			'latte\\object' => array('apigen.latteFactory'),
			'latte\\engine' => array('apigen.latteFactory'),
			'apigen\\templating\\filters\\filters' => array(
				'apigen.latte.filter.0',
				'apigen.latte.filter.1',
				'apigen.latte.filter.2',
				'apigen.latte.filter.3',
				'apigen.latte.filter.4',
				'apigen.latte.filter.5',
			),
			'apigen\\templating\\filters\\annotationfilters' => array('apigen.latte.filter.0'),
			'apigen\\templating\\filters\\pathfilters' => array('apigen.latte.filter.1'),
			'apigen\\templating\\filters\\phpmanualfilters' => array('apigen.latte.filter.2'),
			'apigen\\templating\\filters\\resolverfilters' => array('apigen.latte.filter.3'),
			'apigen\\templating\\filters\\sourcefilters' => array('apigen.latte.filter.4'),
			'apigen\\templating\\filters\\urlfilters' => array('apigen.latte.filter.5'),
			'apigen\\filesystem\\finder' => array('apigen.finder'),
			'apigen\\filesystem\\zip' => array('apigen.zip'),
			'apigen\\filesystem\\wiper' => array('apigen.wiper'),
			'kdyby\\events\\eventmanager' => array('events.manager'),
			'doctrine\\common\\eventmanager' => array('events.manager'),
			'kdyby\\events\\lazyeventmanager' => array('events.manager'),
			'symfony\\component\\console\\helper\\helperset' => array('console.helperSet'),
			'symfony\\component\\console\\helper\\helper' => array('console.dicHelper'),
			'symfony\\component\\console\\helper\\helperinterface' => array('console.dicHelper'),
			'kdyby\\console\\containerhelper' => array('console.dicHelper'),
			'nette\\di\\container' => array('container'),
		),
		'tags' => array(
			'kdyby.subscriber' => array(
				'apigen.event.0' => TRUE,
				'apigen.event.1' => TRUE,
				'apigen.event.2' => TRUE,
				'apigen.event.3' => TRUE,
				'apigen.event.4' => TRUE,
			),
			'kdyby.console.helper' => array('console.dicHelper' => 'dic'),
		),
	);


	public function __construct()
	{
		parent::__construct(array(
			'appDir' => 'phar:///Users/shalom.s/Sites/apigen.phar/src',
			'wwwDir' => '/Users/shalom.s/Sites',
			'debugMode' => FALSE,
			'productionMode' => TRUE,
			'environment' => 'production',
			'consoleMode' => TRUE,
			'container' => array(
				'class' => 'SystemContainer',
				'parent' => 'Nette\\DI\\Container',
				'accessors' => TRUE,
			),
			'tempDir' => '/Users/shalom.s/Sites/CoreFramework/_apigen.temp',
		));
	}


	/**
	 * @return ApiGen\Console\Application
	 */
	public function createServiceApigen__application()
	{
		$service = new ApiGen\Console\Application;
		$service->injectServiceLocator($this);
		$service->add($this->getService('apigen.command.0'));
		$service->add($this->getService('apigen.command.1'));
		return $service;
	}


	/**
	 * @return ApiGen\Charset\CharsetConvertor
	 */
	public function createServiceApigen__charsetConvertor()
	{
		$service = new ApiGen\Charset\CharsetConvertor;
		return $service;
	}


	/**
	 * @return ApiGen\Command\GenerateCommand
	 */
	public function createServiceApigen__command__0()
	{
		$service = new ApiGen\Command\GenerateCommand($this->getService('apigen.generator'), $this->getService('apigen.wiper'), $this->getService('apigen.configuration'));
		return $service;
	}


	/**
	 * @return ApiGen\Command\SelfUpdateCommand
	 */
	public function createServiceApigen__command__1()
	{
		$service = new ApiGen\Command\SelfUpdateCommand;
		return $service;
	}


	/**
	 * @return ApiGen\Configuration\Configuration
	 */
	public function createServiceApigen__configuration()
	{
		$service = new ApiGen\Configuration\Configuration;
		$service->onSuccessValidate = $this->getService('events.manager')->createEvent(array(
			'ApiGen\\Configuration\\Configuration',
			'onSuccessValidate',
		), $service->onSuccessValidate);
		return $service;
	}


	/**
	 * @return ApiGen\Console\ProgressBar
	 */
	public function createServiceApigen__console__progressBar()
	{
		$service = new ApiGen\Console\ProgressBar;
		return $service;
	}


	/**
	 * @return ApiGen\Generator\Resolvers\ElementResolver
	 */
	public function createServiceApigen__elementResolver()
	{
		$service = new ApiGen\Generator\Resolvers\ElementResolver;
		return $service;
	}


	/**
	 * @return ApiGen\Events\ProgressBarIncrement
	 */
	public function createServiceApigen__event__0()
	{
		$service = new ApiGen\Events\ProgressBarIncrement($this->getService('apigen.console.progressBar'));
		return $service;
	}


	/**
	 * @return ApiGen\Events\MemoryLimitCheckerOnProgress
	 */
	public function createServiceApigen__event__1()
	{
		$service = new ApiGen\Events\MemoryLimitCheckerOnProgress($this->getService('apigen.memoryLimitChecker'));
		return $service;
	}


	/**
	 * @return ApiGen\Events\LoadElementResolver
	 */
	public function createServiceApigen__event__2()
	{
		$service = new ApiGen\Events\LoadElementResolver($this->getService('apigen.elementResolver'));
		return $service;
	}


	/**
	 * @return ApiGen\Events\LoadRelativePathResolver
	 */
	public function createServiceApigen__event__3()
	{
		$service = new ApiGen\Events\LoadRelativePathResolver($this->getService('apigen.relativePathResolver'));
		return $service;
	}


	/**
	 * @return ApiGen\Events\InjectConfig
	 */
	public function createServiceApigen__event__4()
	{
		$service = new ApiGen\Events\InjectConfig($this->getService('apigen.generator'), $this->getService('apigen.templateFactory'), $this->getService('apigen.charsetConvertor'), $this->getService('apigen.latte.filter.4'), $this->getService('apigen.latte.filter.5'), $this->getService('apigen.finder'), $this->getService('apigen.zip'), $this->getService('apigen.latte.filter.0'), $this->getService('apigen.relativePathResolver'));
		return $service;
	}


	/**
	 * @return ApiGen\FileSystem\Finder
	 */
	public function createServiceApigen__finder()
	{
		$service = new ApiGen\FileSystem\Finder;
		return $service;
	}


	/**
	 * @return FSHL\Highlighter
	 */
	public function createServiceApigen__fshl__highlighter()
	{
		$service = new FSHL\Highlighter($this->getService('apigen.fshl.output'));
		$service->setLexer($this->getService('apigen.fshl.lexter'));
		return $service;
	}


	/**
	 * @return FSHL\Lexer\Php
	 */
	public function createServiceApigen__fshl__lexter()
	{
		$service = new FSHL\Lexer\Php;
		return $service;
	}


	/**
	 * @return FSHL\Output\Html
	 */
	public function createServiceApigen__fshl__output()
	{
		$service = new FSHL\Output\Html;
		return $service;
	}


	/**
	 * @return ApiGen\Generator\HtmlGenerator
	 */
	public function createServiceApigen__generator()
	{
		$service = new ApiGen\Generator\HtmlGenerator($this->getService('apigen.charsetConvertor'), $this->getService('apigen.scanner'), $this->getService('apigen.zip'), $this->getService('apigen.sourceCodeHighlighter'), $this->getService('apigen.templateFactory'), $this->getService('apigen.relativePathResolver'), $this->getService('apigen.finder'), $this->getService('apigen.elementResolver'));
		$service->onScanFinish = $this->getService('events.manager')->createEvent(array(
			'ApiGen\\Generator\\HtmlGenerator',
			'onScanFinish',
		), $service->onScanFinish);
		$service->onParseStart = $this->getService('events.manager')->createEvent(array(
			'ApiGen\\Generator\\HtmlGenerator',
			'onParseStart',
		), $service->onParseStart);
		$service->onParseProgress = $this->getService('events.manager')->createEvent(array(
			'ApiGen\\Generator\\HtmlGenerator',
			'onParseProgress',
		), $service->onParseProgress);
		$service->onParseFinish = $this->getService('events.manager')->createEvent(array(
			'ApiGen\\Generator\\HtmlGenerator',
			'onParseFinish',
		), $service->onParseFinish);
		$service->onGenerateStart = $this->getService('events.manager')->createEvent(array(
			'ApiGen\\Generator\\HtmlGenerator',
			'onGenerateStart',
		), $service->onGenerateStart);
		$service->onGenerateProgress = $this->getService('events.manager')->createEvent(array(
			'ApiGen\\Generator\\HtmlGenerator',
			'onGenerateProgress',
		), $service->onGenerateProgress);
		return $service;
	}


	/**
	 * @return ApiGen\Templating\Filters\AnnotationFilters
	 */
	public function createServiceApigen__latte__filter__0()
	{
		$service = new ApiGen\Templating\Filters\AnnotationFilters($this->getService('apigen.elementResolver'));
		return $service;
	}


	/**
	 * @return ApiGen\Templating\Filters\PathFilters
	 */
	public function createServiceApigen__latte__filter__1()
	{
		$service = new ApiGen\Templating\Filters\PathFilters($this->getService('apigen.relativePathResolver'));
		return $service;
	}


	/**
	 * @return ApiGen\Templating\Filters\PhpManualFilters
	 */
	public function createServiceApigen__latte__filter__2()
	{
		$service = new ApiGen\Templating\Filters\PhpManualFilters;
		return $service;
	}


	/**
	 * @return ApiGen\Templating\Filters\ResolverFilters
	 */
	public function createServiceApigen__latte__filter__3()
	{
		$service = new ApiGen\Templating\Filters\ResolverFilters($this->getService('apigen.elementResolver'));
		return $service;
	}


	/**
	 * @return ApiGen\Templating\Filters\SourceFilters
	 */
	public function createServiceApigen__latte__filter__4()
	{
		$service = new ApiGen\Templating\Filters\SourceFilters;
		return $service;
	}


	/**
	 * @return ApiGen\Templating\Filters\UrlFilters
	 */
	public function createServiceApigen__latte__filter__5()
	{
		$service = new ApiGen\Templating\Filters\UrlFilters($this->getService('apigen.sourceCodeHighlighter'), $this->getService('apigen.markdownMarkup'), $this->getService('apigen.elementResolver'));
		return $service;
	}


	/**
	 * @return Latte\Engine
	 */
	public function createServiceApigen__latteFactory()
	{
		$service = new Latte\Engine;
		$service->setTempDirectory('/Users/shalom.s/Sites/CoreFramework/_apigen.temp/cache/latte');
		$service->addFilter(NULL, array(
			$this->getService('apigen.latte.filter.0'),
			'loader',
		));
		$service->addFilter(NULL, array(
			$this->getService('apigen.latte.filter.1'),
			'loader',
		));
		$service->addFilter(NULL, array(
			$this->getService('apigen.latte.filter.2'),
			'loader',
		));
		$service->addFilter(NULL, array(
			$this->getService('apigen.latte.filter.3'),
			'loader',
		));
		$service->addFilter(NULL, array(
			$this->getService('apigen.latte.filter.4'),
			'loader',
		));
		$service->addFilter(NULL, array(
			$this->getService('apigen.latte.filter.5'),
			'loader',
		));
		$service->onCompile = $this->getService('events.manager')->createEvent(array('Latte\\Engine', 'onCompile'), $service->onCompile);
		return $service;
	}


	/**
	 * @return Michelf\MarkdownExtra
	 */
	public function createServiceApigen__markdown()
	{
		$service = new Michelf\MarkdownExtra;
		return $service;
	}


	/**
	 * @return ApiGen\Generator\Markups\MarkdownMarkup
	 */
	public function createServiceApigen__markdownMarkup()
	{
		$service = new ApiGen\Generator\Markups\MarkdownMarkup($this->getService('apigen.markdown'), $this->getService('apigen.sourceCodeHighlighter'));
		return $service;
	}


	/**
	 * @return ApiGen\Metrics\SimpleMemoryLimitChecker
	 */
	public function createServiceApigen__memoryLimitChecker()
	{
		$service = new ApiGen\Metrics\SimpleMemoryLimitChecker;
		return $service;
	}


	/**
	 * @return ApiGen\Generator\Resolvers\RelativePathResolver
	 */
	public function createServiceApigen__relativePathResolver()
	{
		$service = new ApiGen\Generator\Resolvers\RelativePathResolver;
		return $service;
	}


	/**
	 * @return ApiGen\Generator\PhpScanner
	 */
	public function createServiceApigen__scanner()
	{
		$service = new ApiGen\Generator\PhpScanner;
		return $service;
	}


	/**
	 * @return ApiGen\Generator\FshlSourceCodeHighlighter
	 */
	public function createServiceApigen__sourceCodeHighlighter()
	{
		$service = new ApiGen\Generator\FshlSourceCodeHighlighter($this->getService('apigen.fshl.highlighter'));
		return $service;
	}


	/**
	 * @return ApiGen\Templating\TemplateFactory
	 */
	public function createServiceApigen__templateFactory()
	{
		$service = new ApiGen\Templating\TemplateFactory($this->getService('apigen.latteFactory'), $this->getService('apigen.configuration'));
		return $service;
	}


	/**
	 * @return ApiGen\FileSystem\Wiper
	 */
	public function createServiceApigen__wiper()
	{
		$service = new ApiGen\FileSystem\Wiper($this->getService('apigen.finder'), $this->getService('apigen.zip'));
		return $service;
	}


	/**
	 * @return ApiGen\FileSystem\Zip
	 */
	public function createServiceApigen__zip()
	{
		$service = new ApiGen\FileSystem\Zip($this->getService('apigen.finder'));
		return $service;
	}


	/**
	 * @return Nette\Application\Application
	 */
	public function createServiceApplication()
	{
		$service = new Nette\Application\Application($this->getService('nette.presenterFactory'), $this->getService('router'), $this->getService('httpRequest'), $this->getService('httpResponse'));
		$service->catchExceptions = TRUE;
		$service->errorPresenter = 'Nette:Error';
		Nette\Bridges\ApplicationTracy\RoutingPanel::initializePanel($service);
		$self = $this; $service->onError[] = function ($app, $e) use ($self) {
			$app->errorPresenter = FALSE;
			$app->onShutdown[] = function () { exit(254); };
			$self->getService('console.application')->handleException($e);
		};
		$service->onStartup = $this->getService('events.manager')->createEvent(array(
			'Nette\\Application\\Application',
			'onStartup',
		), $service->onStartup);
		$service->onShutdown = $this->getService('events.manager')->createEvent(array(
			'Nette\\Application\\Application',
			'onShutdown',
		), $service->onShutdown);
		$service->onRequest = $this->getService('events.manager')->createEvent(array(
			'Nette\\Application\\Application',
			'onRequest',
		), $service->onRequest);
		$service->onPresenter = $this->getService('events.manager')->createEvent(array(
			'Nette\\Application\\Application',
			'onPresenter',
		), $service->onPresenter);
		$service->onResponse = $this->getService('events.manager')->createEvent(array(
			'Nette\\Application\\Application',
			'onResponse',
		), $service->onResponse);
		$service->onError = $this->getService('events.manager')->createEvent(array(
			'Nette\\Application\\Application',
			'onError',
		), $service->onError);
		return $service;
	}


	/**
	 * @return Nette\Caching\Storages\FileStorage
	 */
	public function createServiceCacheStorage()
	{
		$service = new Nette\Caching\Storages\FileStorage('/Users/shalom.s/Sites/CoreFramework/_apigen.temp/cache', $this->getService('nette.cacheJournal'));
		return $service;
	}


	/**
	 * @return Kdyby\Console\Application
	 */
	public function createServiceConsole__application()
	{
		$service = new Kdyby\Console\Application('Nette Framework', 'unknown');
		$service->setHelperSet($this->getService('console.helperSet'));
		$service->injectServiceLocator($this);
		return $service;
	}


	/**
	 * @return Kdyby\Console\ContainerHelper
	 */
	public function createServiceConsole__dicHelper()
	{
		$service = new Kdyby\Console\ContainerHelper($this);
		return $service;
	}


	/**
	 * @return Symfony\Component\Console\Helper\HelperSet
	 */
	public function createServiceConsole__helperSet()
	{
		$service = new Symfony\Component\Console\Helper\HelperSet(array(
			new Symfony\Component\Console\Helper\DialogHelper,
			new Symfony\Component\Console\Helper\FormatterHelper,
			new Symfony\Component\Console\Helper\QuestionHelper,
			new Kdyby\Console\Helpers\PresenterHelper($this->getService('application')),
			new Symfony\Component\Console\Helper\ProgressHelper,
		));
		$service->set($this->getService('console.dicHelper'), 'dic');
		return $service;
	}


	/**
	 * @return Kdyby\Console\CliRouter
	 */
	public function createServiceConsole__router()
	{
		$service = new Kdyby\Console\CliRouter($this);
		return $service;
	}


	/**
	 * @return Nette\DI\Container
	 */
	public function createServiceContainer()
	{
		return $this;
	}


	/**
	 * @return Kdyby\Events\LazyEventManager
	 */
	public function createServiceEvents__manager()
	{
		$service = new Kdyby\Events\LazyEventManager(array(
			'ApiGen\\Generator\\HtmlGenerator::onParseStart' => array('apigen.event.0'),
			'onParseStart' => array('apigen.event.0'),
			'ApiGen\\Generator\\HtmlGenerator::onParseProgress' => array('apigen.event.0', 'apigen.event.1'),
			'onParseProgress' => array('apigen.event.0', 'apigen.event.1'),
			'ApiGen\\Generator\\HtmlGenerator::onGenerateStart' => array('apigen.event.0'),
			'onGenerateStart' => array('apigen.event.0'),
			'ApiGen\\Generator\\HtmlGenerator::onGenerateProgress' => array('apigen.event.0', 'apigen.event.1'),
			'onGenerateProgress' => array('apigen.event.0', 'apigen.event.1'),
			'ApiGen\\Generator\\HtmlGenerator::onParseFinish' => array('apigen.event.2'),
			'onParseFinish' => array('apigen.event.2'),
			'ApiGen\\Generator\\HtmlGenerator::onScanFinish' => array('apigen.event.3'),
			'onScanFinish' => array('apigen.event.3'),
			'ApiGen\\Configuration\\Configuration::onSuccessValidate' => array('apigen.event.4'),
			'onSuccessValidate' => array('apigen.event.4'),
		), $this);
		Kdyby\Events\Diagnostics\Panel::register($service, $this)->renderPanel = FALSE;
		return $service;
	}


	/**
	 * @return Nette\Http\Request
	 */
	public function createServiceHttpRequest()
	{
		$service = $this->getService('nette.httpRequestFactory')->createHttpRequest();
		if (!$service instanceof Nette\Http\Request) {
			throw new Nette\UnexpectedValueException('Unable to create service \'httpRequest\', value returned by factory is not Nette\\Http\\Request type.');
		}
		return $service;
	}


	/**
	 * @return Nette\Http\Response
	 */
	public function createServiceHttpResponse()
	{
		$service = new Nette\Http\Response;
		return $service;
	}


	/**
	 * @return Nette\Bridges\Framework\NetteAccessor
	 */
	public function createServiceNette()
	{
		$service = new Nette\Bridges\Framework\NetteAccessor($this);
		return $service;
	}


	/**
	 * @return Nette\Caching\Cache
	 */
	public function createServiceNette__cache($namespace = NULL)
	{
		$service = new Nette\Caching\Cache($this->getService('cacheStorage'), $namespace);
		trigger_error('Service cache is deprecated.', 16384);
		return $service;
	}


	/**
	 * @return Nette\Caching\Storages\FileJournal
	 */
	public function createServiceNette__cacheJournal()
	{
		$service = new Nette\Caching\Storages\FileJournal('/Users/shalom.s/Sites/CoreFramework/_apigen.temp');
		return $service;
	}


	/**
	 * @return Nette\Http\Context
	 */
	public function createServiceNette__httpContext()
	{
		$service = new Nette\Http\Context($this->getService('httpRequest'), $this->getService('httpResponse'));
		return $service;
	}


	/**
	 * @return Nette\Http\RequestFactory
	 */
	public function createServiceNette__httpRequestFactory()
	{
		$service = new Nette\Http\RequestFactory;
		$service->setProxy(array());
		return $service;
	}


	/**
	 * @return Latte\Engine
	 */
	public function createServiceNette__latte()
	{
		$service = new Latte\Engine;
		$service->setTempDirectory('/Users/shalom.s/Sites/CoreFramework/_apigen.temp/cache/latte');
		$service->setAutoRefresh(FALSE);
		$service->setContentType('html');
		$service->onCompile = $this->getService('events.manager')->createEvent(array('Latte\\Engine', 'onCompile'), $service->onCompile);
		return $service;
	}


	/**
	 * @return Nette\Bridges\ApplicationLatte\ILatteFactory
	 */
	public function createServiceNette__latteFactory()
	{
		return new SystemContainer_Nette_Bridges_ApplicationLatte_ILatteFactoryImpl_nette_latteFactory($this);
	}


	/**
	 * @return Nette\Mail\SendmailMailer
	 */
	public function createServiceNette__mailer()
	{
		$service = new Nette\Mail\SendmailMailer;
		return $service;
	}


	/**
	 * @return Nette\Application\PresenterFactory
	 */
	public function createServiceNette__presenterFactory()
	{
		$service = new Nette\Application\PresenterFactory('phar:///Users/shalom.s/Sites/apigen.phar/src', $this);
		if (method_exists($service, 'setMapping')) { $service->setMapping(array('Kdyby' => 'KdybyModule\\*\\*Presenter')); } elseif (property_exists($service, 'mapping')) { $service->mapping['Kdyby'] = 'KdybyModule\\*\\*Presenter'; };
		return $service;
	}


	/**
	 * @return Nette\Bridges\ApplicationLatte\TemplateFactory
	 */
	public function createServiceNette__templateFactory()
	{
		$service = new Nette\Bridges\ApplicationLatte\TemplateFactory($this->getService('nette.latteFactory'), $this->getService('httpRequest'), $this->getService('httpResponse'), $this->getService('user'), $this->getService('cacheStorage'));
		return $service;
	}


	/**
	 * @return Nette\Http\UserStorage
	 */
	public function createServiceNette__userStorage()
	{
		$service = new Nette\Http\UserStorage($this->getService('session'));
		return $service;
	}


	/**
	 * @return Nette\Application\Routers\RouteList
	 */
	public function createServiceRouter()
	{
		$service = new Nette\Application\Routers\RouteList;
		Kdyby\Console\CliRouter::prependTo($service, $this->getService('console.router'));
		return $service;
	}


	/**
	 * @return Nette\Http\Session
	 */
	public function createServiceSession()
	{
		$service = new Nette\Http\Session($this->getService('httpRequest'), $this->getService('httpResponse'));
		return $service;
	}


	/**
	 * @return Nette\Security\User
	 */
	public function createServiceUser()
	{
		$service = new Nette\Security\User($this->getService('nette.userStorage'));
		$service->onLoggedIn = $this->getService('events.manager')->createEvent(array('Nette\\Security\\User', 'onLoggedIn'), $service->onLoggedIn);
		$service->onLoggedOut = $this->getService('events.manager')->createEvent(array('Nette\\Security\\User', 'onLoggedOut'), $service->onLoggedOut);
		return $service;
	}


	public function initialize()
	{
		Nette\Bridges\Framework\TracyBridge::initialize();
		Nette\Caching\Storages\FileStorage::$useDirectories = TRUE;
		$this->getByType("Nette\Http\Session")->exists() && $this->getByType("Nette\Http\Session")->start();
		$this->getService('events.manager')->createEvent(array('Nette\\DI\\Container', 'onInitialize'))->dispatch($this);
		header('X-Frame-Options: SAMEORIGIN');
		header('X-Powered-By: Nette Framework');
		header('Content-Type: text/html; charset=utf-8');
		Nette\Utils\SafeStream::register();
		Nette\Reflection\AnnotationsParser::setCacheStorage($this->getByType("Nette\Caching\IStorage"));
		Nette\Reflection\AnnotationsParser::$autoRefresh = FALSE;;
	}

}



final class SystemContainer_Nette_Bridges_ApplicationLatte_ILatteFactoryImpl_nette_latteFactory implements Nette\Bridges\ApplicationLatte\ILatteFactory
{

	private $container;


	public function __construct(Nette\DI\Container $container)
	{
		$this->container = $container;
	}


	public function create()
	{
		$service = new Latte\Engine;
		$service->setTempDirectory('/Users/shalom.s/Sites/CoreFramework/_apigen.temp/cache/latte');
		$service->setAutoRefresh(FALSE);
		$service->setContentType('html');
		$service->onCompile = $this->container->getService('events.manager')->createEvent(array('Latte\\Engine', 'onCompile'), $service->onCompile);
		return $service;
	}

}
