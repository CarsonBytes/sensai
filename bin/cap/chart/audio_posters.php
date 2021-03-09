<?php

/**
 * to update audio posters fields in charts table, e.g. audio_posters_page_title, audio_posters_page_desc
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

define('_JEXEC', 1);

define('thumb_path', 'images/bundle/');

require_once(dirname(__DIR__) . DS . 'init.php');

$filename = "04-1 Audio Poster Listing Tag pdf qr jpg - calc set listing text.csv";

defined('FILE_PATH') or define('FILE_PATH', __DIR__ . DS . $filename);

global $db;

if (file_exists(FILE_PATH)) {

    $file = fopen($filename, "r");
    $i = 0;

    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        if ($i == 1) {
            $title_index = array_search('Title', $line[$i]);
            $sku_index = array_search('code', $line[$i]);

            $content_index = array();
            for ($j = 1; $j < 6; $j++) {
                $content_index[$j] = array_search('content ' . $j, $line[$i]);
            }

            $content_index[9] = array_search('content 9', $line[$i]);

            $brand_index = array_search('Brand', $line[$i]);
            $pages_index = array_search('# of pages', $line[$i]);

            $features_index = array();
            $features_index['QR code'] = array_search('QR code', $line[$i]);
            $features_index['Easy Navigation'] = array_search('Easy Navigation', $line[$i]);
            $features_index['Rich Content Object Table'] = array_search('Rich Content Object Table', $line[$i]);
            $features_index['Audio Resources'] = array_search('Audio Resources', $line[$i]);
        } else if ($i >= 2) {
            $description = '<ul>';
            for ($j = 1; $j < 6; $j++) {
                if ($line[$i][$content_index[$j]] != 'ditto') $content[$j] = $line[$i][$content_index[$j]];
                if ($content[$j] != '') $description .= '<li>' . $content[$j] . '</li>';
            }
            $description .= '</ul>';

            $description .= '<b>Brand</b>: Sensaihonya<br />';

            $description .= '<b>Code</b>:	<b>' . $line[$i][$sku_index] . '</b><br />';

            $description .= '<b># of pages</b>:	' . $line[$i][$pages_index] . '<br />';

            $description .= '<b># of breeds</b>:	' . $line[$i][$content_index[9]] . '<br />';

            $description .= '<div class="clearfix"></div><b>Features</b><ul>';

            foreach ($features_index as $key => $value) {
                if ($line[$i][$value] != 'ditto') $feature[$key] = $line[$i][$value];
                $description .= "<li><b>$key</b><br /><p>{$feature[$key]}</p></li>";
            }
            $description .= '</ul>';

            insertAudioPoster($line[$i][$sku_index], $line[$i][$title_index], $description);
        }
        $i++;
    }
}

function insertAudioPoster($code, $title, $desc)
{
    global $db;

    
    $query = "SELECT id FROM h1232_content c
    LEFT JOIN h1232_j2store_products jp on jp.product_source_id = c.id
    LEFT JOIN h1232_j2store_variants jv on jv.product_id = jp.j2store_product_id
    where jv.sku = {$db->quote($code)};";
    $db->setQuery($query);
    $chart_id = $db->loadResult();

    
    echo 'get chart_id';
    dump($query);

    if ($chart_id == '' || $chart_id == null){
        dump('chart_id not found... skipped!');
        return false;

    }

    //TODO insert lang accordingly after running bundle_chart_params
    $query = "INSERT INTO charts(chart_id, code, lang, audio_posters_page_title, audio_posters_page_desc, created_on)
    VALUES(
    {$chart_id},
    {$db->quote($code)}, 
    'en',
    {$db->quote($title)},
    {$db->quote($desc)},
    {$db->quote(date('Y-m-d H:i:s'))})
    ON DUPLICATE KEY UPDATE 
    code = {$db->quote($code)}, 
    lang = 'en', 
    audio_posters_page_title = {$db->quote($title)}, 
    audio_posters_page_desc = {$db->quote($desc)}, 
    updated_on = {$db->quote(date('Y-m-d H:i:s'))}";

    echo 'insertAudioPoster';
    dump($query);

    $db->setQuery($query);
    $result = $db->execute();

    dump($result);
}
