<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $skus = ['A08_10570'];
    /**
     * TODO alias inside sku code 
     */
    $sku_alias = '-Ed_dino';
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
                    <area shape="rect" coords="29, 121, 475, 350" />
                    <area shape="rect" coords="478, 126, 874, 301" />
                    <area shape="rect" coords="31, 353, 370, 486" />
                    <area shape="rect" coords="373, 349, 562, 624" />
                    <area shape="rect" coords="593, 301, 1039, 482" />
                    <area shape="rect" coords="563, 484, 799, 629" />
                    <area shape="rect" coords="795, 527, 1008, 644" />
                    <area shape="rect" coords="49, 502, 366, 640" />
                    <area shape="rect" coords="54, 640, 463, 828" />
                    <area shape="rect" coords="464, 701, 688, 809" />
                    <area shape="rect" coords="692, 646, 847, 800" />
                    <area shape="rect" coords="851, 691, 1014, 803" />
                    <area shape="rect" coords="45, 830, 432, 999" />
                    <area shape="rect" coords="433, 844, 575, 1051" />
                    <area shape="rect" coords="580, 833, 804, 1063" />
                    <area shape="rect" coords="802, 817, 1046, 995" />
                    <area shape="rect" coords="289, 1010, 410, 1095" />
                    <area shape="rect" coords="79, 1000, 279, 1240" />
                    <area shape="rect" coords="371, 1097, 627, 1229" />
                    <area shape="rect" coords="647, 1076, 884, 1280" />
                    <area shape="rect" coords="66, 1294, 211, 1422" />
                    <area shape="rect" coords="224, 1236, 438, 1419" />
                    <area shape="rect" coords="440, 1267, 640, 1416" />
                    <area shape="rect" coords="645, 1299, 761, 1417" />
                    <area shape="rect" coords="760, 1337, 1024, 1439" />
                    <area shape="rect" coords="887, 1205, 1036, 1325" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>