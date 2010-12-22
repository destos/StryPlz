<?php defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------

/**
 * Set the Kohana Environment based on server name
 */
Kohana::$environment = ($_SERVER['SERVER_NAME'] == 'stryplz.com') ? Kohana::PRODUCTION : Kohana::DEVELOPMENT;

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('America/Chicago');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8', 'english-us');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

//-- Configuration and initialization -----------------------------------------

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana_Config::instance()->attach(new Kohana_Config_File);

/**
 * Attach the environment specific configuration file reader
 */
Kohana_Config::instance()->attach(new Kohana_Config_File('config/environments/'.Kohana::$environment));


$apache_environment = strtolower(URL::title(@getenv('ENVIRONMENT')));

if (!empty($apache_environment)){

	Kohana_Config::instance()->attach(new Kohana_Config_File('config/environments/apache/'.$apache_environment));
	unset($apache_environment);
	
}

/**
 * Set the session save path.
 * @see  http://php.net/session-save-path
 */
#session_save_path(Kohana_Config::instance()->load('session')->save_path);

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(Kohana_Config::instance()->load('init')->as_array());

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(Kohana::config('modules')->as_array());

/**
 * Attach the JSON Config Driver
 */
#Kohana::$config->attach(new Config_JSON('config.json'));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
 
//sms or call route
Route::set('twilio-call', 'call(:<action>)')
	->defaults(array(
		'controller' => 'handle_call',
		'action'     => 'index',
	));
	
Route::set('twilio-sms', 'sms(:<action>)')
	->defaults(array(
		'controller' => 'handle_sms',
		'action'     => 'index',
	));

Route::set('story', 'story-(<id>)(<slug>)(/<extra>)', array('id' => '[\d]+', 'slug' => '[a-zA-Z0-9]+'))
	->defaults(array(
		'controller' => 'story',
		'action'     => 'single',
	));

Route::set('stories', 'stories(/page:<page>)', array('page' => '[\d]+'))
	->defaults(array(
		'controller' => 'story',
		'action'     => 'browse',
	));

Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'main',
		'action'     => 'index',
	));
/*

Route::set('sms', '<sms>')
	->defaults(array(
		'controller' => 'sms',
		'action'     => 'index',
	));
*/

/**
 * Execute the main request using PATH_INFO. If no URI source is specified,
 * the URI will be automatically detected.
 */
$request = Request::instance($_SERVER['PATH_INFO']);

try
{
	// Attempt to execute the response
	$request->execute();
}
catch (Exception $e) {
	if ( Kohana::$environment == Kohana::DEVELOPMENT ) {
		// Just re-throw the exception in development
		throw $e;
	}

	// Log the error
	Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));

	// Create a 404 response
	$request->status = 404;
	$request->response = View::factory('template')
	->set('title', '404')
	->set('content', View::factory('errors/404'));
	
}

if ($request->send_headers()->response) {
	// Get the total memory and execution time
	$total = array(
		'{memory_usage}' => number_format((memory_get_peak_usage() - KOHANA_START_MEMORY) / 1024, 2).'KB',
		'{execution_time}' => number_format(microtime(TRUE) - KOHANA_START_TIME, 5).' seconds');

	// Insert the totals into the response
	$request->response = str_replace(array_keys($total), $total, $request->response);
}


/**
 * Display the request response.
 */
echo $request->response;
