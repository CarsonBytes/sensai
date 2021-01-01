<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require_once(dirname(__DIR__) . DS . 'init.php');

$filename = "calc data - bundle_params.csv";

defined('FILE_PATH') or define('FILE_PATH', __DIR__ . DS . $filename);

if (file_exists(FILE_PATH)) {

    $file = fopen(FILE_PATH, "r");
    $i = 0;
    $line = array();
    $db = JFactory::getDBO();
    $bundle_id;
    $params = array(
        'img_names' => array(),
        'bundle_chart_thumb' => array(),
        'bundle_chart_imgs' => array()
    );
    $chart_id;

    ob_start();
    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        if ($i == 0) {
            $alias_index = array_search('bundle alias', $line[$i]);
            $imgs_index = array_search('file name', $line[$i]);
            $chart_sku_index = array_search('chart sku', $line[$i]);
            $bundle_chart_thumb_index = array_search('bundle_chart_thumb', $line[$i]);
            $bundle_chart_imgs_index = array_search('bundle+chart images', $line[$i]);
        } else {

            /**
             * only bundle line
             */
            if ($line[$i][$alias_index] != '') {

                /**
                 * not the first bundle and not a skipped bundle
                 */
                if (!empty($params['img_names']) && $bundle_id != null) {
                    // insert previous stacked images to table...
                    insertBundleParams($bundle_id, $params, $chart_id);
                }

                $query = "SELECT id from h1232_content where alias = '{$line[$i][$alias_index]}'";
                $db->setQuery($query);
                $bundle_id = $db->loadResult();
                /* echo '<pre>';
                var_dump($query);
                var_dump($bundle_id);
                echo '</pre>'; */

                if ($bundle_id == null) {
                    print("bundle id not found for alias {$line[$i][$alias_index]}. This bundle will be skipped...");
                }
                $params = array(
                    'img_names' => array(),
                    'bundle_chart_thumb' => array($line[$i][$bundle_chart_thumb_index]),
                    'bundle_chart_imgs' => array($line[$i][$bundle_chart_imgs_index])
                );
                $query = "SELECT id FROM sensaiho_nya.h1232_content c
                LEFT JOIN h1232_j2store_products jp on jp.product_source_id = c.id
                LEFT JOIN h1232_j2store_variants jv on jv.product_id = jp.j2store_product_id
                where jv.sku = {$db->quote($line[$i][$chart_sku_index])};";
                $db->setQuery($query);
                $chart_id = $db->loadResult();
                if ($chart_id == null) {
                    print("chart id not found for sku {$line[$i][$chart_sku_index]}");
                }
            }

            // all lines
            $params['img_names'][] = $line[$i][$imgs_index];
        }
        $i++;
    }
    /**
     * not the first bundle and not a skipped bundle
     */
    if (!empty($params['img_names']) && $bundle_id != null) {
        // insert previous stacked images to table...
        insertBundleParams($bundle_id, $params, $chart_id);
    }
}

function insertBundleParams($bundle_id, $params, $chart_id = null)
{
    global $db;

    $escaped = json_encode($params);

    if ($chart_id == '' || $chart_id == null)
        $chart_id = 'null';

    $query = "INSERT INTO bundle_params(bundle_id, chart_id, params, created_on)
    VALUES({$bundle_id}, {$chart_id}, {$db->quote($escaped)}, {$db->quote(date('Y-m-d H:i:s'))})
    ON DUPLICATE KEY UPDATE chart_id = {$chart_id}, 
    params = {$db->quote($escaped)}, updated_on = {$db->quote(date('Y-m-d H:i:s'))}";

    /*  echo '<pre>';
    var_dump('$query');
    var_dump($query);
    echo '</pre>';
    return ob_get_clean(); */

    $db->setQuery($query);
    $result = $db->execute();
    echo '<pre>';
    var_dump('$result');
    var_dump($result);
    echo '</pre>';
}
