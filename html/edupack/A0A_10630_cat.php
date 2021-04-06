<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {

    $skus = ["A0A_10630", "A0A_10640"];

    $currentSkuPage = $skus[0];
    if (isset($_POST['sku']) && in_array($_POST['sku'], $skus)) {
        $currentSkuPage = $_POST['sku'];
    }

    /**
     * TODO alias inside sku code 
     */
    $sku_alias = '-Ed_cat';
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
                    <area shape="rect" coords="24, 85, 205, 261" />
                    <area shape="rect" coords="233, 80, 427, 263" />
                    <area shape="rect" coords="445, 85, 627, 256" />
                    <area shape="rect" coords="652, 83, 842, 260" />
                    <area shape="rect" coords="862, 81, 1038, 258" />
                    <area shape="rect" coords="24, 295, 218, 463" />
                    <area shape="rect" coords="239, 281, 507, 676" />
                    <area shape="rect" coords="510, 285, 803, 571" />
                    <area shape="rect" coords="863, 288, 1045, 468" />
                    <area shape="rect" coords="18, 477, 224, 676" />
                    <area shape="rect" coords="697, 560, 869, 713" />
                    <area shape="rect" coords="862, 502, 1038, 672" />
                    <area shape="rect" coords="25, 705, 217, 893" />
                    <area shape="rect" coords="227, 688, 504, 1048" />
                    <area shape="rect" coords="502, 641, 840, 985" />
                    <area shape="rect" coords="859, 701, 1032, 893" />
                    <area shape="rect" coords="10, 916, 228, 1096" />
                    <area shape="rect" coords="229, 1050, 350, 1167" />
                    <area shape="rect" coords="538, 980, 865, 1328" />
                    <area shape="rect" coords="865, 907, 1037, 1093" />
                    <area shape="rect" coords="34, 1111, 214, 1306" />
                    <area shape="rect" coords="339, 1116, 579, 1331" />
                    <area shape="rect" coords="870, 1107, 1034, 1302" />
                    <area shape="rect" coords="32, 1321, 209, 1522" />
                    <area shape="rect" coords="248, 1322, 414, 1513" />
                    <area shape="rect" coords="455, 1330, 614, 1517" />
                    <area shape="rect" coords="645, 1330, 835, 1521" />
                    <area shape="rect" coords="868, 1316, 1035, 1516" />
                </map>
                <map style="<?php echo $_POST['sku'] == $skus[1] ? '' : 'display:none;'; ?>" id="image-map<?= $type . $skus[1] ?>" name="image-map<?= $type . $skus[1] ?>">
                    <area shape="rect" coords="37, 81, 209, 277" />
                    <area shape="rect" coords="247, 80, 408, 268" />
                    <area shape="rect" coords="447, 85, 629, 267" />
                    <area shape="rect" coords="647, 85, 843, 262" />
                    <area shape="rect" coords="878, 82, 1030, 271" />
                    <area shape="rect" coords="42, 291, 204, 476" />
                    <area shape="rect" coords="240, 280, 434, 592" />
                    <area shape="rect" coords="555, 282, 867, 657" />
                    <area shape="rect" coords="874, 282, 1033, 472" />
                    <area shape="rect" coords="335, 506, 600, 670" />
                    <area shape="rect" coords="30, 503, 217, 677" />
                    <area shape="rect" coords="215, 642, 398, 890" />
                    <area shape="rect" coords="524, 656, 852, 1012" />
                    <area shape="rect" coords="874, 503, 1035, 681" />
                    <area shape="rect" coords="49, 706, 197, 895" />
                    <area shape="rect" coords="864, 698, 1028, 893" />
                    <area shape="rect" coords="25, 925, 212, 1098" />
                    <area shape="rect" coords="235, 766, 545, 1132" />
                    <area shape="rect" coords="527, 1003, 888, 1323" />
                    <area shape="rect" coords="875, 916, 1038, 1091" />
                    <area shape="rect" coords="207, 1147, 554, 1340" />
                    <area shape="rect" coords="34, 1121, 204, 1318" />
                    <area shape="rect" coords="868, 1120, 1034, 1306" />
                    <area shape="rect" coords="34, 1326, 204, 1530" />
                    <area shape="rect" coords="255, 1337, 414, 1517" />
                    <area shape="rect" coords="452, 1316, 625, 1523" />
                    <area shape="rect" coords="658, 1325, 830, 1520" />
                    <area shape="rect" coords="868, 1318, 1025, 1517" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>