<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

define('_JEXEC', 1);

require_once(dirname(__DIR__) . DS . 'init.php');

define('thumb_path', 'images/bundle/');

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
// 03 Promotion Listing ePoster Listing
// https://docs.google.com/spreadsheets/d/1o3z2dnswht2btUv0ceBu_g-kUKEBiwKUUqTKBjfMqgg/edit
$spreadsheetId = '1o3z2dnswht2btUv0ceBu_g-kUKEBiwKUUqTKBjfMqgg';
$range = 'calc!A1:G';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

$i = 1;
$index = array();
$tempRow = array();

foreach ($values as $row) {
    echo '<pre>';
    var_dump($i);
    echo '</pre>';
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
        dump($index);
    } elseif ($i >= 2) {
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
        echo '<pre>';
        var_dump('$tempRow');
        var_dump($tempRow);
        echo '</pre>';
    }
    $i++;
}