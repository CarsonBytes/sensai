<?php
define('_JEXEC', 1);

require_once(dirname(__DIR__) . '/init.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Todo auto read spreadsheet by SKU
 */
//$toReadSKUSet = 'A08_10550_ABC';
//$toReadSKUSet = 'A08_10600_animal';
//$toReadSKUSet = 'A08_10610_body';
//$toReadSKUSet = 'A08_10590_farm';
//$toReadSKUSet = 'A08_10580_veggie';
//$toReadSKUSet = 'A08_10570_dino';
//$toReadSKUSet = 'A08_10560_123';
//$toReadSKUSet = 'A0A_10630_cat_2';
//$toReadSKUSet = 'A0B_10610_dog_2';
//$toReadSKUSet = 'P12001-cat';
$toReadSKUSet = 'P12003-dog';
$inputFileType = 'Xlsx';
$inputFileName = './Object Table Data and Audio Clips/' . $toReadSKUSet . '.' . $inputFileType;
$sheetname = 'calc-table-poster';
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

/**  Create a new Reader of the type defined in $inputFileType  **/
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
/**  Advise the Reader that we only want to load cell data  **/
$reader->setReadDataOnly(true);
$reader->setReadEmptyCells(false);
/**  Load $inputFileName to a Spreadsheet Object  **/
$spreadsheet = $reader->load($inputFileName);

//$worksheet = $spreadsheet->getActiveSheet();
$worksheet = $spreadsheet->getSheetByName($sheetname);

// Get the highest row and column numbers referenced in the worksheet
$highestRow = $worksheet->getHighestRow(); // e.g. 10
$highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

/* 
echo '<table>' . "\n";
for ($row = 1; $row <= $highestRow; ++$row) {
    echo '<tr>' . PHP_EOL;
    for ($col = 1; $col <= $highestColumnIndex; ++$col) {
        $value = $worksheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();
        echo '<td>' . $value . '</td>' . PHP_EOL;
    }
    echo '</tr>' . PHP_EOL;
}
echo '</table>' . PHP_EOL; */

$data_array = array();
$cols = array();
$id = 1;
$last_sku = '';
for ($row = 1; $row <= $highestRow; ++$row) {
    $data = array();
    for ($col = 1; $col <= $highestColumnIndex; ++$col) {
        $value = $worksheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();
        if ($row == 1) {
            $cols[$col] = trim($value);
        } elseif ($row >= 4) {
            if ($cols[$col] != '') {
                if (trim($value) == '') continue;
                if (isset($data[$cols[$col]])) {
                    if (is_array($data[$cols[$col]])) {
                        $data[$cols[$col]][] = $value;
                    } else {
                        $data[$cols[$col]] = array($data[$cols[$col]], $value);
                        //if ($cols[$col] == 'source') dump($data[$cols[$col]]);
                    }
                } else {
                    $data[$cols[$col]] = $value;
                    //if ($cols[$col] == 'source') dump($data[$cols[$col]]);
                }
            }
        }
    }
    if ($row >= 4) {
        if (!isset($data['sku'])) continue;
        $sku = $data['sku'];
        unset($data['sku']);

        if (isset($data['order'])) {
            $data['id'] = $data['order'];
            unset($data['order']);
        } else {
            if ($last_sku != $sku) {
                $id = 1;
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

        /* echo '<pre>';
        var_dump($data);
        echo '</pre>'; */
        if (isset($data['source'])) {
            $data['source'] = convertSources($data['source']);
        }
        if (isset($data['source_jp'])) {
            $data['source_jp'] = convertSources($data['source_jp']);
        }
        if (isset($data['source_de'])) {
            $data['source_de'] = convertSources($data['source_de']);
        }

        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        $data_array[$sku][] = $data;
    }
}

usort($data_array[$sku], function ($a, $b) {
    return $a['id'] <=> $b['id'];
});


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


function convertSources($data_sources)
{
    global $link_keywords, $icon_saved_folder;
    $sources = '';
    if (is_array($data_sources)) {
        foreach ($data_sources as $source) {
            $use_default_icon = true;
            foreach ($link_keywords as $key => $value) {
                if (strpos($source, $key) !== false) {
                    $sources .= '<a href="' . $source . '" target="_blank"><img width="24" height="24" src="' . $icon_saved_folder . $value . '" /></a> ';
                    $use_default_icon = false;
                    continue;
                }
            }
            if ($use_default_icon) {
                $sources .= '<a href="' . $source . '" target="_blank"><img width="24" height="24" src="' . $icon_saved_folder . '24-en-wiki.png" /></a> ';
            }
        }
    } else {
        $use_default_icon = true;
        foreach ($link_keywords as $key => $value) {
            if (strpos($data_sources, $key) !== false) {
                $sources .= '<a href="' . $data_sources . '" target="_blank"><img width="24" height="24" src="' . $icon_saved_folder . $value . '" /></a>';
                $use_default_icon = false;
                continue;
            }
        }
        if ($use_default_icon) {
            $sources .= '<a href="' . $data_sources . '" target="_blank"><img width="24" height="24" src="' . $icon_saved_folder . '24-en-wiki.png" /></a> ';
        }
    }
    return $sources;
}
