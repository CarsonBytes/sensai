<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {

    $skus = ["A0B_10610", "A0B_10620"];

    $currentSkuPage = $skus[0];
    if (isset($_POST['sku']) && in_array($_POST['sku'], $skus)) {
        $currentSkuPage = $_POST['sku'];
    }

    /**
     * TODO alias inside sku code 
     */
    $sku_alias = '-Ed_dog';
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
                    <area shape="rect" coords="24, 78, 230, 296" />
                    <area shape="rect" coords="243, 101, 351, 287" />
                    <area shape="rect" coords="361, 125, 519, 280" />
                    <area shape="rect" coords="526, 80, 668, 277" />
                    <area shape="rect" coords="660, 102, 773, 287" />
                    <area shape="rect" coords="783, 106, 881, 251" />
                    <area shape="rect" coords="895, 80, 1029, 275" />
                    <area shape="rect" coords="38, 312, 134, 416" />
                    <area shape="rect" coords="153, 311, 278, 425" />
                    <area shape="rect" coords="296, 305, 404, 421" />
                    <area shape="rect" coords="423, 295, 561, 417" />
                    <area shape="rect" coords="571, 293, 738, 425" />
                    <area shape="rect" coords="753, 274, 904, 416" />
                    <area shape="rect" coords="21, 498, 220, 766" />
                    <area shape="rect" coords="211, 507, 444, 750" />
                    <area shape="rect" coords="376, 541, 574, 752" />
                    <area shape="rect" coords="531, 426, 779, 658" />
                    <area shape="rect" coords="754, 415, 1049, 660" />
                    <area shape="rect" coords="19, 771, 136, 892" />
                    <area shape="rect" coords="138, 771, 380, 880" />
                    <area shape="rect" coords="373, 776, 614, 885" />
                    <area shape="rect" coords="605, 655, 854, 893" />
                    <area shape="rect" coords="921, 646, 1060, 840" />
                    <area shape="rect" coords="758, 771, 974, 997" />
                    <area shape="rect" coords="14, 997, 126, 1183" />
                    <area shape="rect" coords="133, 1020, 306, 1193" />
                    <area shape="rect" coords="336, 958, 464, 1186" />
                    <area shape="rect" coords="476, 946, 644, 1187" />
                    <area shape="rect" coords="649, 972, 1053, 1188" />
                    <area shape="rect" coords="543, 1190, 675, 1303" />
                    <area shape="rect" coords="855, 1158, 976, 1317" />
                    <area shape="rect" coords="718, 1175, 825, 1307" />
                    <area shape="rect" coords="20, 1271, 150, 1531" />
                    <area shape="rect" coords="155, 1297, 296, 1523" />
                    <area shape="rect" coords="298, 1312, 435, 1525" />
                    <area shape="rect" coords="425, 1320, 655, 1523" />
                    <area shape="rect" coords="649, 1336, 736, 1537" />
                    <area shape="rect" coords="718, 1328, 939, 1526" />
                    <area shape="rect" coords="921, 1318, 1055, 1530" />
                </map>
                <map style="<?php echo $_POST['sku'] == $skus[1] ? '' : 'display:none;'; ?>" id="image-map<?= $type . $skus[1] ?>" name="image-map<?= $type . $skus[1] ?>">
                    <area shape="rect" coords="20, 102, 158, 214" />
                    <area shape="rect" coords="180, 87, 389, 216" />
                    <area shape="rect" coords="393, 118, 551, 211" />
                    <area shape="rect" coords="571, 103, 680, 203" />
                    <area shape="rect" coords="703, 88, 790, 212" />
                    <area shape="rect" coords="809, 88, 958, 203" />
                    <area shape="rect" coords="30, 313, 141, 485" />
                    <area shape="rect" coords="148, 350, 278, 478" />
                    <area shape="rect" coords="294, 285, 521, 488" />
                    <area shape="rect" coords="531, 265, 769, 483" />
                    <area shape="rect" coords="801, 210, 1052, 488" />
                    <area shape="rect" coords="18, 495, 206, 760" />
                    <area shape="rect" coords="201, 596, 408, 757" />
                    <area shape="rect" coords="391, 496, 590, 761" />
                    <area shape="rect" coords="583, 513, 736, 760" />
                    <area shape="rect" coords="740, 517, 879, 761" />
                    <area shape="rect" coords="884, 490, 1050, 760" />
                    <area shape="rect" coords="10, 763, 175, 1030" />
                    <area shape="rect" coords="214, 780, 341, 1028" />
                    <area shape="rect" coords="373, 783, 508, 1037" />
                    <area shape="rect" coords="534, 825, 740, 1030" />
                    <area shape="rect" coords="754, 775, 1048, 1043" />
                    <area shape="rect" coords="19, 1073, 194, 1246" />
                    <area shape="rect" coords="195, 1060, 473, 1232" />
                    <area shape="rect" coords="465, 1098, 538, 1242" />
                    <area shape="rect" coords="573, 1108, 658, 1241" />
                    <area shape="rect" coords="681, 1027, 1055, 1272" />
                    <area shape="rect" coords="19, 1323, 190, 1522" />
                    <area shape="rect" coords="194, 1388, 378, 1535" />
                    <area shape="rect" coords="393, 1360, 475, 1531" />
                    <area shape="rect" coords="479, 1375, 613, 1527" />
                    <area shape="rect" coords="615, 1365, 806, 1526" />
                    <area shape="rect" coords="784, 1316, 1063, 1535" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>