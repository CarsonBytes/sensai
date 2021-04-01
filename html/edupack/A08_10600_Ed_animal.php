<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $skus = [$_POST['sku']];
    /**
     * TODO alias inside sku code 
     */
    $sku_alias = 'A08_10600-Ed_animal-de1-borderx.jpg';
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
                    <area shape="rect" coords="590, 122, 902, 313" />
                    <area shape="rect" coords="25, 135, 443, 514" />
                    <area shape="rect" coords="449, 355, 663, 525" />
                    <area shape="rect" coords="691, 323, 1021, 480" />
                    <area shape="rect" coords="906, 122, 1023, 240" />
                    <area shape="rect" coords="153, 521, 419, 741" />
                    <area shape="rect" coords="503, 527, 778, 683" />
                    <area shape="rect" coords="784, 502, 1040, 686" />
                    <area shape="rect" coords="868, 698, 1002, 833" />
                    <area shape="rect" coords="575, 687, 857, 799" />
                    <area shape="rect" coords="45, 642, 154, 745" />
                    <area shape="rect" coords="38, 744, 305, 988" />
                    <area shape="rect" coords="465, 936, 634, 1032" />
                    <area shape="rect" coords="643, 915, 859, 1044" />
                    <area shape="rect" coords="910, 991, 1026, 1090" />
                    <area shape="rect" coords="862, 836, 1010, 982" />
                    <area shape="rect" coords="780, 1092, 928, 1180" />
                    <area shape="rect" coords="466, 1048, 770, 1197" />
                    <area shape="rect" coords="849, 1181, 1012, 1416" />
                    <area shape="rect" coords="726, 1247, 826, 1367" />
                    <area shape="rect" coords="449, 1201, 719, 1418" />
                    <area shape="rect" coords="81, 1008, 435, 1275" />
                    <area shape="rect" coords="202, 1286, 341, 1395" />
                    <area shape="rect" coords="22, 1302, 138, 1401" />
                    <area shape="rect" coords="516, 799, 793, 914" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>