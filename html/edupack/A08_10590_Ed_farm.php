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
                    <area shape="rect" coords="65, 157, 448, 393" />
                    <area shape="rect" coords="300, 392, 431, 489" />
                    <area shape="rect" coords="453, 160, 1009, 567" />
                    <area shape="rect" coords="470, 572, 610, 739" />
                    <area shape="rect" coords="54, 493, 449, 721" />
                    <area shape="rect" coords="31, 728, 403, 1014" />
                    <area shape="rect" coords="409, 746, 735, 1053" />
                    <area shape="rect" coords="829, 741, 950, 844" />
                    <area shape="rect" coords="703, 623, 925, 737" />
                    <area shape="rect" coords="744, 844, 1007, 1057" />
                    <area shape="rect" coords="692, 1054, 891, 1148" />
                    <area shape="rect" coords="37, 1032, 195, 1252" />
                    <area shape="rect" coords="201, 1098, 331, 1250" />
                    <area shape="rect" coords="339, 1059, 686, 1238" />
                    <area shape="rect" coords="747, 1154, 1020, 1443" />
                    <area shape="rect" coords="662, 1301, 737, 1407" />
                    <area shape="rect" coords="489, 1240, 660, 1411" />
                    <area shape="rect" coords="358, 1252, 471, 1416" />
                    <area shape="rect" coords="280, 1330, 353, 1408" />
                    <area shape="rect" coords="161, 1263, 264, 1417" />
                    <area shape="rect" coords="77, 1325, 137, 1417" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>