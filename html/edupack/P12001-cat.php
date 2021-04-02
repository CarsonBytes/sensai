<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {

    $skus = ["P12001", "P12002"];

    $currentSkuPage = $skus[0];
    if (isset($_POST['sku']) && in_array($_POST['sku'], $skus)) {
        $currentSkuPage = $_POST['sku'];
    }

    /**
     * TODO alias inside sku code 
     */
    $sku_alias = '-cat';
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
                    <area shape="rect" coords="28, 139, 248, 337" />
                    <area shape="rect" coords="252, 167, 449, 293" />
                    <area shape="rect" coords="449, 161, 665, 292" />
                    <area shape="rect" coords="671, 89, 866, 299" />
                    <area shape="rect" coords="876, 87, 1042, 294" />
                    <area shape="rect" coords="18, 343, 182, 536" />
                    <area shape="rect" coords="184, 340, 373, 538" />
                    <area shape="rect" coords="374, 359, 673, 537" />
                    <area shape="rect" coords="675, 372, 830, 538" />
                    <area shape="rect" coords="831, 323, 944, 498" />
                    <area shape="rect" coords="947, 330, 1058, 538" />
                    <area shape="rect" coords="6, 649, 196, 798" />
                    <area shape="rect" coords="196, 599, 417, 802" />
                    <area shape="rect" coords="420, 624, 512, 805" />
                    <area shape="rect" coords="513, 606, 623, 807" />
                    <area shape="rect" coords="625, 592, 761, 816" />
                    <area shape="rect" coords="761, 603, 884, 797" />
                    <area shape="rect" coords="885, 604, 1046, 769" />
                    <area shape="rect" coords="18, 840, 206, 1052" />
                    <area shape="rect" coords="208, 907, 451, 1052" />
                    <area shape="rect" coords="454, 839, 572, 1055" />
                    <area shape="rect" coords="584, 869, 777, 1051" />
                    <area shape="rect" coords="782, 828, 1045, 1050" />
                    <area shape="rect" coords="26, 1083, 242, 1290" />
                    <area shape="rect" coords="245, 1082, 462, 1288" />
                    <area shape="rect" coords="461, 1073, 592, 1303" />
                    <area shape="rect" coords="595, 1127, 735, 1296" />
                    <area shape="rect" coords="750, 1107, 900, 1301" />
                    <area shape="rect" coords="901, 1055, 1035, 1309" />
                    <area shape="rect" coords="17, 1319, 167, 1507" />
                    <area shape="rect" coords="172, 1316, 328, 1530" />
                    <area shape="rect" coords="336, 1322, 455, 1518" />
                    <area shape="rect" coords="462, 1325, 598, 1520" />
                    <area shape="rect" coords="600, 1328, 767, 1525" />
                    <area shape="rect" coords="773, 1309, 1051, 1551" />
                </map>
                <map style="<?php echo $_POST['sku'] == $skus[1] ? '' : 'display:none;'; ?>" id="image-map<?= $type . $skus[1] ?>" name="image-map<?= $type . $skus[1] ?>">
                    <area shape="rect" coords="18, 52, 326, 279" />
                    <area shape="rect" coords="325, 83, 484, 279" />
                    <area shape="rect" coords="493, 48, 777, 269" />
                    <area shape="rect" coords="779, 75, 1032, 279" />
                    <area shape="rect" coords="15, 293, 210, 504" />
                    <area shape="rect" coords="211, 290, 331, 510" />
                    <area shape="rect" coords="335, 317, 567, 508" />
                    <area shape="rect" coords="571, 316, 905, 500" />
                    <area shape="rect" coords="907, 300, 1050, 516" />
                    <area shape="rect" coords="11, 613, 324, 771" />
                    <area shape="rect" coords="328, 533, 477, 731" />
                    <area shape="rect" coords="484, 529, 674, 830" />
                    <area shape="rect" coords="678, 548, 908, 789" />
                    <area shape="rect" coords="908, 524, 1048, 787" />
                    <area shape="rect" coords="13, 804, 169, 1023" />
                    <area shape="rect" coords="171, 817, 400, 1019" />
                    <area shape="rect" coords="405, 895, 569, 1022" />
                    <area shape="rect" coords="572, 863, 712, 1022" />
                    <area shape="rect" coords="719, 820, 1041, 1030" />
                    <area shape="rect" coords="12, 1133, 218, 1273" />
                    <area shape="rect" coords="221, 1060, 636, 1273" />
                    <area shape="rect" coords="637, 1050, 833, 1232" />
                    <area shape="rect" coords="834, 1037, 1059, 1279" />
                    <area shape="rect" coords="6, 1354, 199, 1531" />
                    <area shape="rect" coords="202, 1308, 406, 1524" />
                    <area shape="rect" coords="410, 1305, 533, 1522" />
                    <area shape="rect" coords="543, 1310, 762, 1546" />
                    <area shape="rect" coords="772, 1340, 881, 1537" />
                    <area shape="rect" coords="883, 1315, 1054, 1538" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>