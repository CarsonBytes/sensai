<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require_once(dirname(__DIR__) . DS . 'init.php');

$filename = "calc data - bundle_params (2).csv";

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

    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        if ($i == 0) {
            $alias_index = array_search('bundle alias', $line[$i]);
            $tag_index = array_search('tags', $line[$i]);
            $cat_index = array_search('category', $line[$i]);
        }
        if ($i > 0 && $line[$i][$alias_index] != '') {
            echo $line[$i][$alias_index] . '<br />';
            echo $line[$i][$tag_index] . '<br />';
            echo $line[$i][$cat_index] . '<br />';

            $th = new TagsHelper();
            $to_add_tags = str_replace(' ', '-', $line[$i][$tag_index]);
            $to_add_tags_array = array_unique(explode(',', $to_add_tags));
            foreach ($to_add_tags_array as &$tag) {
                $tag = '#new#' . $tag;
            }
            echo '<pre>';
            var_dump('to_add_tags:');
            var_dump($to_add_tags);
            //var_dump($to_add_tags_array);
            echo '</pre>';

            /**
             * create tags if new, 
             * and get tag ids by tag names to add
             */
            $to_assoc_tags = $th->createTagsFromField($to_add_tags_array);
            echo '<pre>';
            var_dump('create tags if new and get tags:');
            var_dump(implode(',', $to_assoc_tags));
            echo '</pre>';

            /**
             * get category ids to attach
             */
            $query = "SELECT id from h1232_categories where published = 1 and alias = " . $db->quote($line[$i][$cat_index]);
            $db->setQuery($query);
            $cat_id = $db->loadResult();
            echo '<pre>';
            var_dump($query);
            var_dump($cat_id);
            echo '</pre>';

            /**
             * get content id of the bundle
             */
            $query = "SELECT id from h1232_content where alias = " . $db->quote($line[$i][$alias_index]);
            $db->setQuery($query);
            $content_id = $db->loadResult();
            echo '<pre>';
            var_dump($query);
            var_dump($content_id);
            echo '</pre>';

            /**
             * get current tags of the bundle
             */
            $currentTags = $th->getTagIds($content_id, "com_content.article"); // insert your item here

            /**
             * get old redundant tags
             */
            $old_redundant_tags = array_filter(explode(',', $currentTags), function ($k) {
                global $to_assoc_tags;
                return !in_array($k, $to_assoc_tags);
            });
            echo '<pre>';
            var_dump('currentTags');
            var_dump($currentTags);
            var_dump('to_assoc_tags');
            var_dump(implode(',',$to_assoc_tags));
            var_dump('old_redundant_tags');
            var_dump(implode(',',$old_redundant_tags));
            echo '</pre>';

            /**
             * untag the old redundant tags from the bundle 
             */
            if (isset($old_redundant_tags[0]) && $old_redundant_tags[0]!='') {
                $untag_result = unTagItem($content_id,$old_redundant_tags);
                echo '<pre>';
                var_dump('untag_result');
                var_dump($untag_result);
                echo '</pre>';
            }

            $contentTable->load($content_id);

            /**
             * add the category id to the bundle array
             */
            $contentTable->catid = $cat_id;

            /**
             * add the tags to the bundle array
             */
            $contentTable->newTags  = array();
            foreach ($to_assoc_tags as $to_assoc_tag) {
                $contentTable->newTags[] = strval($to_assoc_tag);
            }
            /* echo '<pre>';
            var_dump('contentTable->newTags');
            var_dump($contentTable->newTags);
            echo '</pre>'; */

            /**
             * add the note to the bundle array
             */
            if (strpos($line[$i][$tag_index], 'educational-cat') !== false) {
                $contentTable->note = "educational-cat";
            } else if (strpos($line[$i][$tag_index], 'educational-dog') !== false) {
                $contentTable->note = "educational-dog";
            } else if (strpos($line[$i][$tag_index], 'bundle') !== false) {
                $contentTable->note = "bundle";
            }
            echo '<pre>';
            var_dump('$contentTable->note');
            var_dump($contentTable->note);
            echo '</pre>';

            //$contentTable->check();
            $contentTable->store();
            //$contentTable->save(array('id' => 75));

            $result = $th->getItemTags("com_content.article", $content_id);
            echo '<pre>';
            //var_dump($result);
            var_dump('done');
            echo '</pre>';
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
