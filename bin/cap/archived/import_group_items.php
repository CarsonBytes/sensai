<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('_JEXEC', 1);
define('JPATH_BASE', dirname(__DIR__) . '/..');
define('DS', DIRECTORY_SEPARATOR);
require_once(JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once(JPATH_BASE . DS . 'includes' . DS . 'framework.php');

use Joomla\CMS\Factory;

$filename = "000-01 publish records and web relationship - group_items.csv";
$group_init_num = 1;

$group = array();
$group_name = array();
$sku;
$group_num;

if (file_exists(dirname(__FILE__) . DS . $filename)) {

    $file = fopen($filename, "r");
    $line = array();
    $db = JFactory::getDBO();
    $bundle_id;

    $i = 0;
    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        $j = 0;
        /* echo '<pre>';
            var_dump('$line[1]');
            var_dump($line[1]);
            echo '</pre>'; */
        if ($i == 0 || $line[$i][1] == '') {
            $i++;
            continue;
        }
        foreach ($line[$i] as $grid) {
            if ($grid == '') {
                $j++;
                continue;
            }
            if ($j == 0) {
                /* echo '<pre>';
                var_dump('sku');
                var_dump($grid);
                echo '</pre>'; */
                $sku = $grid;
            } else if ($j == 1) {
                /* $query = "SELECT id from h1232_content where alias = " . $db->quote('b' . $grid);
                $db->setQuery($query);
                $bundle_id = $db->loadResult();
                echo '<pre>';
                var_dump('group');
                var_dump($grid);
                echo '</pre>'; */
                $group_num = $grid;
                if (!isset($group[$group_num])) {
                    $group[$group_num] = array();
                }
                $group[$group_num][] = $sku;
            } else if ($j == 2) {
                /* echo '<pre>';
                var_dump('group name');
                var_dump($grid);
                echo '</pre>'; */
                $group_name[$group_num] = $grid;
            }
            $j++;
        }

        $i++;
    }

    echo '<pre>';
    var_dump('$group');
    var_dump($group);
    var_dump('$group_name');
    var_dump($group_name);
    echo '</pre>';

    $i = $group_init_num;
    foreach ($group as $single_group) :
        $query = "SELECT c.id, p.params from h1232_content c
        LEFT JOIN `h1232_j2store_products` p ON p.product_source_id = c.id
        LEFT JOIN `h1232_j2store_variants` v ON p.j2store_product_id = v.product_id
        where v.sku in (" . implode(',', $db->quote($single_group)) . ")";
        $db->setQuery($query);
        $deco_result = $db->loadRowList();
        $deco_ids = $db->loadColumn();
        echo '<pre>';
        var_dump($deco_result);
        echo '<pre>';

        foreach ($deco_result as $single_deco) :
            // ids except self
            $ids = $deco_ids;
            $key = array_search($single_deco[0], $ids);
            unset($ids[$key]);
            echo '<pre>';
            var_dump('$deco_ids');
            var_dump($deco_ids);
            var_dump('$ids');
            var_dump($ids);
            echo '<pre>';

            //params
            $params = json_decode($single_deco[1]);
            if ($params == null) {
                $params = new stdClass;
            }
            $params->group_items = implode(',', $ids);
            $params->group_title = $group_name[$i];
            echo '<pre>';
            var_dump('$params');
            var_dump($params);
            echo '<pre>';

            $query = 'UPDATE h1232_j2store_products SET params = ' . $db->quote(json_encode($params)) .
                ' WHERE product_source_id = ' . $single_deco[0];
            $db->setQuery($query);
            $result = $db->execute();

        endforeach;
        $i++;
    endforeach;
}
