<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {

    $skus = ["P12003", "P12004", "P12005"];

    $currentSkuPage = $skus[0];
    if (isset($_POST['sku']) && in_array($_POST['sku'], $skus)) {
        $currentSkuPage = $_POST['sku'];
    }

    /**
     * TODO alias inside sku code 
     */
    $sku_alias = '-dog';
    $type = 'edupack';
?>
    <ul class="pages">
        <?php $i = 1;
        foreach ($skus as $sku) {  ?>
            <li class="<?php echo $currentSkuPage == $sku ? 'selected' : ''; ?>" data-type="<?= $type ?>" data-sku="<?php echo $sku ?>" data-page=""><a href="#"><?php echo $i; ?></a></li>
        <?php $i++;
        } ?>
    </ul>
    <select class="locale_selector">
        <option value="all"><?php echo JText::sprintf('LANG_ALL'); ?></option>
        <option value="en-GB"><?php echo JText::sprintf('LANG_EN'); ?></option>
        <option value="ja-JP"><?php echo JText::sprintf('LANG_JP'); ?></option>
        <option value="de-DE"><?php echo JText::sprintf('LANG_DE'); ?></option>
    </select>
    <div class="clearfix"></div>
    <div class="row interactive_table">
        <div class="col-sm-6">
            <div class="image-map-container">
                <?php foreach ($skus as $sku) {  ?>
                    <img class="lazyload <?= $type . $sku ?>" data-src="/images/audio_poster/<?= $sku . $sku_alias ?>-de1-borderx.jpg" usemap="#image-map<?= $type . $sku ?>" />
                <?php } ?>
                <div class="map-selector">&nbsp;</div>
            </div>
            <p>
                <map style="<?php echo $_POST['sku'] == $skus[0] ? '' : 'display:none;'; ?>" id="image-map<?= $type . $skus[0] ?>" name="image-map<?= $type . $skus[0] ?>">
                    <area shape="rect" coords="21, 93, 232, 296" />
                    <area shape="rect" coords="203, 189, 329, 368" />
                    <area shape="rect" coords="328, 76, 475, 231" />
                    <area shape="rect" coords="489, 127, 583, 214" />
                    <area shape="rect" coords="614, 77, 769, 219" />
                    <area shape="rect" coords="772, 82, 922, 217" />
                    <area shape="rect" coords="938, 86, 1041, 218" />
                    <area shape="rect" coords="354, 240, 462, 363" />
                    <area shape="rect" coords="525, 224, 654, 356" />
                    <area shape="rect" coords="668, 227, 790, 363" />
                    <area shape="rect" coords="808, 226, 924, 357" />
                    <area shape="rect" coords="942, 239, 1055, 357" />
                    <area shape="rect" coords="25, 371, 208, 528" />
                    <area shape="rect" coords="243, 375, 459, 533" />
                    <area shape="rect" coords="501, 362, 659, 499" />
                    <area shape="rect" coords="687, 386, 779, 497" />
                    <area shape="rect" coords="814, 370, 900, 500" />
                    <area shape="rect" coords="936, 381, 1058, 500" />
                    <area shape="rect" coords="159, 544, 263, 639" />
                    <area shape="rect" coords="361, 546, 434, 633" />
                    <area shape="rect" coords="501, 507, 642, 645" />
                    <area shape="rect" coords="704, 552, 810, 636" />
                    <area shape="rect" coords="904, 536, 1056, 645" />
                    <area shape="rect" coords="34, 614, 150, 775" />
                    <area shape="rect" coords="180, 666, 300, 774" />
                    <area shape="rect" coords="309, 635, 479, 774" />
                    <area shape="rect" coords="499, 650, 645, 779" />
                    <area shape="rect" coords="648, 679, 746, 773" />
                    <area shape="rect" coords="780, 664, 938, 773" />
                    <area shape="rect" coords="951, 653, 1060, 778" />
                    <area shape="rect" coords="12, 886, 215, 1071" />
                    <area shape="rect" coords="217, 908, 382, 1044" />
                    <area shape="rect" coords="384, 906, 498, 1003" />
                    <area shape="rect" coords="502, 905, 662, 1002" />
                    <area shape="rect" coords="711, 909, 817, 1027" />
                    <area shape="rect" coords="825, 872, 1056, 1044" />
                    <area shape="rect" coords="14, 1081, 140, 1159" />
                    <area shape="rect" coords="144, 1074, 254, 1156" />
                    <area shape="rect" coords="327, 1078, 473, 1155" />
                    <area shape="rect" coords="491, 1004, 707, 1175" />
                    <area shape="rect" coords="731, 1045, 933, 1248" />
                    <area shape="rect" coords="934, 1064, 1058, 1271" />
                    <area shape="rect" coords="13, 1163, 265, 1377" />
                    <area shape="rect" coords="267, 1210, 421, 1362" />
                    <area shape="rect" coords="422, 1174, 608, 1338" />
                    <area shape="rect" coords="611, 1185, 726, 1338" />
                    <area shape="rect" coords="802, 1247, 922, 1399" />
                    <area shape="rect" coords="930, 1274, 1041, 1380" />
                    <area shape="rect" coords="11, 1391, 185, 1551" />
                    <area shape="rect" coords="188, 1377, 351, 1554" />
                    <area shape="rect" coords="354, 1366, 583, 1555" />
                    <area shape="rect" coords="593, 1341, 754, 1554" />
                    <area shape="rect" coords="753, 1410, 895, 1553" />
                    <area shape="rect" coords="901, 1401, 1049, 1553" />
                </map>
                <map style="<?php echo $_POST['sku'] == $skus[1] ? '' : 'display:none;'; ?>" id="image-map<?= $type . $skus[1] ?>" name="image-map<?= $type . $skus[1] ?>">
                    <area shape="rect" coords="25, 50, 193, 217" />
                    <area shape="rect" coords="213, 61, 340, 222" />
                    <area shape="rect" coords="424, 90, 518, 198" />
                    <area shape="rect" coords="560, 87, 691, 200" />
                    <area shape="rect" coords="720, 65, 921, 223" />
                    <area shape="rect" coords="904, 82, 1010, 215" />
                    <area shape="rect" coords="16, 218, 218, 378" />
                    <area shape="rect" coords="238, 236, 408, 378" />
                    <area shape="rect" coords="413, 228, 548, 386" />
                    <area shape="rect" coords="564, 235, 689, 396" />
                    <area shape="rect" coords="705, 242, 849, 396" />
                    <area shape="rect" coords="864, 215, 1053, 373" />
                    <area shape="rect" coords="10, 372, 223, 541" />
                    <area shape="rect" coords="208, 397, 388, 539" />
                    <area shape="rect" coords="385, 410, 508, 540" />
                    <area shape="rect" coords="519, 410, 781, 555" />
                    <area shape="rect" coords="766, 450, 886, 532" />
                    <area shape="rect" coords="899, 376, 1055, 522" />
                    <area shape="rect" coords="18, 552, 189, 718" />
                    <area shape="rect" coords="194, 551, 351, 702" />
                    <area shape="rect" coords="355, 547, 481, 695" />
                    <area shape="rect" coords="506, 567, 688, 690" />
                    <area shape="rect" coords="713, 563, 839, 701" />
                    <area shape="rect" coords="869, 533, 1051, 697" />
                    <area shape="rect" coords="10, 803, 156, 946" />
                    <area shape="rect" coords="196, 812, 324, 951" />
                    <area shape="rect" coords="349, 798, 506, 942" />
                    <area shape="rect" coords="540, 807, 680, 946" />
                    <area shape="rect" coords="709, 796, 843, 940" />
                    <area shape="rect" coords="898, 820, 1036, 936" />
                    <area shape="rect" coords="11, 980, 119, 1106" />
                    <area shape="rect" coords="204, 978, 335, 1105" />
                    <area shape="rect" coords="358, 978, 493, 1097" />
                    <area shape="rect" coords="506, 970, 625, 1093" />
                    <area shape="rect" coords="685, 948, 846, 1100" />
                    <area shape="rect" coords="901, 936, 1057, 1098" />
                    <area shape="rect" coords="38, 1113, 199, 1246" />
                    <area shape="rect" coords="214, 1113, 366, 1245" />
                    <area shape="rect" coords="370, 1116, 549, 1250" />
                    <area shape="rect" coords="565, 1096, 733, 1246" />
                    <area shape="rect" coords="760, 1103, 891, 1243" />
                    <area shape="rect" coords="915, 1105, 1046, 1248" />
                    <area shape="rect" coords="20, 1263, 165, 1403" />
                    <area shape="rect" coords="179, 1278, 290, 1396" />
                    <area shape="rect" coords="316, 1268, 465, 1380" />
                    <area shape="rect" coords="469, 1276, 613, 1378" />
                    <area shape="rect" coords="621, 1270, 743, 1381" />
                    <area shape="rect" coords="761, 1262, 885, 1390" />
                    <area shape="rect" coords="924, 1263, 1044, 1378" />
                    <area shape="rect" coords="19, 1420, 156, 1555" />
                    <area shape="rect" coords="318, 1406, 450, 1555" />
                    <area shape="rect" coords="458, 1451, 579, 1550" />
                    <area shape="rect" coords="671, 1406, 873, 1552" />
                    <area shape="rect" coords="893, 1402, 1050, 1553" />
                </map>
                <map style="<?php echo $_POST['sku'] == $skus[2] ? '' : 'display:none;'; ?>" id="image-map<?= $type . $skus[2] ?>" name="image-map<?= $type . $skus[2] ?>">
                    <area shape="rect" coords="26, 86, 128, 206" />
                    <area shape="rect" coords="150, 63, 299, 206" />
                    <area shape="rect" coords="306, 60, 443, 208" />
                    <area shape="rect" coords="444, 51, 629, 220" />
                    <area shape="rect" coords="635, 52, 874, 248" />
                    <area shape="rect" coords="871, 60, 1039, 227" />
                    <area shape="rect" coords="13, 256, 118, 391" />
                    <area shape="rect" coords="155, 243, 336, 382" />
                    <area shape="rect" coords="364, 233, 538, 398" />
                    <area shape="rect" coords="568, 250, 701, 366" />
                    <area shape="rect" coords="744, 238, 838, 368" />
                    <area shape="rect" coords="894, 241, 1024, 367" />
                    <area shape="rect" coords="16, 400, 138, 528" />
                    <area shape="rect" coords="158, 378, 280, 528" />
                    <area shape="rect" coords="294, 408, 458, 561" />
                    <area shape="rect" coords="460, 443, 541, 561" />
                    <area shape="rect" coords="544, 383, 800, 560" />
                    <area shape="rect" coords="798, 418, 899, 533" />
                    <area shape="rect" coords="894, 375, 1060, 531" />
                    <area shape="rect" coords="16, 655, 181, 793" />
                    <area shape="rect" coords="175, 636, 354, 807" />
                    <area shape="rect" coords="351, 647, 538, 808" />
                    <area shape="rect" coords="529, 637, 720, 815" />
                    <area shape="rect" coords="706, 633, 858, 818" />
                    <area shape="rect" coords="860, 637, 1049, 820" />
                    <area shape="rect" coords="44, 831, 201, 986" />
                    <area shape="rect" coords="219, 872, 369, 967" />
                    <area shape="rect" coords="396, 808, 545, 1000" />
                    <area shape="rect" coords="565, 841, 769, 1027" />
                    <area shape="rect" coords="741, 865, 938, 1040" />
                    <area shape="rect" coords="921, 856, 1038, 1035" />
                    <area shape="rect" coords="11, 996, 224, 1175" />
                    <area shape="rect" coords="216, 1000, 430, 1176" />
                    <area shape="rect" coords="404, 1002, 593, 1176" />
                    <area shape="rect" coords="604, 1061, 725, 1153" />
                    <area shape="rect" coords="759, 1073, 879, 1177" />
                    <area shape="rect" coords="895, 1061, 1041, 1183" />
                    <area shape="rect" coords="23, 1287, 119, 1395" />
                    <area shape="rect" coords="136, 1303, 228, 1393" />
                    <area shape="rect" coords="248, 1287, 354, 1392" />
                    <area shape="rect" coords="361, 1306, 450, 1395" />
                    <area shape="rect" coords="469, 1317, 539, 1395" />
                    <area shape="rect" coords="564, 1296, 641, 1381" />
                    <area shape="rect" coords="650, 1306, 744, 1382" />
                    <area shape="rect" coords="759, 1298, 866, 1387" />
                    <area shape="rect" coords="868, 1316, 949, 1393" />
                    <area shape="rect" coords="963, 1291, 1048, 1390" />
                    <area shape="rect" coords="24, 1407, 163, 1513" />
                    <area shape="rect" coords="189, 1405, 319, 1517" />
                    <area shape="rect" coords="328, 1427, 423, 1523" />
                    <area shape="rect" coords="438, 1435, 550, 1523" />
                    <area shape="rect" coords="551, 1435, 631, 1525" />
                    <area shape="rect" coords="635, 1417, 748, 1516" />
                    <area shape="rect" coords="753, 1416, 858, 1523" />
                    <area shape="rect" coords="864, 1416, 945, 1515" />
                    <area shape="rect" coords="946, 1422, 1054, 1522" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>