<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $skus = ['P12001','P12002'];
    $type = 'edupack';
?>
<ul class="pages">
    <?php $i=1;
    foreach($skus as $sku){  ?>
        <li class="<?php echo $_POST['sku']==$sku ? 'selected' : ''; ?>" data-type="<?=$type ?>" data-sku="<?php echo $sku?>" data-page="" ><a href="#"><?php echo $i; ?></a></li>
    <?php $i++; } ?>
</ul>
<div class="clearfix"></div>
<div class="row interactive_table">
    <div class="col-sm-6">
        <div class="image-map-container">
            <?php foreach($skus as $sku){  ?>
                <img class="lazyload <?=$type.$sku?>" data-src="/images/poster/edupack/cat/<?=$sku?>_1500.jpg" usemap="#image-map<?=$type.$sku?>" />
            <?php } ?>
            <div class="map-selector">&nbsp;</div>
        </div>
        <p>
            <map style="<?php echo $_POST['sku']==$skus[0] ? '' : 'display:none;'; ?>" id="image-map<?=$type.$skus[0] ?>" name="image-map<?=$type.$skus[0]?>">
                <area shape="rect" coords="18, 120, 241, 319" />
                <area shape="rect" coords="244, 149, 429, 323" />
                <area shape="rect" coords="429, 163, 654, 320" />
                <area shape="rect" coords="663, 89, 810, 315" />
                <area shape="rect" coords="813, 88, 1020, 316" />
                <area shape="rect" coords="12, 322, 186, 554" />
                <area shape="rect" coords="190, 325, 358, 544" />
                <area shape="rect" coords="366, 322, 654, 555" />
                <area shape="rect" coords="660, 343, 789, 539" />
                <area shape="rect" coords="792, 321, 904, 493" />
                <area shape="rect" coords="907, 322, 1025, 542" />
                <area shape="rect" coords="9, 618, 195, 804" />
                <area shape="rect" coords="198, 591, 403, 804" />
                <area shape="rect" coords="405, 564, 487, 797" />
                <area shape="rect" coords="489, 556, 594, 800" />
                <area shape="rect" coords="598, 568, 741, 807" />
                <area shape="rect" coords="744, 583, 857, 775" />
                <area shape="rect" coords="861, 559, 1011, 740" />
                <area shape="rect" coords="23, 806, 193, 1025" />
                <area shape="rect" coords="198, 875, 423, 1027" />
                <area shape="rect" coords="423, 801, 552, 1005" />
                <area shape="rect" coords="561, 811, 750, 1014" />
                <area shape="rect" coords="754, 794, 1014, 1016" />
                <area shape="rect" coords="16, 1038, 228, 1263" />
                <area shape="rect" coords="228, 1030, 436, 1265" />
                <area shape="rect" coords="441, 1023, 569, 1266" />
                <area shape="rect" coords="574, 1023, 706, 1264" />
                <area shape="rect" coords="709, 1022, 866, 1262" />
                <area shape="rect" coords="869, 1028, 1007, 1265" />
                <area shape="rect" coords="18, 1267, 173, 1492" />
                <area shape="rect" coords="178, 1275, 310, 1495" />
                <area shape="rect" coords="320, 1273, 438, 1498" />
                <area shape="rect" coords="439, 1275, 570, 1490" />
                <area shape="rect" coords="575, 1274, 768, 1494" />
                <area shape="rect" coords="775, 1269, 1013, 1493" />
            </map>
            <map style="<?php echo $_POST['sku']==$skus[1] ? '' : 'display:none;'; ?>" id="image-map<?=$type.$skus[1] ?>" name="image-map<?=$type.$skus[1] ?>"> 
                <area shape="rect" coords="25, 45, 313, 276" />
                <area shape="rect" coords="315, 42, 460, 270" />
                <area shape="rect" coords="470, 47, 744, 274" />
                <area shape="rect" coords="749, 71, 988, 282" />
                <area shape="rect" coords="16, 279, 191, 524" />
                <area shape="rect" coords="194, 280, 319, 521" />
                <area shape="rect" coords="323, 298, 544, 520" />
                <area shape="rect" coords="550, 297, 874, 507" />
                <area shape="rect" coords="873, 294, 1008, 508" />
                <area shape="rect" coords="11, 580, 260, 758" />
                <area shape="rect" coords="264, 520, 444, 705" />
                <area shape="rect" coords="445, 522, 639, 796" />
                <area shape="rect" coords="644, 522, 794, 773" />
                <area shape="rect" coords="795, 512, 1007, 753" />
                <area shape="rect" coords="9, 770, 160, 1019" />
                <area shape="rect" coords="162, 790, 389, 1008" />
                <area shape="rect" coords="395, 852, 542, 1007" />
                <area shape="rect" coords="545, 824, 693, 1004" />
                <area shape="rect" coords="707, 778, 999, 986" />
                <area shape="rect" coords="10, 1098, 210, 1254" />
                <area shape="rect" coords="213, 1010, 619, 1248" />
                <area shape="rect" coords="621, 1007, 789, 1221" />
                <area shape="rect" coords="796, 986, 1022, 1231" />
                <area shape="rect" coords="5, 1294, 187, 1491" />
                <area shape="rect" coords="195, 1268, 386, 1493" />
                <area shape="rect" coords="390, 1250, 518, 1489" />
                <area shape="rect" coords="519, 1253, 717, 1485" />
                <area shape="rect" coords="719, 1300, 855, 1478" />
                <area shape="rect" coords="865, 1270, 1016, 1491" />
            </map>
        </p>
    </div>
    <div class="col-sm-6 maptable">
        <div id="imageMapTable">&nbsp;</div>
    </div>
</div>
<?php } ?>