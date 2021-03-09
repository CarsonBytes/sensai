<?php

/**
 * assume all categories and their parents are already defined
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

define('_JEXEC', 1);

require_once(dirname(__DIR__) . DS . 'init.php');

$filename = "02 070 cat-structure bundle-cat bundle-detail bundle-tag - cat-structure.csv";

defined('FILE_PATH') or define('FILE_PATH', __DIR__ . DS . $filename);

define('POSTER_ROOT_ALIAS', 'poster');

if (file_exists(FILE_PATH)) {

    $file = fopen($filename, "r");
    $i = 0;
    $level_ids = array(0 => 1); //root level => root id 
    $level_alias = array(POSTER_ROOT_ALIAS);
    $cat_ids = array();
    $cats = array();

    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        if ($i == 0) {
            $bundle_sku_index = array_search('bundle / set sku', $line[$i]);
            $bundle_skus = array_splice($line[$i], $bundle_sku_index + 2, count($line[$i]));
            /* echo '<pre>';
            var_dump($bundle_skus);
            echo '</pre>'; */
        } else if ($i == 1) {
            $poster_sku_index = array_search('poster sku', $line[$i]);
            $poster_skus = array_splice($line[$i], $poster_sku_index + 2, count($line[$i]));
            /* echo '<pre>';
            var_dump($poster_skus);
            echo '</pre>'; */
        } else if ($i == 3) {
            $level_index = array_search('level', $line[$i]);
            $alias_index = array_search('alias', $line[$i]);
            $categ_index = array_search('2 categ', $line[$i]);
            /* echo '<pre>';
            var_dump($level_index, $alias_index);
            echo '</pre>'; */
        } else if ($i > 4) {
            /*  echo $line[$i][$level_index] . '<br />';
            echo $line[$i][$alias_index] . '<br />'; */

            $level_alias[$line[$i][$level_index] - 1] = $line[$i][$alias_index];
            for ($j = $line[$i][$level_index]; $j < count($level_alias); $j++) {
                unset($level_alias[$j]);
            }

            $category_path = implode('/', $level_alias);
            $cats[$line[$i][$level_index] - 2] = $category_path;

            $cat_ids[$line[$i][$level_index] - 2] = getCategoryIDByPath($category_path);

            echo '<pre>';
            var_dump($cat_ids, $cats);
            echo '</pre>';


            array_splice($line[$i], 0, $categ_index + 2);
            $j = 0;
            foreach ($line[$i] as $value) {
                if ($value == 'Y') {
                    foreach ($cat_ids as $catID) {
                        if ($bundle_skus[$j] == '')
                            $content_id = getContentIDBySKU($poster_skus[$j]);
                        else
                            $content_id = getContentIDBySKU($bundle_skus[$j]);
                        
                        if ($content_id == null){
                            echo 'getContentIDBySKU returns null:';
                            echo '<pre>';
                            var_dump($bundle_skus[$j], $poster_skus[$j], $content_id, $cats);
                            echo '</pre>';
                            break;
                        }
                        insertBundlesCategories($content_id, $catID);
                        assocMainCategory($content_id, $catID);
                    }
                }
                $j++;
            }
        }
        $i++;
    }
}

function getCategoryIDByPath($path)
{
    global $db;

    $query = "SELECT id FROM h1232_categories where path = {$db->quote($path)}";

    $db->setQuery($query);

    return $db->loadResult();
}

function getContentIDBySKU($sku)
{
    global $db;

    $query = "SELECT id FROM h1232_content c
    LEFT JOIN h1232_j2store_products jp on jp.product_source_id = c.id
    LEFT JOIN h1232_j2store_variants jv on jv.product_id = jp.j2store_product_id
    WHERE jv.sku = {$db->quote($sku)};";
    $db->setQuery($query);
    return $db->loadResult();
}

use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\Table\Table;

function assocMainCategory($content_id, $cat_id)
{
    $contentTable = Table::getInstance('Content');
    $contentTable->load($content_id);
    $contentTable->catid = $cat_id;


    $th = new TagsHelper();
    $currentTags = $th->getTagIds($content_id, "com_content.article"); // insert your item here
    $contentTable->newTags = explode(',',$currentTags);
    
    $contentTable->store();
}



function insertBundlesCategories($bundle_id, $cat_id)
{
    global $db;

    $query = "INSERT INTO bundles_categories(bundle_id, category_id, created_on)
    VALUES({$bundle_id}, {$cat_id}, {$db->quote(date('Y-m-d H:i:s'))})
    ON DUPLICATE KEY UPDATE category_id = {$cat_id}, updated_on = {$db->quote(date('Y-m-d H:i:s'))}";

    $db->setQuery($query);
    $result = $db->execute();
    echo '<pre>';
    var_dump($query);
    dump($result);
    echo '</pre>';
}
