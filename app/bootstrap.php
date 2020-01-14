<?php
/**
* bootstrap.php - includes all necessary files.
*
* @package    TurtleMVC-Core
* @license    https://opensource.org/licenses/BSD-3-Clause
* @author     Micky Aarnoudse
* @copyright  2020 Micky Aarnoudse
*/

// Load config
require_once 'config/config.php';

// load helpers
require_once APPROOT . '/helpers/session_helper.php';
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/captcha.php';
require_once APPROOT . '/helpers/mailer.php';

// load composer autoload
require '../composer/vendor/autoload.php';

// load all classes in libs/ when they are instantiated
spl_autoload_register(function($className){
    require_once "libs/". $className .".php";
});