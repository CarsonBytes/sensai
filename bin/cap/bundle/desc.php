<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

define('_JEXEC', 1);

require_once(dirname(__DIR__) . DS . 'init.php');

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1E7VbUFsKXXLpejchDN0ovPR0o-_nyXuJJ2S6Y3uiLZg/edit
$spreadsheetId = '1E7VbUFsKXXLpejchDN0ovPR0o-_nyXuJJ2S6Y3uiLZg';
$range = 'calc bundle detail!A1:U';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

$i = 1;
$index = array();
$tempRow = array();
foreach ($values as $row) {
    echo '<pre>';
    var_dump($i);
    echo '</pre>';
    dump($row);
    if ($i == 1) {
        $j = 0;
        foreach ($row as $field) {
            /**
             * map each column index with the field name
             */
            if (trim($field) == '') {
                $j++;
                continue;
            }
            $index[$field] = $j++;
        }
        /* dump($index); */
    } elseif ($i == 2) {
        $standard_bundle_heading = $row[$index['Formats']];
        $standard_plus_bundle_heading = $row[$index['Formats'] + 1];
    } elseif ($i >= 3) {
        /**
         * when it comes to ditto, just use the previous row's non-ditto value
         */
        $j = 0;
        foreach ($row as $field) {
            if ($field == 'ditto') {
                $j++;
                continue;
            }
            $tempRow[$j++] = $field;
        }


        $desc = '<table class="table table-striped" style="margin-top:10px">';
        $points = array(
            'Title' => $tempRow[$index['Title']],
            'Brand' => $tempRow[$index['Brand']],
            'Code' => $tempRow[$index['Code']],
            'Formats' => '<div class="standard_plus_bundle">' .
                $standard_plus_bundle_heading . '<br />' . $tempRow[$index['Formats'] + 1] .
                '</div><div class="standard_bundle" style="display:none;">' .
                $standard_bundle_heading . '<br />' . $tempRow[$index['Formats']] .
                '</div>',
            'Material' =>  $tempRow[$index['Material']],
            'Manufacturer' =>  $tempRow[$index['Manufacturer']],
            'Frame type' =>  $tempRow[$index['Frame type']],
        );
        foreach ($points as $key => $value) {
            $desc .= "<tr><td><b>{$key}</b></td><td>{$value}</td></tr>";
        }
        $desc .= '</table>';
        $desc .= '<p>' . $tempRow[$index['Desc']] . '</p><p>' . $tempRow[$index['Desc'] + 1] . '</p>';
        /* echo '<pre>';
        var_dump('$index');
        var_dump($index);
        var_dump('$tempRow');
        var_dump($tempRow);
        var_dump('$points');
        var_dump($points);
        var_dump('$desc');
        var_dump($desc);
        echo '</pre>';
        die(); */
        updateDesc($tempRow[$index['Code']], $desc);
    }
    $i++;
}

function updateDesc($sku, $desc)
{
    global $db;

    $query = "SELECT id FROM h1232_content c
    LEFT JOIN h1232_j2store_products jp on jp.product_source_id = c.id
    LEFT JOIN h1232_j2store_variants jv on jv.product_id = jp.j2store_product_id
    where jv.sku = {$db->quote($sku)};";
    dump($query);
    $db->setQuery($query);
    $content_id = $db->loadResult();
    dump($content_id);

    if ($content_id != null) {
        $query = "UPDATE h1232_content SET 
        introtext = {$db->quote($desc)},
        modified = {$db->quote(date('Y-m-d H:i:s'))}
        WHERE (id = {$db->quote($content_id)});";
        dump($query);
        $db->setQuery($query);
        $result = $db->execute();
        dump($result);
    }
}
