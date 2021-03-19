<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $skus = ['A08_10560'];
    /**
     * TODO alias inside sku code 
     */
    $sku_alias = '_Ed_123';
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
                    <img class="lazyload <?= $type . $sku ?>" data-src="/images/audio_poster/<?= $sku . $sku_alias ?>-en1_1500.jpg" usemap="#image-map<?= $type . $sku ?>" />
                <?php } ?>
                <div class="map-selector">&nbsp;</div>
            </div>
            <p>
                <map style="<?php echo $_POST['sku'] == $skus[0] ? '' : 'display:none;'; ?>" id="image-map<?= $type . $skus[0] ?>" name="image-map<?= $type . $skus[0] ?>">
                    <area shape="rect" coords="51, 160, 297, 538" />
                    <area shape="rect" coords="319, 162, 514, 521" />
                    <area shape="rect" coords="529, 140, 756, 514" />
                    <area shape="rect" coords="778, 180, 1026, 522" />
                    <area shape="rect" coords="77, 558, 406, 983" />
                    <area shape="rect" coords="412, 565, 698, 981" />
                    <area shape="rect" coords="726, 570, 1015, 982" />
                    <area shape="rect" coords="48, 1035, 369, 1422" />
                    <area shape="rect" coords="375, 1018, 676, 1421" />
                    <area shape="rect" coords="693, 1006, 1045, 1416" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>