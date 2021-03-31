<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $skus = ['A08_10580'];
    /**
     * TODO alias inside sku code 
     */
    $sku_alias = '-Ed_veggie';
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
                    <img class="lazyload <?= $type . $sku ?>" data-src="/images/audio_poster/<?= $sku . $sku_alias ?>-de1-borderx.jpg" usemap="#image-map<?= $type . $sku ?>" />
                <?php } ?>
                <div class="map-selector">&nbsp;</div>
            </div>
            <p>
                <map style="<?php echo $_POST['sku'] == $skus[0] ? '' : 'display:none;'; ?>" id="image-map<?= $type . $skus[0] ?>" name="image-map<?= $type . $skus[0] ?>">
                    <area shape="rect" coords="26, 123, 191, 378" />
                    <area shape="rect" coords="193, 194, 386, 361" />
                    <area shape="rect" coords="402, 183, 697, 363" />
                    <area shape="rect" coords="700, 157, 854, 348" />
                    <area shape="rect" coords="858, 131, 1016, 362" />
                    <area shape="rect" coords="35, 421, 248, 610" />
                    <area shape="rect" coords="286, 367, 468, 586" />
                    <area shape="rect" coords="558, 430, 719, 592" />
                    <area shape="rect" coords="771, 389, 1002, 617" />
                    <area shape="rect" coords="75, 614, 274, 813" />
                    <area shape="rect" coords="285, 598, 452, 811" />
                    <area shape="rect" coords="496, 639, 645, 815" />
                    <area shape="rect" coords="649, 625, 831, 808" />
                    <area shape="rect" coords="846, 624, 1014, 809" />
                    <area shape="rect" coords="50, 832, 195, 1032" />
                    <area shape="rect" coords="239, 840, 533, 1031" />
                    <area shape="rect" coords="545, 828, 789, 1037" />
                    <area shape="rect" coords="262, 1039, 461, 1263" />
                    <area shape="rect" coords="834, 845, 1021, 1034" />
                    <area shape="rect" coords="46, 1058, 194, 1258" />
                    <area shape="rect" coords="332, 1276, 530, 1436" />
                    <area shape="rect" coords="505, 1055, 718, 1271" />
                    <area shape="rect" coords="774, 1047, 1024, 1262" />
                    <area shape="rect" coords="32, 1273, 326, 1450" />
                    <area shape="rect" coords="529, 1277, 717, 1436" />
                    <area shape="rect" coords="771, 1270, 1021, 1427" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>