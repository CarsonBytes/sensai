<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('is_add_original_tags', 0);

define('_JEXEC', 1);
define('JPATH_BASE', dirname(__DIR__) . '/..');
define('DS', DIRECTORY_SEPARATOR);
require_once(JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once(JPATH_BASE . DS . 'includes' . DS . 'framework.php');

use Joomla\CMS\Factory;

$filename = "000-01 publish records and web relationship - bundle.csv";

if (file_exists(dirname(__FILE__) . DS . $filename)) {

    $file = fopen($filename, "r");
    $i = 0;
    $line = array();
    $db = JFactory::getDBO();
    $bundle_id;

    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        if ($i >= 5) {

            $j = 0;
            foreach ($line[$i] as $grid) {
                echo '<pre>';
                var_dump('$j');
                var_dump($j);
                echo '</pre>';
                if ($j == 1) {
                    $query = "SELECT id from h1232_content where alias = " . $db->quote($grid);
                    $db->setQuery($query);
                    $bundle_id = $db->loadResult();
                    echo '<pre>';
                    var_dump('$bundle_id');
                    var_dump($bundle_id);
                    echo '</pre>';
                } else if ($j > 1) {
                    $grid = substr($grid, 0, strpos($grid, '-'));
                    if ($grid !== '') {
                        echo '<pre>';
                        var_dump('$grid');
                        var_dump($grid);
                        echo '</pre>';

                        $query = "SELECT id from h1232_content c
                    LEFT JOIN `h1232_j2store_products` p ON p.product_source_id = c.id
                    LEFT JOIN `h1232_j2store_variants` v ON p.j2store_product_id = v.product_id
                    where v.sku = " . $db->quote($grid);

                        $db->setQuery($query);
                        $deco_id = $db->loadResult();
                        echo '<pre>';
                        var_dump('$deco_id');
                        var_dump($deco_id);
                        echo '</pre>';

                        $query ='INSERT INTO bundle_single(bundle_id, single_id, created_on)
                        VALUES('.$bundle_id.', '.$deco_id.', '.$db->quote(date('Y-m-d H:i:s')).')
                        ON DUPLICATE KEY UPDATE updated_on = '.$db->quote(date('Y-m-d H:i:s'));

                        // Create a new query object.
                        //$query = $db->getQuery(true);
                        // Insert columns.
                        //$columns = array('bundle_id', 'single_id', 'created_on');
                        // Insert values.
                        //$values = array($bundle_id, $deco_id, $db->quote(date('Y-m-d H:i:s')));
                        // Prepare the insert query.
                       /*  $query
                            ->insert($db->quoteName('bundle_single'))
                            ->columns($db->quoteName($columns))
                            ->values(implode(',', $values)); */

                        // Set the query using our newly populated query object and execute it.
                        $db->setQuery($query);
                        $result = $db->execute();
                        echo '<pre>';
                        var_dump('$result');
                        var_dump($result);
                        echo '</pre>';
                    }
                }
                $j++;
            }
        }
        $i++;
    }
}
