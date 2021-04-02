<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $skus = [$_POST['sku']];
    /**
     * TODO alias inside sku code 
     */
    $sku_alias = 'A08_10590-Ed_farm-de1-borderx.jpg';
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
                    <area shape="rect" coords="98, 136, 501, 403" />
                    <area shape="rect" coords="331, 406, 446, 503" />
                    <area shape="rect" coords="476, 148, 1091, 596" />
                    <area shape="rect" coords="530, 585, 691, 776" />
                    <area shape="rect" coords="71, 510, 498, 765" />
                    <area shape="rect" coords="78, 770, 555, 1063" />
                    <area shape="rect" coords="463, 811, 910, 1155" />
                    <area shape="rect" coords="899, 726, 1009, 856" />
                    <area shape="rect" coords="818, 601, 1026, 718" />
                    <area shape="rect" coords="801, 908, 1099, 1156" />
                    <area shape="rect" coords="771, 1171, 899, 1277" />
                    <area shape="rect" coords="90, 1152, 260, 1360" />
                    <area shape="rect" coords="265, 1227, 394, 1355" />
                    <area shape="rect" coords="379, 1168, 744, 1376" />
                    <area shape="rect" coords="889, 1171, 1116, 1593" />
                    <area shape="rect" coords="721, 1456, 783, 1531" />
                    <area shape="rect" coords="536, 1381, 710, 1532" />
                    <area shape="rect" coords="365, 1388, 511, 1536" />
                    <area shape="rect" coords="323, 1477, 366, 1531" />
                    <area shape="rect" coords="175, 1397, 283, 1530" />
                    <area shape="rect" coords="89, 1491, 140, 1533" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>