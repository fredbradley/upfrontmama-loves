<?php
/*
Plugin Name: Upfront Mama Upfront Mama Loves
Description: A Upfront Mama Loves Custom Must Have Item for Nicola
Author: Fred Bradley
Version: 1.2
Author URI: http://fred.im/
*/
namespace UpfrontMama\Loves;

require_once 'vendor/autoload.php';

new Plugin();


$myUpdateChecker = \Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/fredbradley/upfrontmama-loves/',
	__FILE__,
	'upfrontmama-loves'
);
