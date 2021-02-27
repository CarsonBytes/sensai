<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

define('_JEXEC', 1);

define('thumb_path', 'images/bundle/');

require_once(dirname(__DIR__) . DS . 'init.php');

$filename = "03 Promotion Listing - calc.csv";

defined('FILE_PATH') or define('FILE_PATH', __DIR__ . DS . $filename);

global $db;

if (file_exists(FILE_PATH)) {

    $file = fopen($filename, "r");
    $i = 0;

    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        if ($i == 0) {
            $file_id_index = array_search('file_id', $line[$i]);
            $sku_index = array_search('sku', $line[$i]);
            $version_index = array_search('version', $line[$i]);
            $Name_index = array_search('Name', $line[$i]);
            $note_index = array_search('note', $line[$i]);
            $note2_index = array_search('note2', $line[$i]);
            $thumb_index = array_search('image file name', $line[$i]);
            //TODO: path is not yet decided, dummy: files/handbooks/cats2.pdf
            //TODO: lang is not yet defined, default is en in db
            //TODO: to_bundle_j2store_id_after_download is not yet defined
        } else if ($i >= 1) {
            $note = '<p>' . $line[$i][$note_index] . '</p><p>' . $line[$i][$note2_index] . '</p>';
            $thumb = thumb_path .  $line[$i][$thumb_index] . '_277.jpg';
            $query = "
            INSERT INTO filepath(file_id, file_version_id, code, path, title, created, thumb, introtext)
            VALUES({$line[$i][$file_id_index]},  
            {$line[$i][$version_index]},
            {$db->quote($line[$i][$sku_index])}, 
            {$db->quote('files/handbooks/cats2.pdf')},
            {$db->quote($line[$i][$Name_index])},
            {$db->quote(date('Y-m-d H:i:s'))},
            {$db->quote($thumb)},
            {$db->quote($note)})
            ON DUPLICATE KEY UPDATE 
            code = {$db->quote($line[$i][$sku_index])}, 
            path = {$db->quote('files/handbooks/cats2.pdf')},
            title = {$db->quote($line[$i][$Name_index])},
            thumb = {$db->quote($thumb)},
            introtext = {$db->quote($note)},
            updated = {$db->quote(date('Y-m-d H:i:s'))}
            ";
            $db->setQuery($query);
            $result = $db->execute();
            echo '<pre>';
            var_dump($result);
            echo '</pre>';
        }
        $i++;
    }
}


function insertFilePath($chart_id, $params)
{
    global $db;

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
