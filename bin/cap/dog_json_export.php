<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$filename = "000-01 publish records and web relationship - table-dog.csv";
$icon_saved_folder = '/images/poster/edupack/icon/';
$en_link_keywords = array(
    //'akc' => 'dog/akc.jpg',
    'akc' => 'dog/24-en-dog1.png',
    //'dogtime' => 'dog/dogtime.jpg',
    'dogtime' => 'dog/24-en-dog2.png',
    'petguide' => 'dog/24-en-dog3.png',
    'dogbreedinfo' => 'dog/24-en-dog4.png',
    'mame-shiba-inu.com/in-english' => 'dog/24-en-dog5.png',
    'dog-breeds-expert' => 'dog/24-en-dog5.png',
    'en.wikipedia' => '24-en-wiki.png'
);
$jp_link_keywords = array(
    //'koinuno-heya' => 'dog/koinuno-heya.jpg',
    'koinuno-heya' => 'dog/24-jp-dog1.png',
    'dogfan' => 'dog/24-jp-dog2.png',
    'mame-shiba-inu.com' => 'dog/24-jp-dog3.png',
    'min-inuzukan' => 'dog/24-jp-dog4.png',
    'ja.wikipedia' => '24-jp-wiki.png'
);

if (file_exists(dirname(__FILE__) . '/' . $filename)) {

    $file = fopen($filename, "r");
    $i = 0;
    $id = 1;
    $line = array();
    $datas_array = array();
    $with_sku = false;

    while (!feof($file)) {
        $line[$i] = fgetcsv($file);
        $links = array();
        $data_array = array();
        if ($i >= 6) {
            $j = 0;
            $html_en = '';
            $html_jp = '';
            $sku;
            foreach ($line[$i] as $grid) {
                if ($j == 1) { //sku
                    if ($grid == '') {
                        $with_sku = false;
                        break;
                    }
                    //$data_array['sku'] = $grid;
                    $with_sku = true;
                    if (isset($sku) && ($sku !== $grid)) $id = 1;
                    $sku = $grid;
                    echo '<pre>';
                    var_dump("sku");
                    var_dump($grid);
                    echo '</pre>';
                } else if ($j == 2) { //eng name
                    $data_array['name'] = $grid;
                    echo '<pre>';
                    var_dump('name');
                    var_dump($data_array['name']);
                    echo '</pre>';
                } else if ($j == 3) { //eng name
                    $data_array['name_jp'] = $grid;
                    echo '<pre>';
                    var_dump('jp');
                    var_dump($data_array['name_jp']);
                    echo '</pre>';
                } else if ($j > 4) {
                    if (trim($grid) !== '') { // links
                        echo '<pre>';
                        var_dump('$grid after !== \'\'');
                        var_dump($grid);
                        echo '</pre>';

                        if (($j >= 5) && ($j < 10)) { //en links
                            foreach ($en_link_keywords as $key => $value) {
                                if (strpos($grid, $key) !== false) {
                                    $html_en .= '<a href="' . $grid . '" target="_blank"><img width="32" height="32" src="' . $icon_saved_folder . $value . '" /></a> ';
                                }
                            }
                        }else if (($j >= 10) && ($j < 15)) { //jp links
                            foreach ($jp_link_keywords as $key => $value) {
                                if (strpos($grid, $key) !== false) {
                                    $html_jp .= '<a href="' . $grid . '" target="_blank"><img width="32" height="32" src="' . $icon_saved_folder . $value . '" /></a> ';
                                }
                            }
                        }
                    }
                }
                $j++;
            }
            if ($with_sku) {
                $html_jp .= '';
                $html_en .= '';
                $data_array['id'] = $id++;
                $data_array['source1'] = '<div style="line-height: 32px;">' . $html_jp . '</div>';
                $data_array['source2'] = '<div style="line-height: 32px;">' . $html_en . '</div>';
                $data_array['formatted_name'] = "<div>{$data_array['name_jp']}<br />{$data_array['name']}</div>";
                $data_array['audio'] = '<audio src="https://www.w3schools.com/html/horse.mp3" class="audioplay jp"></audio> 
                    <audio src="https://www.w3schools.com/html/horse.mp3" class="audioplay en"></audio> 
                    <audio src="https://www.w3schools.com/html/horse.mp3" class="audioplay"></audio>';
                echo '<pre>';
                var_dump('$html_jp');
                var_dump($html_jp);
                var_dump('$html_en');
                var_dump($html_en);
                echo '</pre>';
                if (!isset($datas_array[$sku])) $datas_array[$sku] = array();
                $datas_array[$sku][] = $data_array;
            }
        }
        $i++;
    }
    echo '<pre>';
    var_dump('json_encode($datas_array)');
    echo json_encode($datas_array, JSON_PRETTY_PRINT);
    echo '</pre>';

    foreach ($datas_array as $key => $value) {
        $fp = fopen($key . '.json', 'w');
        fwrite($fp, json_encode($value, JSON_PRETTY_PRINT));
        fclose($fp);
    }
}
