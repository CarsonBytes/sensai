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
// https://docs.google.com/spreadsheets/d/18TIr_urpwaNov74ZXgH68ti6C83hf1f0ZsgIHQCEIz8/edit //P12003-dog Popular Dog Breeds (collection 1)
// https://docs.google.com/spreadsheets/d/1maYb4nfHgWsCWtmbq6E_C7LG-YAHTkXPrgBTSL712Qk/edit //A0B_10610_dog_2 Popular Dog Breeds (collection 2)
// https://docs.google.com/spreadsheets/d/1rDnqmqPH7plw2siVqk5qQdEXl5pbDn9J-ZL_OHD5jPg/edit //A08_10550_Ed_ABC
// https://docs.google.com/spreadsheets/u/3/d/11iYcWnPU983wWxUVyuXkVhnCFUwiGJVKkrJpB16lzCE/edit //A08_10560_123
// https://docs.google.com/spreadsheets/d/1-FqUtlKS54GAr5DwuTxQYjgEGf9cyhScX1f1lC2p1rU/edit //A08_10570_dino
// https://docs.google.com/spreadsheets/d/13KaBJ26tAN-7Kx3ll3ft9DBNiXL2nEI5LDLMo8q1uh0/edit //A08_10580_Ed_veggie
// https://docs.google.com/spreadsheets/d/1mNav-_gMTzBZzM56IwjHpsa8ourOeVMYvb1SX5NWlGE/edit //A08_10590_Ed_farm
// https://docs.google.com/spreadsheets/d/1uVdy_JV2FKoUZPmDcVu3tSfHTVgzno-bH21g5O1pKQg/edit //A08_10600_Ed_animal
// https://docs.google.com/spreadsheets/d/1yhmokyedeptAi9lMUjZvDdVTxseI3zZCpXmLXUhw2zk/edit //A08_10610_body
// https://docs.google.com/spreadsheets/d/1MkJ73CSl5FnKSnTohHGaQW2Pn8E8METMS1D5C24G4jo/edit //A0A_10630_cat_2
$spreadsheetId = '1MkJ73CSl5FnKSnTohHGaQW2Pn8E8METMS1D5C24G4jo';
$range = 'calc-table-poster!A1:AC';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

$i = 1;
$index = array();
$tempRow = array();
$data_array = array();
$cols = array();
$id = 100;
$last_sku = '';

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
            if (isset($index[$field])) {
                if (is_array($index[$field])) {
                    $index[$field][] = $j++;
                } else {
                    $index[$field] = array($index[$field], $j++);
                }
            } else {
                $index[$field] = $j++;
            }
        }
        dump($index);
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

        if (trim($tempRow[$index['order']]) == '') {
            $i++;
            continue;
        }
        echo '<pre>';
        var_dump('$tempRow');
        var_dump($tempRow);
        echo '</pre>';
        /**
         * order is needed because there are too many variations in spreadsheets
         */
        if (isset($tempRow[$index['order']])) {
            $data['id'] = $tempRow[$index['order']];
            unset($tempRow[$index['order']]);
        } else {
            if ($last_sku != $sku) {
                $id = 100;
            }
            $last_sku = $sku;
            $data['id'] = $id++;
        }

        /**
         * TODO replace with proper audio file url
         */
        $data['audio'] = '<audio src="https://www.w3schools.com/html/horse.mp3" class="audioplay en"></audio>';
        $data['audio_jp'] = '<audio src="https://www.w3schools.com/html/horse.mp3" class="audioplay jp"></audio>';
        $data['audio_de'] = '<audio src="https://www.w3schools.com/html/horse.mp3" class="audioplay jp"></audio>';


        if (!isset($tempRow[$index['sku']])) continue;
        $sku = $tempRow[$index['sku']];
        unset($tempRow[$index['sku']]);

        $data['name'] = $tempRow[$index['name']];
        $data['name_jp'] = $tempRow[$index['name_jp']];
        $data['name_de'] = $tempRow[$index['name_de']];
        $data['source'] = getDataArray('source');
        $data['source_jp'] = getDataArray('source_jp');
        $data['source_de'] = getDataArray('source_de');

        /** no source, then skip */
        /*  if (trim($data['source']) == '' 
        && trim($data['source_jp']) == '' 
        && trim($data['source_de']) == '') {
            $i++;
            continue;
        }*/

        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        $data_array[$sku][] = $data;
    }
    $i++;
}

// This is to sort by id asc, but i think it's simpler to manuplate directly in spreadsheet, because some have no ids but just a comment on specific position, e.g. categories
/* 
foreach ($data_array as $key => $value) {
    if (trim($key) == '') continue;
    usort($data_array[$key], function ($a, $b) {
        return $a['id'] <=> $b['id'];
    });
} */

