<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('is_add_original_tags', 0);

define('_JEXEC', 1);
define('JPATH_BASE', dirname(__DIR__) . '/..');
define('DS', DIRECTORY_SEPARATOR);
require_once(JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once(JPATH_BASE . DS . 'includes' . DS . 'framework.php');

use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Factory;

// Instantiate the application.
$app = Factory::getApplication('site');

$credentials = array();
$credentials['username'] = "admin2";
$credentials['password'] = "secret";

//perform the login action
$error = $app->login($credentials);
$user = JFactory::getUser();

$th = new TagsHelper();
$result = $th->createTagsFromField(array("#new#test_hehe"));

echo '<pre>';
var_dump($result);
echo '</pre>';

$app->logout();
die();
