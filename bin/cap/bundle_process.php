<?php
define('DS', DIRECTORY_SEPARATOR);

require_once(__DIR__ . DS . 'init.php');

$filename = "calc data - bundle+chart_params (2).csv";

define('FILE_PATH', __DIR__ . DS . 'bundle' . DS . $filename);

/**
 * import params for bundles, e.g.
 * mapping for extra single images of each bundle, and chart_option
 */
require_once(__DIR__ . DS . 'bundle' . DS . 'bundle_chart_params.php');

/**
 * associate tags with bundles, remove old redundant tags' connections
 */
//require_once(__DIR__ . DS . 'bundle' . DS . 'assoc_tags.php');

/**
 * map bundles with categories in bundles_categories table
 */
//require_once(__DIR__ . DS . 'bundle' . DS . 'categories_mapping.php');

/**
 * assume category are already defined
 * @todo category to be created if not existing
 * add menuitems, unpublish menuitems without any bundle related
 */
//require_once(__DIR__ . DS . 'bundle' . DS . 'add_menuitems.php');