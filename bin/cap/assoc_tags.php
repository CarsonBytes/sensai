<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('_JEXEC', 1);
define('JPATH_BASE', dirname(__DIR__) . '/..');
define('DS', DIRECTORY_SEPARATOR);
require_once(JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once(JPATH_BASE . DS . 'includes' . DS . 'framework.php');

use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Factory;

// Instantiate the application.
$app = Factory::getApplication('site');

// Execute the application.
$app->initialise();


$th = new TagsHelper();
$currentTags = $th->getTagIds("75", "com_content.article"); // insert your item here

$table = Table::getInstance('Content');
$table->load(76);
$table->newTags = explode(',', $currentTags);
$table->newTags[] = "10";
$table->newTags[] = "11";
$table->newTags[] = "12";
$table->newTags[] = "13";
/* 
$table->check();
 */
$table->store();
//$table->save(array('id' => 75));


$result = $th->getItemTags("com_content.article", 76);

echo '<pre>';
//var_dump('done');
var_dump($result);
echo '</pre>';
