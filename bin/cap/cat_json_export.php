<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$filename = "000-01 sensaihonya publish records and web relationship - table-cat.csv";
$icon_saved_folder = '/images/poster/edupack/icon/cat/';
$link_keywords = array(
    //jp
    'ja.wikipedia' => '../24-jp-wiki.png',
    'konekono-heya' => '24-jp-cat1.png',
    'cat.benesse.ne.jp' => '24-jp-cat2.png',
    'play-azlab' =>  '24-jp-cat3.png',

    //en
    'en.wikipedia' => '../24-en-wiki.png',
    'vetstreet' => '24-en-cat1.png',
    'purina' => '24-en-cat2.png',
    'petguide' => '24-en-cat3.png',
    'thesprucepets' => '24-en-cat4.png',
    'thehappycatsite' => '24-en-cat5.png',
    'omlet' => '24-en-cat5.png',
    'catbreedslist' => '24-en-cat5.png',
    'hillspet' => '24-en-cat5.png',
    'lykoikitten' => '24-en-cat5.png',
    'felineliving' => '24-en-cat5.png',
    'tica' => '24-en-cat5.png',
    'icatcare' => '24-en-cat5.png',
    'cat-world' => '24-en-cat5.png',
    'catownerclub' => '24-en-cat5.png',
    'showcatsonline' => '24-en-cat5.png',
    'catster' => '24-en-cat5.png'
);
$col = array(
    'sku' => array(1),
    'en_name' => array(3),
    'jp_name' => array(4),
    'en_links' => array(5, 6, 7, 8, 9,10),
    'jp_links' => array(11, 12,13,14),
    'handbook_page' => array(17),
    'handbook_order' => array(18)
);
$init_row = 4;

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
        if ($i >= $init_row) {
            $j = 0;
            $html_en = '';
            $html_jp = '';
            $sku;
            foreach ($line[$i] as $grid) {
                if (in_array($j, $col['sku'])) { //sku
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
                } else if (in_array($j, $col['en_name'])) { //eng name
                    $data_array['name'] = $grid;
                    echo '<pre>';
                    var_dump('name');
                    var_dump($data_array['name']);
                    echo '</pre>';
                } else if (in_array($j, $col['jp_name'])) { //jp name
                    $data_array['name_jp'] = $grid;
                    echo '<pre>';
                    var_dump('jp');
                    var_dump($data_array['name_jp']);
                    echo '</pre>';
                } else if (in_array($j, $col['jp_links']) || in_array($j, $col['en_links'])) {
                    if (trim($grid) !== '') { // links
                        if (in_array($j, $col['en_links'])) { //en links
                            echo '<pre>';
                            var_dump('en links');
                            var_dump($grid);
                            echo '</pre>';
                            foreach ($link_keywords as $key => $value) {
                                if (strpos($grid, $key) !== false) {
                                    $html_en .= '<a href="' . $grid . '" target="_blank"><img width="24" height="24" src="' . $icon_saved_folder . $value . '" /></a> ';
                                }
                            }
                        }else if (in_array($j, $col['jp_links'])) { //jp links
                            echo '<pre>';
                            var_dump('jp links');
                            var_dump($grid);
                            echo '</pre>';
                            foreach ($link_keywords as $key => $value) {
                                if (strpos($grid, $key) !== false) {
                                    $html_jp .= '<a href="' . $grid . '" target="_blank"><img width="24" height="24" src="' . $icon_saved_folder . $value . '" /></a> ';
                                }
                            }
                        }
                    }
                }else if (in_array($j, $col['handbook_page'])) { //handbook_page
                    $data_array['handbook_page'] = $grid;
                    echo '<pre>';
                    var_dump('handbook_page');
                    var_dump($data_array['handbook_page']);
                    echo '</pre>';
                } else if (in_array($j, $col['handbook_order'])) { //handbook_order
                    $data_array['handbook_order'] = $grid;
                    echo '<pre>';
                    var_dump('handbook_order');
                    var_dump($data_array['handbook_order']);
                    echo '</pre>';
                } 
                $j++;
            }
            if ($with_sku) {
                $html_jp .= '';
                $html_en .= '';
                $data_array['id'] = $id++;
                $data_array['name'] = "<div>{$data_array['name']}</div>";
                $data_array['name_jp'] = "<div>{$data_array['name_jp']}</div>";
                $data_array['audio'] = '<audio src="https://www.w3schools.com/html/horse.mp3" class="audioplay en"></audio>';
                $data_array['audio_jp'] = '<audio src="https://www.w3schools.com/html/horse.mp3" class="audioplay jp"></audio>';
                $data_array['source'] = '<div>' . $html_en . '</div>';
                $data_array['source_jp'] = '<div>' . $html_jp . '</div>';
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
} else{
    echo $filename.' does not exist.';
}