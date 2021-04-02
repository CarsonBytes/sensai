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
                    <area shape="rect" coords="619, 130, 972, 312" />
                    <area shape="rect" coords="42, 146, 567, 548" />
                    <area shape="rect" coords="496, 305, 741, 605" />
                    <area shape="rect" coords="741, 360, 1092, 516" />
                    <area shape="rect" coords="962, 142, 1080, 251" />
                    <area shape="rect" coords="218, 586, 516, 805" />
                    <area shape="rect" coords="553, 532, 809, 763" />
                    <area shape="rect" coords="819, 553, 1101, 751" />
                    <area shape="rect" coords="902, 781, 1090, 930" />
                    <area shape="rect" coords="643, 765, 944, 873" />
                    <area shape="rect" coords="94, 707, 209, 801" />
                    <area shape="rect" coords="94, 822, 394, 1112" />
                    <area shape="rect" coords="514, 1053, 670, 1172" />
                    <area shape="rect" coords="695, 1017, 914, 1170" />
                    <area shape="rect" coords="938, 1098, 1080, 1220" />
                    <area shape="rect" coords="954, 946, 1081, 1082" />
                    <area shape="rect" coords="850, 1238, 1003, 1330" />
                    <area shape="rect" coords="515, 1186, 850, 1351" />
                    <area shape="rect" coords="910, 1358, 1074, 1595" />
                    <area shape="rect" coords="819, 1380, 913, 1497" />
                    <area shape="rect" coords="471, 1350, 804, 1596" />
                    <area shape="rect" coords="82, 807, 580, 1418" />
                    <area shape="rect" coords="354, 1445, 415, 1566" />
                    <area shape="rect" coords="233, 1478, 350, 1562" />
                    <area shape="rect" coords="581, 873, 888, 1015" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>