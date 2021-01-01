<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require_once(dirname(__DIR__) . DS . 'init.php');

$filename = "calc data - bundle+chart_params.csv";

defined('FILE_PATH') or define('FILE_PATH', __DIR__ . DS . $filename);

use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Table\Table;
use Joomla\Utilities\ArrayHelper;

if (file_exists(FILE_PATH)) {

    $file = fopen(FILE_PATH, "r");
    $i = 0;
    $line = array();
    $tag_index;
    $alias_index;
    $th = new TagsHelper();
    $contentTable = Table::getInstance('Content');

    ob_start();
    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        if ($i == 0) {
            $alias_index = array_search('alias', $line[$i]);
            $tag_index = array_search('tags', $line[$i]);
            $cat_index = array_search('category', $line[$i]);
            $type_index = array_search('type', $line[$i]);
        }
        if ($i > 0 && $line[$i][$alias_index] != '') {
            dump($line[$i][$alias_index]);
            dump($line[$i][$tag_index]);
            dump($line[$i][$cat_index]);
            dump($line[$i][$type_index]);

            $th = new TagsHelper();
            $to_add_tags = str_replace(' ', '-', $line[$i][$tag_index]);
            $to_add_tags_array = array_diff(array_unique(explode(',', $to_add_tags)), [''] ) ;
            /* echo '<pre>';
            var_dump($to_add_tags);
            var_dump($to_add_tags_array);
            echo '</pre>';
            ob_flush(); */
            foreach ($to_add_tags_array as &$tag) {
                $tag = '#new#' . $tag;
            }
            dump($to_add_tags);
            dump($to_add_tags_array);

            /**
             * create tags if new, 
             * and get tag ids by tag names to add
             */
            $to_assoc_tags = $th->createTagsFromField($to_add_tags_array);
            echo('create tags if new and get tags:');
            dump(implode(',', $to_assoc_tags));

            /**
             * get category ids to attach
             */
            $query = "SELECT id from h1232_categories where published = 1 and alias = " . $db->quote($line[$i][$cat_index]);
            $db->setQuery($query);
            $cat_id = $db->loadResult();
            dump($query);
            dump($cat_id);

            /**
             * get content id of the bundle/chart
             */
            $query = "SELECT id from h1232_content where alias = " . $db->quote($line[$i][$alias_index]);
            $db->setQuery($query);
            $content_id = $db->loadResult();
            dump($query);
            dump($content_id);

            /**
             * get current tags of the bundle/chart
             */
            $currentTags = $th->getTagIds($content_id, "com_content.article"); // insert your item here

            /**
             * get old redundant tags
             */
            $old_redundant_tags = array_filter(explode(',', $currentTags), function ($k) {
                global $to_assoc_tags;
                return !in_array($k, $to_assoc_tags);
            });
            dump(implode(',', $to_assoc_tags));
            dump(implode(',', $old_redundant_tags));
            
            /**
             * untag the old redundant tags from the bundle 
             */
            if (isset($old_redundant_tags[0]) && $old_redundant_tags[0] != '') {
                $untag_result = unTagItem($content_id, $old_redundant_tags);
                dump($untag_result);
            }

            $contentTable->load($content_id);

            /**
             * add the category id to the bundle/chart array
             */
            $contentTable->catid = $cat_id;

            /**
             * add the tags to the bundle/chart array
             */
            $contentTable->newTags  = array();
            foreach ($to_assoc_tags as $to_assoc_tag) {
                $contentTable->newTags[] = strval($to_assoc_tag);
            }
            dump($contentTable->newTags);

            /**
             * add the note to the bundle/chart array
             */
            $contentTable->note = $line[$i][$type_index];
            
            dump($contentTable->note);

            //$contentTable->check();
            $contentTable->store();
            //$contentTable->save(array('id' => 75));

            $result = $th->getItemTags("com_content.article", $content_id);
            //var_dump($result);
            echo('done');
            ob_flush();
        }
        $i++;
    }

    fclose($file);
} else {
    echo dirname(__FILE__) . DS . $filename . " doesn't exists";
}


$app->logout();



/**
 * not used yet, not sure whether we will need it in future.
 * referred from libraries\src\Helper\TagsHelper.php
 * Method to untag an item
 *
 * @param   integer         $contentId  ID of the content item being untagged
 * @param   array           $tags       Array of tags to be untagged. Use an empty array to untag all existing tags.
 *
 * @return  boolean  true on success, otherwise false.
 *
 */
function unTagItem($contentId, $tags = array())
{
    global $db;
    $query = $db->getQuery(true)
        ->delete('h1232_contentitem_tag_map')
        ->where($db->quoteName('content_item_id') . ' = ' . (int) $contentId);

    if (is_array($tags) && count($tags) > 0) {
        $tags = ArrayHelper::toInteger($tags);

        $query->where($db->quoteName('tag_id') . ' IN (' . implode(',', $tags) . ')');
    }

    $db->setQuery($query);

    return (bool) $db->execute();
}
