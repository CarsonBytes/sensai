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
use Joomla\CMS\Table\Table;
use Joomla\CMS\Factory;

// Instantiate the application.
$app = Factory::getApplication('site');

// Execute the application.
$app->initialise();

$filename = "000-01 publish records and web relationship - csv to import.csv";
if (file_exists(dirname(__FILE__) . DS . $filename)) {

    $file = fopen($filename, "r");
    $i = 0;
    $line = array();
    $tag_index;
    $alias_index;
    $db = JFactory::getDBO();
    $th = new TagsHelper();
    $contentTable = Table::getInstance('Content');

    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        if ($i == 0) {
            $alias_index = array_search('alias', $line[$i]);
            $tag_index = array_search('tags', $line[$i]);
            $cat_index = array_search('category', $line[$i]);
        }
        if ($i > 0) {
            echo $line[$i][$alias_index] . '<br />';
            echo $line[$i][$tag_index] . '<br />';
            echo $line[$i][$cat_index] . '<br />';

            $tags = "'" . str_replace(',', "','", $line[$i][$tag_index]) . "'";
            $query = "SELECT id from h1232_tags where published = 1 and alias in (" . $tags . ")";

            $db->setQuery($query);
            $to_assoc_tags = $db->loadAssocList();
            echo '<pre>';
            var_dump($query);
            var_dump($to_assoc_tags);
            echo '</pre>';


            $query = "SELECT id from h1232_categories where published = 1 and alias = " . $db->quote($line[$i][$cat_index]);
            $db->setQuery($query);
            $cat_id = $db->loadResult();
            echo '<pre>';
            var_dump($query);
            var_dump($cat_id);
            echo '</pre>';

            $query = "SELECT id from h1232_content where alias = " . $db->quote($line[$i][$alias_index]);

            $db->setQuery($query);
            $content_id = $db->loadResult();
            echo '<pre>';
            var_dump($query);
            var_dump($content_id);
            echo '</pre>';

            $contentTable->load($content_id);

            $currentTags = $th->getTagIds($content_id, "com_content.article"); // insert your item here

            echo '<pre>';
            var_dump('currentTags');
            var_dump($currentTags);
            echo '</pre>';

            $contentTable->newTags  = array();
            if ($currentTags != '' && is_add_original_tags) {
                $contentTable->newTags = explode(',', $currentTags);
            }

            if (strpos($line[$i][$tag_index], 'deco')) {
                $contentTable->note = "deco";
            } else if (strpos($line[$i][$tag_index], 'image')) {
                $contentTable->note = "image";
            } else if (strpos($line[$i][$tag_index], 'painting')) {
                $contentTable->note = "painting";
            }

            foreach ($to_assoc_tags as $to_assoc_tag) {
                $contentTable->newTags[] = $to_assoc_tag['id'];
            }


            $contentTable->catid = $cat_id;

            //$contentTable->check();
            $contentTable->store();
            //$contentTable->save(array('id' => 75));

            $result = $th->getItemTags("com_content.article", $content_id);
            echo '<pre>';
            var_dump('done');
            //var_dump($result);
            echo '</pre>';
        }
        $i++;
    }

    fclose($file);
} else {
    echo dirname(__FILE__) . DS . $filename . " doesn't exists";
}


die();
