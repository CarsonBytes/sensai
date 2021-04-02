<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $skus = [$_POST['sku']];
    /**
     * TODO alias inside sku code 
     */
    $sku_alias = 'A08_10550-Ed_ABC-de1-borderx.jpg';
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
                    <area shape="rect" coords="53, 146, 244, 363" />
                    <area shape="rect" coords="261, 137, 443, 353" />
                    <area shape="rect" coords="453, 160, 656, 363" />
                    <area shape="rect" coords="643, 153, 871, 383" />
                    <area shape="rect" coords="860, 141, 1079, 386" />
                    <area shape="rect" coords="58, 420, 251, 617" />
                    <area shape="rect" coords="250, 366, 459, 648" />
                    <area shape="rect" coords="458, 413, 659, 621" />
                    <area shape="rect" coords="666, 390, 909, 603" />
                    <area shape="rect" coords="869, 442, 1088, 676" />
                    <area shape="rect" coords="56, 652, 261, 870" />
                    <area shape="rect" coords="288, 665, 531, 881" />
                    <area shape="rect" coords="538, 663, 820, 900" />
                    <area shape="rect" coords="824, 695, 1063, 877" />
                    <area shape="rect" coords="58, 881, 249, 1100" />
                    <area shape="rect" coords="300, 890, 526, 1121" />
                    <area shape="rect" coords="545, 901, 748, 1096" />
                    <area shape="rect" coords="818, 908, 1095, 1083" />
                    <area shape="rect" coords="59, 1106, 299, 1316" />
                    <area shape="rect" coords="316, 1127, 525, 1338" />
                    <area shape="rect" coords="543, 1098, 819, 1341" />
                    <area shape="rect" coords="824, 1117, 1089, 1337" />
                    <area shape="rect" coords="49, 1363, 329, 1580" />
                    <area shape="rect" coords="353, 1358, 630, 1588" />
                    <area shape="rect" coords="609, 1343, 849, 1576" />
                    <area shape="rect" coords="853, 1371, 1068, 1586" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>