<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$filename = "000-01 publish records and web relationship - table-cat.csv";
$icon_saved_folder = '/images/poster/edupack/favicon/cat/';
$link_keywords = array(
    'cat.benesse.ne.jp' => 'cat.benesse.png',
    'purina' => 'purina.png',
    'vetstreet' => 'vetstreet.png',
    'konekono-heya' => 'konekono-heya.png',
    'thesprucepets' => 'thesprucepets.png',
    'petguide' => 'petguide.png',
    'omlet' => 'omlet.png',
    'catbreedslist' => 'catbreedslist.png',
    'hillspet' => 'hillspet.png',
    'lykoikitten' => 'lykoikitten.jpg',
    'felineliving' => 'felineliving.png',
    'tica' => 'tica.png',
    'icatcare' => 'icatcare.png',
    'cat-world' => 'cat-world.png',
    'catownerclub' => 'catownerclub.png',
    'showcatsonline' => 'showcatsonline.png',
    'thehappycatsite' => 'thehappycatsite.png',
    'catster' => 'catster.png'
);
$col = array(
    'sku' => array(1),
    'en_name' => array(3),
    'jp_name' => array(4),
    'en_links' => array(5, 6, 7, 8, 9,10),
    'jp_links' => array(11, 12,13,14)
);
$init_row = 4;

$wiki_icon = '<i class="fab fa-wikipedia-w"></i>';

$audio_icon = '<audio src="https://www.w3schools.com/html/horse.mp3" class="audioplay"></audio>';

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
            $html_en = '<p>EN: ';
            $html_jp = '<p>JP: ';
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
                        if ($j==$col['en_links'][0]) { //en wiki
                            echo '<pre>';
                            var_dump('en wiki');
                            var_dump($grid);
                            echo '</pre>';
                            $html_en .= '<a href="' . $grid . '" target="_blank">' . $wiki_icon . '</a> ';
                        } else if (in_array($j, $col['en_links'])) { //en links
                            echo '<pre>';
                            var_dump('en links');
                            var_dump($grid);
                            echo '</pre>';
                            foreach ($link_keywords as $key => $value) {
                                if (strpos($grid, $key) !== false) {
                                    $html_en .= '<a href="' . $grid . '" target="_blank"><img width="32" height="32" src="' . $icon_saved_folder . $value . '" /></a> ';
                                }
                            }
                        } else if ($j==$col['jp_links'][0]) { //jp wiki
                            echo '<pre>';
                            var_dump('jp wiki');
                            var_dump($grid);
                            echo '</pre>';
                            $html_jp .= '<a href="' . $grid . '" target="_blank">' . $wiki_icon . '</a> ';
                        } else if (in_array($j, $col['jp_links'])) { //jp links
                            echo '<pre>';
                            var_dump('jp links');
                            var_dump($grid);
                            echo '</pre>';
                            foreach ($link_keywords as $key => $value) {
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
                $html_jp .= '</p>';
                $html_en .= '</p>';
                $data_array['id'] = $id++;
                $data_array['source1'] = '<div style="line-height: 32px;">' . $html_jp . $html_en . '</div>';
                $data_array['audio'] = $audio_icon;
                echo '<pre>';
                var_dump('data_array source1');
                echo $data_array['source1'];
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