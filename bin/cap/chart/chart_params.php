<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

require_once(dirname(__DIR__) . DS . 'init.php');

$filename = "calc data - chart_params.csv";

defined('FILE_PATH') or define('FILE_PATH', __DIR__ . DS . $filename);

if (file_exists(FILE_PATH)) {

    $file = fopen(FILE_PATH, "r");
    $i = 0;
    $line = array();
    $db = JFactory::getDBO();
    $chart_id;
    $params = array(
        'img_names' => array()
    );

    ob_start();
    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        if ($i == 0) {
            $alias_index = array_search('chart alias', $line[$i]);
            $imgs_index = array_search('file name', $line[$i]);
        } else {

            /**
             * only chart line
             */
            if ($line[$i][$alias_index] != '') {

                /**
                 * not the first chart and not a skipped chart
                 */
                if (!empty($params['img_names']) && $chart_id != null) {
                    // insert previous stacked images to table...
                    insertChartParams($chart_id, $params);
                }

                $query = "SELECT id from h1232_content where alias = '{$line[$i][$alias_index]}'";
                $db->setQuery($query);
                $chart_id = $db->loadResult();
                /* echo '<pre>';
                var_dump($query);
                var_dump($chart_id);
                echo '</pre>'; */

                if ($chart_id == null) {
                    print("chart id not found for alias {$line[$i][$alias_index]}. This chart will be skipped...");
                }
                $params = array(
                    'img_names' => array()
                );
            }

            // all lines
            $params['img_names'][] = $line[$i][$imgs_index];
        }
        $i++;
    }
    /**
     * not the first chart and not a skipped chart
     */
    if (!empty($params['img_names']) && $chart_id != null) {
        // insert previous stacked images to table...
        insertChartParams($chart_id, $params);
    }
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