dump($data_array);


foreach ($data_array as $key => $value) {
    if (trim($key) == '') continue;
    /**
     * TODO set the sku set as folder
     */
    //basename($inputFileName, '.xlsx');
    //$fp = fopen(JPATH_BASE . DS . 'bin' . DS .  'cap' . DS . $toReadSKUSet . DS . $key . '.json', 'w');
    $fp = fopen(JPATH_BASE . DS . 'bin' . DS .  'cap' . DS . $key . '.json', 'w');
    fwrite($fp, json_encode($value, JSON_PRETTY_PRINT));
    fclose($fp);
}



function getDataArray($key)
{

    global $tempRow, $index;

    if (!isset($index[$key])) return '';

    $temp = array();

    if (is_array($index[$key])) {
        foreach ($index[$key] as $value) {
            if (isset($tempRow[$value]))
                $temp[] = $tempRow[$value];
        }
    } else {
        if (isset($tempRow[$index[$key]]))
            $temp[] = $tempRow[$index[$key]];
    }

    /**
     * need to do some preprocessing:
     */
    if (!empty($temp)) {
        $temp = convertSources($temp);
    }

    return $temp;
}
function convertSources($data_sources)
{
    if (is_array($data_sources)) {
        $sources = '';
        foreach ($data_sources as $source) {
            $result = convertSource($source);
            if ($result !== false)
                $sources .= $result;
        }
    } else {
        $result = convertSource($data_sources);
        if ($result !== false)
            $sources = $result;
    }
    return $sources;
}

function convertSource($source)
{
    if (trim($source) == '') return false;
    $icon_saved_folder = '/images/poster/edupack/icon/';
    $link_keywords = array(
        'de.wikipedia' => '24-en-wiki.png',
        'ja.wikipedia' => '24-jp-wiki.png',
        'en.wikipedia' => '24-en-wiki.png',

        /**
         * cats
         */
        //jp
        'konekono-heya' => 'cat/24-jp-cat1.png',
        'cat.benesse.ne.jp' => 'cat/24-jp-cat2.png',
        'play-azlab' =>  '24-jp-cat3.png',

        //en
        'vetstreet' => 'cat/24-en-cat1.png',
        'purina' => 'cat/24-en-cat2.png',
        'petguide' => 'cat/24-en-cat3.png',
        'thesprucepets' => 'cat/24-en-cat4.png',
        'thehappycatsite' => 'cat/24-en-cat5.png',
        'omlet' => 'cat/24-en-cat5.png',
        'catbreedslist' => 'cat/24-en-cat5.png',
        'hillspet' => 'cat/24-en-cat5.png',
        'lykoikitten' => 'cat/24-en-cat5.png',
        'felineliving' => 'cat/24-en-cat5.png',
        'tica' => 'cat/24-en-cat5.png',
        'icatcare' => 'cat/24-en-cat5.png',
        'cat-world' => 'cat/24-en-cat5.png',
        'catownerclub' => 'cat/24-en-cat5.png',
        'showcatsonline' => 'cat/24-en-cat5.png',
        'catster' => 'cat/24-en-cat5.png',

        /**
         * dog
         */
        //'akc' => 'dog/akc.jpg',
        'akc' => 'dog/24-en-dog1.png',
        //'dogtime' => 'dog/dogtime.jpg',
        'dogtime' => 'dog/24-en-dog2.png',
        'petguide' => 'dog/24-en-dog3.png',
        'dogbreedinfo' => 'dog/24-en-dog4.png',
        'mame-shiba-inu.com/in-english' => 'dog/24-en-dog5.png',
        'dog-breeds-expert' => 'dog/24-en-dog5.png',

        //'koinuno-heya' => 'dog/koinuno-heya.jpg',
        'koinuno-heya' => 'dog/24-jp-dog1.png',
        'dogfan' => 'dog/24-jp-dog2.png',
        'mame-shiba-inu.com' => 'dog/24-jp-dog3.png',
        'min-inuzukan' => 'dog/24-jp-dog4.png'
    );
    $use_default_icon = true;
    foreach ($link_keywords as $key => $value) {
        if (strpos($source, $key) !== false) {
            $tempSource = '<a href="' . $source . '" target="_blank"><img width="24" height="24" src="' . $icon_saved_folder . $value . '" /></a> ';
            $use_default_icon = false;
            continue;
        }
    }
    if ($use_default_icon) {
        $tempSource = '<a href="' . $source . '" target="_blank"><img width="24" height="24" src="' . $icon_saved_folder . '24-en-wiki.png" /></a> ';
    }

    return $tempSource;
}
