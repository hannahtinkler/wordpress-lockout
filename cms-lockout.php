<?php
/*
Plugin Name:  Wordpress Lockout
Plugin URI:
Description:  Allows the locking out of users from the CMS
Version:      1.0.0
Author:       Hannah Tinkler
License:      Restricted
*/

namespace WordpressLockout;

if (!defined('WPINC')) {
    die;
}

// Plugin Autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Grab the core plugin class
$core = new Core;

add_action('plugins_loaded', [$core, 'initialise']);
