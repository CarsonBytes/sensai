<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $skus = ['A08_10550'];
    /**
     * TODO alias inside sku code 
     */
    $sku_alias = '_Ed_ABC';
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
                    <img class="lazyload <?= $type . $sku ?>" data-src="/images/audio_poster/<?= $sku.$sku_alias ?>-en1_1500.jpg" usemap="#image-map<?= $type . $sku ?>" />
                <?php } ?>
                <div class="map-selector">&nbsp;</div>
            </div>
            <p>
                <map style="<?php echo $_POST['sku'] == $skus[0] ? '' : 'display:none;'; ?>" id="image-map<?= $type . $skus[0] ?>" name="image-map<?= $type . $skus[0] ?>">
                    <area shape="rect" coords="50, 129, 237, 311" />
                    <area shape="rect" coords="252, 120, 424, 311" />
                    <area shape="rect" coords="426, 137, 618, 316" />
                    <area shape="rect" coords="618, 116, 806, 340" />
                    <area shape="rect" coords="811, 121, 1019, 336" />
                    <area shape="rect" coords="39, 357, 248, 562" />
                    <area shape="rect" coords="256, 317, 429, 581" />
                    <area shape="rect" coords="436, 354, 620, 559" />
                    <area shape="rect" coords="631, 354, 807, 550" />
                    <area shape="rect" coords="814, 391, 997, 611" />
                    <area shape="rect" coords="62, 584, 267, 792" />
                    <area shape="rect" coords="295, 601, 492, 806" />
                    <area shape="rect" coords="504, 611, 760, 814" />
                    <area shape="rect" coords="766, 618, 989, 804" />
                    <area shape="rect" coords="58, 805, 257, 997" />
                    <area shape="rect" coords="289, 811, 489, 1018" />
                    <area shape="rect" coords="507, 823, 739, 1004" />
                    <area shape="rect" coords="765, 835, 1031, 996" />
                    <area shape="rect" coords="49, 1014, 286, 1209" />
                    <area shape="rect" coords="291, 1023, 509, 1226" />
                    <area shape="rect" coords="526, 1007, 769, 1230" />
                    <area shape="rect" coords="774, 1017, 1036, 1223" />
                    <area shape="rect" coords="40, 1232, 315, 1443" />
                    <area shape="rect" coords="322, 1234, 568, 1437" />
                    <area shape="rect" coords="576, 1230, 795, 1438" />
                    <area shape="rect" coords="810, 1261, 1017, 1450" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>