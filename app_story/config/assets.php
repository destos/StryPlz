<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Don't know what all of this means? Check out the wiki on GitHub:
 * 
 * @see http://wiki.github.com/jonathangeiger/kohana-asset/configuration
 */
return array(
	
	/**
	 * Config for calls to asset::javascripts()
	 */
	'javascripts' => array
	(
		'hosts' => array(),
		'root' => DOCROOT,
		'prefix' => 'm/js/',
		'extension' => '.js',
		'cache' => (Kohana::$environment === Kohana::PRODUCTION) ? 'm/cache/javascript-min.js' : false,
		'compressor' => 'yui',
		'compressor_options' => NULL,
		'cache_bust' => (Kohana::$environment === Kohana::PRODUCTION),
	),
	
	/**
	 * Config for calls to asset::stylesheets()
	 */
	'stylesheets' => array
	(
		'hosts' => array(),
		'root' => DOCROOT,
		'prefix' => 'm/css/',
		'extension' => '.css',
		'cache' => (Kohana::$environment === Kohana::PRODUCTION) ? 'm/cache/stylesheet-min.css' : false,
		'compressor' => 'yui',
		'compressor_options' => NULL,
		'cache_bust' => (Kohana::$environment === Kohana::PRODUCTION),
	),
	
	/**
	 * Options for configuring YUI Compressor
	 * 
	 * @see http://wiki.github.com/jonathangeiger/kohana-asset/yui-compressor
	 */
	'yui' => array
	(
		'java' => 'java',
		'jar' => MODPATH.'asset/vendor/yui/yuicompressor-2.4.2.jar',
	)
);
