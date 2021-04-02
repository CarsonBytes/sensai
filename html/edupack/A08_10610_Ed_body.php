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

                    <area shape="rect" coords="71, 180, 199, 310" />
                    <area shape="rect" coords="236, 180, 364, 310" />
                    <area shape="rect" coords="424, 180, 552, 310" />
                    <area shape="rect" coords="611, 180, 739, 310" />
                    <area shape="rect" coords="793, 180, 921, 310" />
                    <area shape="rect" coords="961, 180, 1089, 310" />

                    <area shape="rect" coords="66, 381, 194, 511" />
                    <area shape="rect" coords="960, 381, 1088, 511" />

                    <area shape="rect" coords="73, 583, 201, 713" />
                    <area shape="rect" coords="510, 649, 638, 779" />
                    <area shape="rect" coords="963, 582, 1091, 712" />


                    <area shape="rect" coords="960, 780, 1088, 910" />
                    <area shape="rect" coords="67, 779, 195, 909" />
                    <area shape="rect" coords="509, 839, 637, 969" />

                    <area shape="rect" coords="68, 980, 196, 1110" />
                    <area shape="rect" coords="509, 1025, 637, 1155" />
                    <area shape="rect" coords="962, 982, 1090, 1112" />

                    <area shape="rect" coords="962, 1181, 1090, 1311" />
                    <area shape="rect" coords="65, 1179, 193, 1309" />

                    <area shape="rect" coords="66, 1379, 194, 1509" />
                    <area shape="rect" coords="235, 1379, 363, 1509" />
                    <area shape="rect" coords="419, 1379, 547, 1509" />
                    <area shape="rect" coords="608, 1378, 736, 1509" />
                    <area shape="rect" coords="796, 1379, 924, 1509" />
                    <area shape="rect" coords="959, 1379, 1087, 1509" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>