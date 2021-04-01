<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $skus = [$_POST['sku']];
    /**
     * TODO alias inside sku code 
     */
    $sku_alias = 'A08_10610-Ed_body-de1-borderx.jpg';
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
                    <area shape="rect" coords="52, 165, 195, 328" />
                    <area shape="rect" coords="210, 153, 353, 328" />
                    <area shape="rect" coords="385, 162, 524, 325" />
                    <area shape="rect" coords="547, 172, 685, 321" />
                    <area shape="rect" coords="709, 162, 852, 321" />
                    <area shape="rect" coords="880, 166, 1016, 325" />
                    <area shape="rect" coords="51, 345, 190, 505" />
                    <area shape="rect" coords="874, 345, 1020, 508" />
                    <area shape="rect" coords="53, 521, 203, 677" />
                    <area shape="rect" coords="472, 578, 596, 739" />
                    <area shape="rect" coords="879, 522, 1016, 676" />
                    <area shape="rect" coords="876, 690, 1018, 853" />
                    <area shape="rect" coords="50, 696, 195, 851" />
                    <area shape="rect" coords="460, 740, 601, 900" />
                    <area shape="rect" coords="54, 873, 185, 1029" />
                    <area shape="rect" coords="461, 910, 599, 1074" />
                    <area shape="rect" coords="886, 869, 1010, 1029" />
                    <area shape="rect" coords="879, 1048, 1013, 1207" />
                    <area shape="rect" coords="53, 1039, 198, 1205" />
                    <area shape="rect" coords="39, 1215, 197, 1385" />
                    <area shape="rect" coords="212, 1213, 363, 1389" />
                    <area shape="rect" coords="373, 1212, 534, 1397" />
                    <area shape="rect" coords="551, 1205, 694, 1388" />
                    <area shape="rect" coords="721, 1219, 855, 1393" />
                    <area shape="rect" coords="888, 1213, 1013, 1381" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>