<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $skus = [$_POST['sku']];
    /**
     * TODO alias inside sku code 
     */
    $sku_alias = 'A08_10580-Ed_veggie-de1-borderx.jpg';
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
                    <area shape="rect" coords="45, 173, 169, 436" />
                    <area shape="rect" coords="196, 226, 386, 452" />
                    <area shape="rect" coords="424, 195, 766, 422" />
                    <area shape="rect" coords="776, 193, 935, 355" />
                    <area shape="rect" coords="939, 160, 1098, 362" />
                    <area shape="rect" coords="39, 471, 181, 695" />
                    <area shape="rect" coords="295, 427, 513, 626" />
                    <area shape="rect" coords="630, 486, 754, 617" />
                    <area shape="rect" coords="838, 433, 1070, 656" />
                    <area shape="rect" coords="86, 697, 280, 888" />
                    <area shape="rect" coords="306, 673, 494, 868" />
                    <area shape="rect" coords="533, 745, 696, 862" />
                    <area shape="rect" coords="711, 716, 889, 860" />
                    <area shape="rect" coords="920, 707, 1073, 868" />
                    <area shape="rect" coords="55, 920, 233, 1098" />
                    <area shape="rect" coords="275, 920, 463, 1145" />
                    <area shape="rect" coords="574, 902, 766, 1147" />
                    <area shape="rect" coords="290, 1150, 490, 1398" />
                    <area shape="rect" coords="929, 946, 1041, 1100" />
                    <area shape="rect" coords="53, 1171, 215, 1351" />
                    <area shape="rect" coords="338, 1406, 516, 1563" />
                    <area shape="rect" coords="545, 1168, 765, 1343" />
                    <area shape="rect" coords="820, 1132, 1119, 1357" />
                    <area shape="rect" coords="40, 1388, 238, 1585" />
                    <area shape="rect" coords="618, 1392, 818, 1541" />
                    <area shape="rect" coords="840, 1416, 1113, 1548" />
                </map>
            </p>
        </div>
        <div class="col-sm-6 maptable">
            <div id="imageMapTable">&nbsp;</div>
        </div>
    </div>
<?php } ?>