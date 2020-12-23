<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$filename = "000-01 publish records and web relationship - table-dog.csv";
$icon_saved_folder = '/images/poster/edupack/favicon/';
$en_link_keywords = array(
    'en.wikipedia' => 'wiki',
    'akc' => 'dog/akc.jpg',
    'dogtime' => 'dog/dogtime.jpg',
    'petguide' => 'dog/petguide.png',
    'dogbreedinfo' => 'dog/dogbreedinfo.png',
    'mame-shiba-inu.com/in-english' => 'dog/mame-shiba-inu.png',
    'dog-breeds-expert' => 'dog/dog-breeds-expert.png'
);
$jp_link_keywords = array(
    'jp.wikipedia' => 'wiki',
    'koinuno-heya' => 'dog/koinuno-heya.jpg',
    'dogfan' => 'dog/dogfan.jpg',
    'mame-shiba-inu.com' => 'dog/mame-shiba-inu.png',
    'min-inuzukan' => 'dog/min-inuzukan.jpg'
);

$wiki_icon = '<i class="fab fa-wikipedia-w"></i>';

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
            $html_en = '<p>EN: ';
            $html_jp = '<p>JP: ';
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

                        if ($j == 5) { //en wiki
                            $html_en .= '<a href="' . $grid . '" target="_blank">' . $wiki_icon . '</a> ';
                        } else if (($j > 5) && ($j < 10)) { //en links
                            foreach ($en_link_keywords as $key => $value) {
                                if (strpos($grid, $key) !== false) {
                                    $html_en .= '<a href="' . $grid . '" target="_blank"><img width="32" height="32" src="' . $icon_saved_folder . $value . '" /></a> ';
                                }
                            }
                        } else if ($j == 10) { //jp wiki
                            $html_jp .= '<a href="' . $grid . '" target="_blank">' . $wiki_icon . '</a> ';
                        } else if (($j > 10) && ($j < 15)) { //jp links
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
                $html_jp .= '</p>';
                $html_en .= '</p>';
                $data_array['id'] = $id++;
                $data_array['source1'] = '<div style="line-height: 32px;">' . $html_jp . $html_en . '</div>';
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

    foreach($datas_array as $key => $value){
        $fp = fopen($key.'.json', 'w');
        fwrite($fp, json_encode($value, JSON_PRETTY_PRINT));
        fclose($fp);
    }
}
