<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $skus = [$_POST['sku']];
    /**
     * TODO alias inside sku code 
     */
    $sku_alias = 'A08_10570-Ed_dino-de1-borderx.jpg';
    $type = 'edupack';
?>
    <ul class="pages">
        <?php $i = 1;
        foreach ($skus as $sku) {  ?>
            <li class="<?php echo $_POST['sku'] == $sku ? 'selected' : ''; ?>" data-type="<?= $type ?>" data-sku="<?php echo $sku ?>" data-page=""><a href="#"><?php echo $i; ?></a></li>
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
                    <img class="lazyload <?= $type . $sku ?>" data-src="/images/audio_poster/<?= $sku_alias ?>" usemap="#image-map<?= $type . $sku ?>" />
                <?php } ?>
                <div class="map-selector">&nbsp;</div>
            </div>
            <p>
                <map style="<?php echo $_POST['sku'] == $skus[0] ? '' : 'display:none;'; ?>" id="image-map<?= $type . $skus[0] ?>" name="image-map<?= $type . $skus[0] ?>">
                    <area shape="rect" coords="18, 137, 465, 402" />
                    <area shape="rect" coords="466, 137, 936, 353" />
                    <area shape="rect" coords="33, 402, 418, 560" />
                    <area shape="rect" coords="349, 410, 611, 703" />
                    <area shape="rect" coords="686, 250, 1123, 553" />
                    <area shape="rect" coords="621, 494, 894, 694" />
                    <area shape="rect" coords="866, 570, 1130, 747" />
                    <area shape="rect" coords="54, 538, 391, 720" />
                    <area shape="rect" coords="43, 722, 596, 916" />
                    <area shape="rect" coords="486, 796, 745, 922" />
                    <area shape="rect" coords="725, 710, 941, 890" />
                    <area shape="rect" coords="915, 771, 1101, 893" />
                    <area shape="rect" coords="70, 926, 472, 1110" />
                    <area shape="rect" coords="464, 950, 621, 1166" />
                    <area shape="rect" coords="620, 931, 928, 1178" />
                    <area shape="rect" coords="861, 905, 1130, 1102" />
                    <area shape="rect" coords="311, 1112, 453, 1221" />
                    <area shape="rect" coords="60, 1130, 299, 1383" />
                    <area shape="rect" coords="366, 1205, 648, 1372" />
                    <area shape="rect" coords="674, 1177, 943, 1445" />
                    <area shape="rect" coords="60, 1466, 234, 1587" />
                    <area shape="rect" coords="180, 1382, 493, 1582" />
                    <area shape="rect" coords="455, 1416, 669, 1578" />
                    <area shape="rect" coords="684, 1465, 833, 1583" />
                    <area shape="rect" coords="835, 1492, 1096, 1607" />
                    <area shape="rect" coords="946, 1343, 1114, 1475" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>