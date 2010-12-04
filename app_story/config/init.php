<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'base_url'		=> '/',
	'errors'			=> Kohana::$environment !== Kohana::PRODUCTION,
  'profile'			=> Kohana::$environment !== Kohana::PRODUCTION,
  'caching'			=> Kohana::$environment === Kohana::PRODUCTION,
	'index_file'	=> false,
);