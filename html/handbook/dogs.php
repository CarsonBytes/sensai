<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $pages = 15;
    $type = 'handbook';
    $skus = array(
        'P12003' => array(1,2,3,4,5),
        'P12004' => array(6,7,8,9),
        'P12005' => array(10,11,12,13,14,15)
    );
    function getSku($page){
        global $skus;
        if (in_array($page, $skus['P12003'])) $sku = 'P12003';
        else if (in_array($page, $skus['P12004'])) $sku = 'P12004';
        else $sku = 'P12005'; 
        return $sku;
    }
?>
<style>
    ul.pages{
        display: inline-block;
        color: #111;
        margin-top:10px;
        padding: 0;
    }
    ul.pages li{
        margin-right: 4px;
        background-color: #fff;
        display: block;
        float: left;
        line-height: 16px;
        list-style: none;
        position: relative;
    }
    ul.pages li a{
        color: #111;
        padding: 8px 12px 7px 13px;
        border-radius: 3px;
        box-shadow: 0 1px 0 rgba(255,255,255,.6) inset;
        background: #eff1f3;
        background: -webkit-linear-gradient(top,#f7f8fa,#e7e9ec);
        background: linear-gradient(to bottom,#f7f8fa,#e7e9ec);
        border: 1px solid #6c6e73;
        border-color: #adb1b8 #a2a6ac #8d9096;
        display: block;
        text-decoration: none;
    }
    
    ul.pages li.selected{
        background-color: #fff;
        border-color: #e77600;
    }
    ul.pages li.selected a, ul.pages li.selected a:hover {
    font-weight: 700;
    background-color: #fff;
    background-image: none;
    color: #c45500;
    border-color: #e77600;
    cursor: default;
    }
    ul.pages li a:hover {
        background: #e0e3e9;
        background: -webkit-linear-gradient(top,#e7eaf0,#d9dce1);
        background: linear-gradient(to bottom,#e7eaf0,#d9dce1);
        border-color: #a2a6ac #979aa1 #82858a;
    }
</style>
<ul class="pages">
    <?php
    for ($i=1;$i<=$pages;$i++){ 
        $sku = getSku($i);
    ?>
        <li class="<?php echo $_POST['page']==$i ? 'selected' : ''; ?>" data-type="handbook" data-sku="<?php echo $sku ?>" data-page="<?php echo $i?>" ><a href="#"><?php echo $i; ?></a></li>
    <?php } ?>
</ul>
<div class="clearfix"></div>
<div class="row interactive_table">
    <div class="col-sm-6">
        <div class="image-map-container">
            <?php for ($i=1;$i<=$pages;$i++){
                $sku = getSku($i);
            ?>
                <img class="lazyload <?=$type.$sku.$i ?>" data-src="/images/handbook/dogs/interactive_handbook_dogs_1500_<?=$i?>.jpg" usemap="#image-map<?=$type.$sku.$i ?>" />
            <?php } ?>
            <div class="map-selector">&nbsp;</div>
        </div>
        <p>
            <?php $i = 2; $sku = getSku($i);?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="21, 100, 361, 480" />
                <area shape="rect" coords="418, 100, 736, 412" />
                <area shape="rect" coords="750, 93, 1003, 302" />
                <area shape="rect" coords="366, 415, 737, 668" />
                <area shape="rect" coords="737, 310, 1014, 602" />
                <area shape="rect" coords="25, 494, 311, 829" />
                <area shape="rect" coords="313, 668, 488, 953" />
                <area shape="rect" coords="496, 672, 737, 947" />
                <area shape="rect" coords="741, 604, 1013, 846" />
                <area shape="rect" coords="779, 850, 1009, 993" />
                <area shape="rect" coords="30, 857, 310, 1114" />
                <area shape="rect" coords="336, 964, 596, 1228" />
                <area shape="rect" coords="617, 995, 881, 1153" />
                <area shape="rect" coords="12, 1113, 332, 1463" />
                <area shape="rect" coords="334, 1238, 635, 1462" />
                <area shape="rect" coords="638, 1152, 1009, 1461" />
            </map>
            <?php $i = 3; $sku = getSku($i);?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="16, 158, 364, 507" />
                <area shape="rect" coords="369, 136, 760, 507" />
                <area shape="rect" coords="763, 152, 1007, 511" />
                <area shape="rect" coords="28, 526, 297, 822" />
                <area shape="rect" coords="299, 530, 560, 829" />
                <area shape="rect" coords="563, 533, 801, 854" />
                <area shape="rect" coords="805, 548, 1008, 804" />
                <area shape="rect" coords="30, 831, 343, 1115" />
                <area shape="rect" coords="345, 898, 640, 1127" />
                <area shape="rect" coords="658, 871, 1010, 1128" />
                <area shape="rect" coords="26, 1119, 299, 1460" />
                <area shape="rect" coords="303, 1155, 498, 1462" />
                <area shape="rect" coords="503, 1151, 771, 1466" />
                <area shape="rect" coords="774, 1141, 1006, 1469" />
            </map>
            <?php $i = 4; $sku = getSku($i);?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="16, 116, 407, 460" />
                <area shape="rect" coords="410, 133, 798, 391" />
                <area shape="rect" coords="801, 116, 991, 423" />
                <area shape="rect" coords="24, 538, 265, 727" />
                <area shape="rect" coords="274, 536, 512, 727" />
                <area shape="rect" coords="520, 536, 760, 725" />
                <area shape="rect" coords="763, 428, 1015, 731" />
                <area shape="rect" coords="30, 795, 332, 1105" />
                <area shape="rect" coords="339, 748, 701, 1103" />
                <area shape="rect" coords="702, 760, 1017, 1103" />
                <area shape="rect" coords="36, 1114, 266, 1489" />
                <area shape="rect" coords="281, 1107, 611, 1485" />
                <area shape="rect" coords="620, 1101, 1008, 1481" />
            </map>
            <?php $i = 5; $sku = getSku($i);?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="28, 103, 342, 418" />
                <area shape="rect" coords="348, 106, 570, 416" />
                <area shape="rect" coords="575, 99, 999, 435" />
                <area shape="rect" coords="34, 427, 426, 751" />
                <area shape="rect" coords="430, 438, 706, 739" />
                <area shape="rect" coords="708, 448, 1014, 833" />
                <area shape="rect" coords="27, 759, 557, 1124" />
                <area shape="rect" coords="564, 837, 982, 1173" />
                <area shape="rect" coords="20, 1128, 432, 1490" />
                <area shape="rect" coords="457, 1182, 722, 1483" />
                <area shape="rect" coords="726, 1183, 996, 1488" />
            </map>
            <?php $i = 6; $sku = getSku($i);?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="15, 101, 354, 412" />
                <area shape="rect" coords="380, 104, 694, 400" />
                <area shape="rect" coords="720, 197, 1010, 444" />
                <area shape="rect" coords="25, 416, 406, 767" />
                <area shape="rect" coords="408, 476, 703, 768" />
                <area shape="rect" coords="710, 445, 1010, 776" />
                <area shape="rect" coords="29, 770, 418, 1128" />
                <area shape="rect" coords="428, 810, 747, 1127" />
                <area shape="rect" coords="753, 806, 1009, 1135" />
                <area shape="rect" coords="29, 1131, 351, 1476" />
                <area shape="rect" coords="369, 1146, 691, 1474" />
                <area shape="rect" coords="709, 1147, 996, 1476" />
            </map>
            <?php $i = 7; $sku = getSku($i);?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="19, 173, 325, 461" />
                <area shape="rect" coords="326, 114, 730, 461" />
                <area shape="rect" coords="740, 141, 993, 457" />
                <area shape="rect" coords="28, 487, 350, 834" />
                <area shape="rect" coords="352, 491, 622, 832" />
                <area shape="rect" coords="661, 480, 1021, 838" />
                <area shape="rect" coords="24, 852, 264, 1173" />
                <area shape="rect" coords="275, 879, 727, 1123" />
                <area shape="rect" coords="732, 852, 1012, 1126" />
                <area shape="rect" coords="14, 1179, 375, 1471" />
                <area shape="rect" coords="379, 1194, 648, 1473" />
                <area shape="rect" coords="647, 1125, 1013, 1474" />
            </map>
            <?php $i = 8; $sku = getSku($i);?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="39, 100, 322, 372" />
                <area shape="rect" coords="323, 95, 637, 357" />
                <area shape="rect" coords="642, 106, 1010, 375" />
                <area shape="rect" coords="32, 378, 349, 614" />
                <area shape="rect" coords="352, 375, 654, 626" />
                <area shape="rect" coords="683, 397, 1010, 614" />
                <area shape="rect" coords="47, 617, 344, 897" />
                <area shape="rect" coords="348, 640, 664, 906" />
                <area shape="rect" coords="668, 619, 1013, 920" />
                <area shape="rect" coords="34, 914, 418, 1166" />
                <area shape="rect" coords="433, 941, 664, 1209" />
                <area shape="rect" coords="670, 930, 1010, 1126" />
                <area shape="rect" coords="24, 1169, 339, 1481" />
                <area shape="rect" coords="353, 1214, 671, 1488" />
                <area shape="rect" coords="696, 1129, 1013, 1483" />
            </map>
            <?php $i = 9; $sku = getSku($i);?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="12, 106, 351, 384" />
                <area shape="rect" coords="379, 104, 676, 373" />
                <area shape="rect" coords="727, 94, 1019, 338" />
                <area shape="rect" coords="20, 394, 352, 654" />
                <area shape="rect" coords="355, 376, 670, 708" />
                <area shape="rect" coords="680, 349, 990, 663" />
                <area shape="rect" coords="12, 664, 343, 990" />
                <area shape="rect" coords="355, 715, 649, 1024" />
                <area shape="rect" coords="689, 675, 1012, 938" />
                <area shape="rect" coords="23, 994, 320, 1212" />
                <area shape="rect" coords="331, 1024, 648, 1218" />
                <area shape="rect" coords="654, 945, 1010, 1179" />
                <area shape="rect" coords="23, 1232, 295, 1470" />
                <area shape="rect" coords="304, 1220, 695, 1475" />
                <area shape="rect" coords="704, 1179, 1021, 1485" />
            </map>
            <?php $i = 10; $sku = getSku($i);?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="23, 148, 248, 450" />
                <area shape="rect" coords="316, 112, 661, 430" />
                <area shape="rect" coords="664, 115, 1022, 446" />
                <area shape="rect" coords="7, 565, 230, 953" />
                <area shape="rect" coords="238, 496, 654, 943" />
                <area shape="rect" coords="656, 483, 1019, 948" />
                <area shape="rect" coords="23, 1037, 266, 1473" />
                <area shape="rect" coords="286, 964, 515, 1465" />
                <area shape="rect" coords="527, 969, 832, 1479" />
                <area shape="rect" coords="833, 1059, 1009, 1473" />
            </map>
            <?php $i = 11; $sku = getSku($i);?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="23, 129, 416, 582" />
                <area shape="rect" coords="427, 273, 790, 561" />
                <area shape="rect" coords="792, 141, 1021, 490" />
                <area shape="rect" coords="14, 590, 264, 984" />
                <area shape="rect" coords="280, 624, 546, 896" />
                <area shape="rect" coords="558, 577, 1011, 946" />
                <area shape="rect" coords="26, 1031, 394, 1460" />
                <area shape="rect" coords="395, 947, 622, 1219" />
                <area shape="rect" coords="632, 1085, 1002, 1464" />
            </map>
            <?php $i = 12; $sku = getSku($i);?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="20, 132, 339, 494" />
                <area shape="rect" coords="342, 108, 695, 492" />
                <area shape="rect" coords="769, 122, 1016, 422" />
                <area shape="rect" coords="33, 502, 353, 872" />
                <area shape="rect" coords="358, 494, 690, 876" />
                <area shape="rect" coords="697, 434, 1017, 873" />
                <area shape="rect" coords="77, 877, 775, 1024" />
                <area shape="rect" coords="30, 1061, 507, 1481" />
                <area shape="rect" coords="516, 1029, 1003, 1477" />
            </map>
            <?php $i = 13; $sku = getSku($i);?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="25, 106, 438, 496" />
                <area shape="rect" coords="442, 107, 731, 511" />
                <area shape="rect" coords="743, 122, 1009, 515" />
                <area shape="rect" coords="27, 511, 466, 847" />
                <area shape="rect" coords="544, 521, 1011, 850" />
                <area shape="rect" coords="300, 854, 596, 1071" />
                <area shape="rect" coords="8, 1117, 434, 1484" />
                <area shape="rect" coords="446, 1075, 841, 1471" />
                <area shape="rect" coords="845, 1201, 1023, 1440" />
            </map>
            <?php $i = 14; $sku = getSku($i);?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="23, 97, 382, 588" />
                <area shape="rect" coords="398, 172, 660, 598" />
                <area shape="rect" coords="672, 111, 993, 593" />
                <area shape="rect" coords="25, 588, 330, 1037" />
                <area shape="rect" coords="335, 608, 698, 1028" />
                <area shape="rect" coords="722, 635, 963, 1033" />
                <area shape="rect" coords="20, 1037, 370, 1479" />
                <area shape="rect" coords="393, 1035, 638, 1480" />
                <area shape="rect" coords="661, 1031, 1006, 1480" />
            </map>
            <?php $i = 15; $sku = getSku($i);?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="24, 121, 273, 512" />
                <area shape="rect" coords="279, 160, 494, 510" />
                <area shape="rect" coords="494, 119, 738, 509" />
                <area shape="rect" coords="741, 130, 1003, 506" />
                <area shape="rect" coords="23, 522, 434, 1006" />
                <area shape="rect" coords="441, 511, 741, 1010" />
                <area shape="rect" coords="745, 559, 1011, 1008" />
                <area shape="rect" coords="27, 1025, 354, 1470" />
                <area shape="rect" coords="368, 1028, 656, 1467" />
                <area shape="rect" coords="668, 1032, 1009, 1472" />
            </map>
        </p>
    </div>
    <div class="col-sm-6 maptable">
        <div id="imageMapTable">&nbsp;</div>
    </div>
</div>
<?php } ?>