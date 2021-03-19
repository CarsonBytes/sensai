<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $skus = ['P12003', 'P12004', 'P12005'];

    $currentSkuPage = $skus[0];
    if (isset($_POST['sku']) && in_array($_POST['sku'], $skus)) {
        $currentSkuPage = $_POST['sku'];
    }


    $type = 'edupack';

?>
    <ul class="pages">
        <?php $i = 1;
        foreach ($skus as $sku) {  ?>
            <li class="<?php echo $currentSkuPage == $sku ? 'selected' : ''; ?>" data-type="<?= $type ?>" data-sku="<?php echo $sku ?>" data-page="""><a href=" #"><?php echo $i; ?></a></li>
        <?php $i++;
        } ?>
    </ul>
    <select class="locale_selector">
        <option value="all"><?php echo JText::sprintf('LANG_ALL'); ?></option>
        <option value="en-GB"><?php echo JText::sprintf('LANG_EN'); ?></option>
        <option value="ja-JP"><?php echo JText::sprintf('LANG_JP'); ?></option>
    </select>
    <div class="clearfix"></div>
    <div class="row interactive_table">
        <div class="col-sm-12 col-md-4">
            <div class="image-map-container">
                <?php foreach ($skus as $sku) {  ?>
                    <img class="lazyload <?= $type . $sku ?>" data-src="/images/poster/edupack/dog/<?= $sku ?>_1500.jpg" usemap="#image-map<?= $type . $sku ?>" />
                <?php } ?>
                <div class="map-selector">&nbsp;</div>
            </div>
            <p>
                <?php $i = 0; ?>
                <map style="<?php echo $_POST['sku'] == $skus[$i] ? '' : 'display:none;'; ?>" id="image-map<?= $type . $skus[$i] ?>" name="image-map<?= $type . $skus[$i] ?>">
                    <area shape="rect" coords="13, 90, 195, 294" />
                    <area shape="rect" coords="323, 82, 446, 218" />
                    <area shape="rect" coords="462, 126, 566, 219" />
                    <area shape="rect" coords="594, 76, 741, 217" />
                    <area shape="rect" coords="744, 80, 889, 218" />
                    <area shape="rect" coords="905, 83, 993, 233" />
                    <area shape="rect" coords="197, 185, 320, 357" />
                    <area shape="rect" coords="336, 233, 494, 343" />
                    <area shape="rect" coords="510, 220, 626, 354" />
                    <area shape="rect" coords="644, 219, 757, 361" />
                    <area shape="rect" coords="776, 226, 887, 362" />
                    <area shape="rect" coords="906, 239, 1017, 363" />
                    <area shape="rect" coords="14, 349, 196, 519" />
                    <area shape="rect" coords="232, 357, 445, 517" />
                    <area shape="rect" coords="481, 359, 636, 492" />
                    <area shape="rect" coords="656, 371, 756, 492" />
                    <area shape="rect" coords="771, 367, 882, 506" />
                    <area shape="rect" coords="907, 366, 1013, 503" />
                    <area shape="rect" coords="156, 519, 310, 596" />
                    <area shape="rect" coords="352, 521, 466, 613" />
                    <area shape="rect" coords="484, 495, 670, 611" />
                    <area shape="rect" coords="673, 517, 842, 614" />
                    <area shape="rect" coords="844, 514, 1014, 618" />
                    <area shape="rect" coords="14, 596, 163, 769" />
                    <area shape="rect" coords="176, 641, 290, 773" />
                    <area shape="rect" coords="302, 617, 462, 773" />
                    <area shape="rect" coords="471, 623, 600, 773" />
                    <area shape="rect" coords="603, 664, 745, 772" />
                    <area shape="rect" coords="755, 641, 900, 768" />
                    <area shape="rect" coords="906, 625, 1015, 773" />
                    <area shape="rect" coords="15, 845, 205, 1033" />
                    <area shape="rect" coords="210, 867, 366, 1016" />
                    <area shape="rect" coords="368, 863, 476, 1016" />
                    <area shape="rect" coords="485, 876, 637, 982" />
                    <area shape="rect" coords="676, 877, 787, 1002" />
                    <area shape="rect" coords="794, 834, 1012, 1007" />
                    <area shape="rect" coords="14, 1041, 134, 1138" />
                    <area shape="rect" coords="146, 1037, 246, 1135" />
                    <area shape="rect" coords="316, 1039, 465, 1137" />
                    <area shape="rect" coords="479, 984, 675, 1133" />
                    <area shape="rect" coords="746, 1011, 898, 1195" />
                    <area shape="rect" coords="901, 1011, 1017, 1217" />
                    <area shape="rect" coords="23, 1144, 263, 1321" />
                    <area shape="rect" coords="263, 1169, 403, 1304" />
                    <area shape="rect" coords="407, 1140, 579, 1290" />
                    <area shape="rect" coords="583, 1137, 739, 1291" />
                    <area shape="rect" coords="759, 1199, 886, 1353" />
                    <area shape="rect" coords="887, 1224, 1016, 1349" />
                    <area shape="rect" coords="9, 1339, 176, 1490" />
                    <area shape="rect" coords="180, 1320, 343, 1493" />
                    <area shape="rect" coords="344, 1310, 562, 1494" />
                    <area shape="rect" coords="566, 1291, 720, 1494" />
                    <area shape="rect" coords="723, 1350, 860, 1493" />
                    <area shape="rect" coords="862, 1359, 1012, 1496" />
                </map>
                <?php $i = 1; ?>
                <map style="<?php echo $_POST['sku'] == $skus[$i] ? '' : 'display:none;'; ?>" id="image-map<?= $type . $skus[$i] ?>" name="image-map<?= $type . $skus[$i] ?>">
                    <area shape="rect" coords="21, 50, 179, 210" />
                    <area shape="rect" coords="203, 58, 382, 208" />
                    <area shape="rect" coords="383, 77, 520, 215" />
                    <area shape="rect" coords="533, 75, 675, 219" />
                    <area shape="rect" coords="679, 56, 880, 208" />
                    <area shape="rect" coords="882, 64, 1006, 206" />
                    <area shape="rect" coords="17, 213, 208, 366" />
                    <area shape="rect" coords="224, 230, 395, 372" />
                    <area shape="rect" coords="400, 221, 528, 402" />
                    <area shape="rect" coords="540, 222, 664, 400" />
                    <area shape="rect" coords="666, 235, 819, 385" />
                    <area shape="rect" coords="835, 210, 1012, 368" />
                    <area shape="rect" coords="22, 371, 211, 524" />
                    <area shape="rect" coords="215, 376, 381, 524" />
                    <area shape="rect" coords="379, 404, 519, 516" />
                    <area shape="rect" coords="520, 402, 737, 540" />
                    <area shape="rect" coords="741, 423, 854, 547" />
                    <area shape="rect" coords="864, 369, 1014, 514" />
                    <area shape="rect" coords="17, 532, 174, 690" />
                    <area shape="rect" coords="179, 527, 338, 693" />
                    <area shape="rect" coords="342, 525, 461, 695" />
                    <area shape="rect" coords="462, 543, 668, 694" />
                    <area shape="rect" coords="679, 548, 846, 691" />
                    <area shape="rect" coords="858, 515, 1013, 690" />
                    <area shape="rect" coords="18, 775, 154, 931" />
                    <area shape="rect" coords="182, 783, 317, 931" />
                    <area shape="rect" coords="333, 768, 484, 934" />
                    <area shape="rect" coords="518, 777, 657, 929" />
                    <area shape="rect" coords="684, 763, 847, 908" />
                    <area shape="rect" coords="863, 779, 999, 904" />
                    <area shape="rect" coords="16, 936, 180, 1063" />
                    <area shape="rect" coords="184, 937, 320, 1064" />
                    <area shape="rect" coords="340, 945, 482, 1061" />
                    <area shape="rect" coords="487, 928, 661, 1047" />
                    <area shape="rect" coords="665, 914, 851, 1057" />
                    <area shape="rect" coords="865, 906, 1012, 1053" />
                    <area shape="rect" coords="16, 1064, 190, 1217" />
                    <area shape="rect" coords="208, 1075, 345, 1219" />
                    <area shape="rect" coords="367, 1069, 530, 1221" />
                    <area shape="rect" coords="552, 1051, 703, 1223" />
                    <area shape="rect" coords="734, 1061, 854, 1218" />
                    <area shape="rect" coords="889, 1066, 1010, 1213" />
                    <area shape="rect" coords="15, 1217, 159, 1346" />
                    <area shape="rect" coords="165, 1223, 295, 1351" />
                    <area shape="rect" coords="317, 1220, 449, 1351" />
                    <area shape="rect" coords="451, 1227, 585, 1353" />
                    <area shape="rect" coords="598, 1226, 715, 1351" />
                    <area shape="rect" coords="729, 1221, 846, 1353" />
                    <area shape="rect" coords="886, 1218, 1013, 1343" />
                    <area shape="rect" coords="20, 1363, 253, 1498" />
                    <area shape="rect" coords="254, 1354, 440, 1497" />
                    <area shape="rect" coords="444, 1386, 603, 1487" />
                    <area shape="rect" coords="608, 1355, 845, 1494" />
                    <area shape="rect" coords="862, 1345, 1011, 1491" />
                </map>
                <?php $i = 2; ?>
                <map style="<?php echo $_POST['sku'] == $skus[$i] ? '' : 'display:none;'; ?>" id="image-map<?= $type . $skus[$i] ?>" name="image-map<?= $type . $skus[$i] ?>">
                    <area shape="rect" coords="24, 76, 122, 226" />
                    <area shape="rect" coords="137, 52, 288, 223" />
                    <area shape="rect" coords="290, 59, 424, 223" />
                    <area shape="rect" coords="429, 50, 601, 221" />
                    <area shape="rect" coords="606, 55, 840, 238" />
                    <area shape="rect" coords="845, 57, 1004, 213" />
                    <area shape="rect" coords="10, 247, 158, 369" />
                    <area shape="rect" coords="157, 227, 351, 376" />
                    <area shape="rect" coords="366, 225, 550, 365" />
                    <area shape="rect" coords="561, 241, 684, 367" />
                    <area shape="rect" coords="709, 241, 828, 362" />
                    <area shape="rect" coords="860, 216, 1002, 361" />
                    <area shape="rect" coords="21, 388, 137, 537" />
                    <area shape="rect" coords="152, 375, 277, 537" />
                    <area shape="rect" coords="293, 395, 437, 542" />
                    <area shape="rect" coords="443, 397, 525, 532" />
                    <area shape="rect" coords="531, 367, 768, 537" />
                    <area shape="rect" coords="772, 414, 868, 529" />
                    <area shape="rect" coords="870, 366, 1014, 532" />
                    <area shape="rect" coords="24, 628, 172, 796" />
                    <area shape="rect" coords="179, 619, 343, 795" />
                    <area shape="rect" coords="349, 613, 537, 792" />
                    <area shape="rect" coords="542, 610, 681, 790" />
                    <area shape="rect" coords="688, 610, 826, 812" />
                    <area shape="rect" coords="829, 617, 1016, 816" />
                    <area shape="rect" coords="31, 797, 196, 956" />
                    <area shape="rect" coords="200, 838, 353, 960" />
                    <area shape="rect" coords="370, 793, 547, 966" />
                    <area shape="rect" coords="560, 810, 734, 972" />
                    <area shape="rect" coords="739, 831, 894, 1022" />
                    <area shape="rect" coords="895, 828, 1007, 1023" />
                    <area shape="rect" coords="19, 962, 215, 1160" />
                    <area shape="rect" coords="224, 965, 422, 1156" />
                    <area shape="rect" coords="432, 970, 567, 1157" />
                    <area shape="rect" coords="571, 1019, 694, 1165" />
                    <area shape="rect" coords="705, 1032, 858, 1163" />
                    <area shape="rect" coords="864, 1023, 1006, 1163" />
                    <area shape="rect" coords="12, 1235, 121, 1356" />
                    <area shape="rect" coords="130, 1250, 213, 1357" />
                    <area shape="rect" coords="239, 1242, 335, 1357" />
                    <area shape="rect" coords="353, 1250, 424, 1359" />
                    <area shape="rect" coords="426, 1265, 514, 1357" />
                    <area shape="rect" coords="516, 1242, 619, 1362" />
                    <area shape="rect" coords="621, 1253, 722, 1364" />
                    <area shape="rect" coords="733, 1254, 831, 1356" />
                    <area shape="rect" coords="833, 1262, 922, 1360" />
                    <area shape="rect" coords="923, 1238, 1014, 1364" />
                    <area shape="rect" coords="14, 1357, 167, 1490" />
                    <area shape="rect" coords="178, 1362, 297, 1489" />
                    <area shape="rect" coords="302, 1364, 416, 1493" />
                    <area shape="rect" coords="419, 1375, 531, 1490" />
                    <area shape="rect" coords="536, 1371, 606, 1491" />
                    <area shape="rect" coords="611, 1365, 723, 1493" />
                    <area shape="rect" coords="725, 1366, 820, 1493" />
                    <area shape="rect" coords="819, 1365, 914, 1491" />
                    <area shape="rect" coords="918, 1367, 1022, 1494" />
                </map>
            </p>
        </div>
        <div class="col-sm-12 col-md-8 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>