<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require_once(dirname(__DIR__) . DS . 'init.php');

$filename = "calc data - bundle_params (3).csv";

defined('FILE_PATH') or define('FILE_PATH', __DIR__ . DS . $filename);

if (file_exists(FILE_PATH)) {

    $file = fopen(FILE_PATH, "r");
    $i = 0;
    $line = array();
    $db = JFactory::getDBO();
    $bundle_id;

    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        if ($i == 0) {
            $alias_index = array_search('bundle alias', $line[$i]);
            $cat1_index = array_search('cat1', $line[$i]);
            $cat2_index = array_search('cat2', $line[$i]);
            /* $category_alias_to_replace_index = array_search('category alias to replace', $line[$i]); */
        } else {

            if ($line[$i][$alias_index] != '') { // bundle line...
                $query = "SELECT id from h1232_content where alias = '{$line[$i][$alias_index]}'";
                $db->setQuery($query);
                $bundle_id = $db->loadResult();
                echo '<pre>';
                var_dump('bundle:');
                var_dump($line[$i][$alias_index]);
                echo '</pre>';
            }

            // all lines
            $cat_alias[0] = $line[$i][$cat1_index];
            $cat_alias[1] = $cat_alias[0] . '/' . $line[$i][$cat2_index];
            /* if ($line[$i][$category_alias_to_replace_index] != '') {
                $cat_alias[1] = $line[$i][$category_alias_to_replace_index];
                $cat_alias[0] = explode('/', $cat_alias[1])[0];
            } */

            for ($j = 0; $j < 2; $j++) {
                $query = "SELECT id from h1232_categories where path = 'poster/{$cat_alias[$j]}'";
                $db->setQuery($query);
                $cat_id = $db->loadResult();

                if ($cat_id != '') {
                    insertBundlesCategories($bundle_id, $cat_id);
                } else {
                    echo '<pre>';
                    var_dump('no id is found');
                    echo '</pre>';
                }
            }
        }
        $i++;
    }
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
    var_dump('$result');
    var_dump($result);
    echo '</pre>';
}
