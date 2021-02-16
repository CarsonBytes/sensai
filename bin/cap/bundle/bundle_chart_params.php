<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require_once(dirname(__DIR__) . DS . 'init.php');

$filename = "calc data - bundle+chart_params.csv";

defined('FILE_PATH') or define('FILE_PATH', __DIR__ . DS . $filename);

if (file_exists(FILE_PATH)) {

    $file = fopen(FILE_PATH, "r");
    $i = 0;
    $line = array();
    $db = JFactory::getDBO();
    $main_id = null;
    $chart_id = '';
    $params = array();
    $type = null;

    ob_start();
    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        if ($i == 0) {
            $type_index = array_search('type', $line[$i]);
            $alias_index = array_search('alias', $line[$i]);
            $imgs_index = array_search('file name', $line[$i]);
            $chart_sku_index = array_search('chart sku', $line[$i]);
            $bundle_chart_thumb_index = array_search('bundle_chart_thumb', $line[$i]);
            $bundle_chart_imgs_index = array_search('bundle+chart images', $line[$i]);
            $bundle_gallery_mapping_index = array_search('1:1 gallery', $line[$i]);
        } else {

            /**
             * before transiting to another type, do 1 insert
             */
            if ($type != $line[$i][$type_index] && $line[$i][$type_index] != '' && $main_id != null) {
                echo '<pre>';
                var_dump('transiting');
                dump($type);
                dump($line[$i][$type_index]);
                dump($main_id);
                echo '</pre>';
                insertParams($type, $main_id, $params);
                $main_id = null;
            }

            if ($line[$i][$type_index] != '') $type = $line[$i][$type_index];


            if ($type == 'chart') {
                /**
                 * only chart line
                 */
                if ($line[$i][$alias_index] != '') {

                    insertParams($type, $main_id, $params);

                    $query = "SELECT id from h1232_content where alias = '{$line[$i][$alias_index]}'";
                    $db->setQuery($query);
                    $main_id = $db->loadResult();

                    if ($main_id == null) {
                        print("chart id not found for alias {$line[$i][$alias_index]}. This chart will be skipped...");
                    }

                    $params = array(
                        'img_names' => array(),
                        'chart_skus' => array(),
                        'chart_j2_store_product_id' => array(),
                        'chart_id' => array()
                    );

                    $query = "SELECT id, j2store_product_id FROM h1232_content c
                    LEFT JOIN h1232_j2store_products jp on jp.product_source_id = c.id
                    LEFT JOIN h1232_j2store_variants jv on jv.product_id = jp.j2store_product_id
                    where jv.sku = {$db->quote($line[$i][$chart_sku_index])};";
                    $db->setQuery($query);
                    $result = $db->loadAssoc();
                    $params['chart_j2_store_product_id'] = $result['j2store_product_id'];
                    $params['chart_id'] = $result['id'];
                }

                // all chart lines
                $params['img_names'][] = $line[$i][$imgs_index];
                $params['chart_skus'][] = $line[$i][$chart_sku_index];
            } else {
                /**
                 * only bundle line
                 */
                if ($line[$i][$alias_index] != '') {

                    insertParams($type, $main_id, $params, $chart_id);

                    $query = "SELECT id from h1232_content where alias = '{$line[$i][$alias_index]}'";
                    $db->setQuery($query);
                    $main_id = $db->loadResult();

                    if ($main_id == null) {
                        print("bundle id not found for alias {$line[$i][$alias_index]}. This bundle will be skipped...");
                    }
                    $params = array(
                        'img_names' => array(),
                        'gallery_mapping'=> array(),
                        'bundle_chart_thumb' => array($line[$i][$bundle_chart_thumb_index]),
                        'bundle_chart_imgs' => array($line[$i][$bundle_chart_imgs_index])
                    );
                    $query = "SELECT id FROM h1232_content c
                    LEFT JOIN h1232_j2store_products jp on jp.product_source_id = c.id
                    LEFT JOIN h1232_j2store_variants jv on jv.product_id = jp.j2store_product_id
                    where jv.sku = {$db->quote($line[$i][$chart_sku_index])};";
                    $db->setQuery($query);
                    $chart_id = $db->loadResult();
                    if ($chart_id == null) {
                        print("chart id not found for sku {$line[$i][$chart_sku_index]}");
                    }
                }

                // all bundle lines
                $params['img_names'][] = $line[$i][$imgs_index];
                $params['gallery_mapping'][] = $line[$i][$bundle_gallery_mapping_index];
            }
        }
        $i++;
    }
    insertParams($type, $main_id, $params, $chart_id);
}

function insertParams($type, $id, $params, $chart_id = '')
{
    /**
     * not the first and not a skipped chart/bundle
     */
    if (!empty($params['img_names']) && $id != null) {
        if ($type == 'chart') {
            // insert previous stacked images to table...
            insertChartParams($id, $params);
        } else {
            // insert previous stacked images to table...
            insertBundleParams($id, $params);
            insertBundlesCharts($id, $chart_id);
        }
    } else {
        print('first or skipped chart/bundle...');
    }
}

function insertBundleParams($bundle_id, $params)
{
    global $db;

    $escaped = json_encode($params);


    $query = "INSERT INTO bundle_params(bundle_id, params, created_on)
    VALUES({$bundle_id}, {$db->quote($escaped)}, {$db->quote(date('Y-m-d H:i:s'))})
    ON DUPLICATE KEY UPDATE params = {$db->quote($escaped)}, updated_on = {$db->quote(date('Y-m-d H:i:s'))}";

    echo 'insertBundleParams';
    dump($query);

    $db->setQuery($query);
    $result = $db->execute();

    dump($result);
}

function insertChartParams($chart_id, $params)
{
    global $db;

    $escaped = json_encode($params);

    if ($chart_id == '' || $chart_id == null)
        $chart_id = 'null';

    $query = "INSERT INTO chart_params(chart_id, params, created_on)
    VALUES({$chart_id}, {$db->quote($escaped)}, {$db->quote(date('Y-m-d H:i:s'))})
    ON DUPLICATE KEY UPDATE params = {$db->quote($escaped)}, updated_on = {$db->quote(date('Y-m-d H:i:s'))}";

    echo 'insertChartParams';
    dump($query);

    $db->setQuery($query);
    $result = $db->execute();

    dump($result);
}

function insertBundlesCharts($bundle_id, $chart_id)
{
    global $db;

    $query = "INSERT INTO bundles_charts(bundle_id, chart_id, created_on)
    VALUES({$bundle_id}, {$chart_id}, {$db->quote(date('Y-m-d H:i:s'))})
    ON DUPLICATE KEY UPDATE bundle_id = {$bundle_id}, chart_id = {$chart_id}, 
    updated_on = {$db->quote(date('Y-m-d H:i:s'))}";

    echo 'insertBundlesCharts';
    dump($query);

    $db->setQuery($query);
    $result = $db->execute();

    dump($result);
}