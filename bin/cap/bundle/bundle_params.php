<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require_once(dirname(__DIR__) . DS . 'init.php');

$filename = "calc data - bundle_params (2).csv";

defined('FILE_PATH') or define('FILE_PATH', __DIR__ . DS . $filename);

if (file_exists(FILE_PATH)) {

    $file = fopen(FILE_PATH, "r");
    $i = 0;
    $line = array();
    $db = JFactory::getDBO();
    $bundle_id;
    $params = array(
        'img_names' => array(),
        'chart_option' => array(),
        'bundle_chart_thumb' => array(),
        'bundle_chart_imgs' => array()
    );

    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        if ($i == 0) {
            $alias_index = array_search('bundle alias', $line[$i]);
            $imgs_index = array_search('file name', $line[$i]);
            $chart_option_index = array_search('chart option', $line[$i]);
            $bundle_chart_thumb_index = array_search('bundle_chart_thumb', $line[$i]);
            $bundle_chart_imgs_index = array_search('bundle+chart images', $line[$i]);
        } else {

            if ($line[$i][$alias_index] != '') {
                if (!empty($params['img_names'])) {
                    // insert previous stacked images to table...
                    insertBundleParams($bundle_id, $params);
                }
                $query = "SELECT id from h1232_content where alias = '{$line[$i][$alias_index]}'";
                $db->setQuery($query);
                $bundle_id = $db->loadResult();
                /* echo '<pre>';
                var_dump('$query1');
                var_dump($query);
                var_dump('$bundle_id');
                var_dump($bundle_id);
                echo '</pre>'; */

                //only bundle lines
                $params = array(
                    'img_names' => array(),
                    'chart_option' => array($line[$i][$chart_option_index]),
                    'bundle_chart_thumb' => array($line[$i][$bundle_chart_thumb_index]),
                    'bundle_chart_imgs' => array($line[$i][$bundle_chart_imgs_index])
                );

            
            }

            // all lines
            $params['img_names'][]=$line[$i][$imgs_index];
        }
        $i++;
    }
    insertBundleParams($bundle_id, $params);
}

function insertBundleParams($bundle_id, $params){
    global $db;

    $escaped = json_encode($params);

    $query = "INSERT INTO bundle_params(bundle_id, params, created_on)
    VALUES({$bundle_id}, {$db->quote($escaped)}, {$db->quote(date('Y-m-d H:i:s'))})
    ON DUPLICATE KEY UPDATE params = {$db->quote($escaped)}, updated_on = {$db->quote(date('Y-m-d H:i:s'))}";

    /* echo '<pre>';
    var_dump('$query');
    var_dump($query);
    echo '</pre>'; */

    $db->setQuery($query);
    $result = $db->execute();
    echo '<pre>';
    var_dump('$result');
    var_dump($result);
    echo '</pre>';

}