<?php

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
require_once(dirname(__DIR__) . DS . 'init.php');

$array = array(
    'title' => 'Cat Poster',
    'thumb' => 'images/bundle/gallery/A0B_405_2_762.jpg',
    'introtext' =>
    "<p>RSPB is giving away FREE Big Garden Birdwatch packs which contain bird charts, a calendar, recipes for bird food and more! Register now and help to support the wildlife where you live. They'll also send you emails with plenty of fun activities for kids and ideas to get the garden viable for wildlife.</p>",
    'to_bundle_j2store_id_after_download' => 171,
    'alternative_filepath_code' => 'test2',
    'total_download_limit' => 5,
    'total_download_limit_per_user' => 3
);

echo '<pre>';
var_dump(json_encode($array));
echo '</pre>';


$array = json_encode($array);

$query = "INSERT INTO filepath(file_id, file_version_id, code, path, params, created)
VALUES(1, 1, 'test', 'files/handbooks/cats.pdf', {$db->quote($array)}, {$db->quote(date('Y-m-d H:i:s'))})
ON DUPLICATE KEY UPDATE params = {$db->quote($array)}, updated = {$db->quote(date('Y-m-d H:i:s'))}";

dump($query);

$db->setQuery($query);
$result = $db->execute();

dump($result);
/*  */

$query = "SELECT path, params FROM sensaiho_nya.filepath fp
where fp.code = {$db->quote('test')};";
dump($query);
$db->setQuery($query);
$result = $db->loadObject();
dump($result);
dump($result->path);
dump($result->params);
$params = json_decode($result->params);
dump($params);
die();
