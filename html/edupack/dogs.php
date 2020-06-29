<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $pages = ['P12003','P12004','P12005'];
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
    <?php $i=1;
    foreach($pages as $page){  ?>
        <li class="<?php echo $_POST['sku']==$page ? 'selected' : ''; ?>" data-page="<?php echo $page?>"><a href="#"><?php echo $i; ?></a></li>
    <?php $i++; } ?>
</ul>
<div class="clearfix"></div>
<div class="row interactive_table">
    <div class="col-sm-6">
        <div class="image-map-container">
            <?php foreach($pages as $page){  ?>
                <img data-sku="<?=$page?>" class="<?php echo $_POST['sku']==$page ? '' : ''; ?>" src="/images/poster/edupack/dog/<?=$page?>_1500.jpg" usemap="#image-map<?=$page?>" />
            <?php } ?>
            <div class="map-selector">&nbsp;</div>
        </div>
        <p>
            <map style="<?php echo $_POST['sku']==$pages[0] ? '' : 'display:none;'; ?>" id="image-map<?=$pages[0]?>" name="image-map<?=$pages[0]?>">
                <area shape="rect" coords="108, 162, 255, 349" />
                <area shape="rect" coords="260, 251, 359, 390" />
                <area shape="rect" coords="361, 165, 485, 281" />
                <area shape="rect" coords="494, 197, 591, 284" />
                <area shape="rect" coords="613, 159, 741, 280" />
                <area shape="rect" coords="744, 162, 874, 282" />
                <area shape="rect" coords="887, 161, 972, 292" />
                <area shape="rect" coords="392, 297, 521, 399" />
                <area shape="rect" coords="538, 286, 647, 393" />
                <area shape="rect" coords="661, 284, 758, 392" />
                <area shape="rect" coords="772, 289, 876, 402" />
                <area shape="rect" coords="880, 294, 988, 411" />
                <area shape="rect" coords="112, 390, 287, 600" />
                <area shape="rect" coords="339, 405, 520, 541" />
                <area shape="rect" coords="532, 397, 668, 524" />
                <area shape="rect" coords="676, 417, 757, 529" />
                <area shape="rect" coords="775, 407, 880, 529" />
                <area shape="rect" coords="893, 416, 985, 529" />
                <area shape="rect" coords="290, 546, 374, 629" />
                <area shape="rect" coords="380, 550, 511, 624" />
                <area shape="rect" coords="536, 524, 655, 637" />
                <area shape="rect" coords="702, 551, 799, 648" />
                <area shape="rect" coords="831, 543, 974, 643" />
                <area shape="rect" coords="103, 613, 233, 772" />
                <area shape="rect" coords="241, 655, 342, 774" />
                <area shape="rect" coords="362, 628, 493, 772" />
                <area shape="rect" coords="510, 639, 635, 768" />
                <area shape="rect" coords="637, 653, 747, 771" />
                <area shape="rect" coords="757, 651, 878, 771" />
                <area shape="rect" coords="881, 647, 987, 769" />
                <area shape="rect" coords="97, 840, 270, 996" />
                <area shape="rect" coords="272, 844, 414, 987" />
                <area shape="rect" coords="423, 858, 492, 991" />
                <area shape="rect" coords="520, 855, 655, 941" />
                <area shape="rect" coords="698, 862, 780, 972" />
                <area shape="rect" coords="794, 829, 982, 975" />
                <area shape="rect" coords="101, 1002, 207, 1093" />
                <area shape="rect" coords="214, 1002, 309, 1092" />
                <area shape="rect" coords="368, 998, 489, 1095" />
                <area shape="rect" coords="495, 942, 694, 1094" />
                <area shape="rect" coords="725, 975, 884, 1132" />
                <area shape="rect" coords="886, 978, 986, 1171" />
                <area shape="rect" coords="104, 1093, 313, 1257" />
                <area shape="rect" coords="318, 1134, 450, 1247" />
                <area shape="rect" coords="451, 1095, 602, 1232" />
                <area shape="rect" coords="605, 1101, 719, 1231" />
                <area shape="rect" coords="750, 1143, 872, 1279" />
                <area shape="rect" coords="876, 1173, 986, 1280" />
                <area shape="rect" coords="100, 1271, 246, 1410" />
                <area shape="rect" coords="249, 1259, 388, 1411" />
                <area shape="rect" coords="389, 1252, 579, 1411" />
                <area shape="rect" coords="582, 1235, 735, 1404" />
                <area shape="rect" coords="736, 1280, 849, 1404" />
                <area shape="rect" coords="853, 1282, 991, 1406" />
            </map>
            <map style="<?php echo $_POST['sku']==$pages[1] ? '' : 'display:none;'; ?>" id="image-map<?=$pages[1]?>" name="image-map<?=$pages[1]?>"> 
                <area shape="rect" coords="78, 109, 234, 259" />
                <area shape="rect" coords="245, 118, 369, 259" />
                <area shape="rect" coords="403, 145, 537, 260" />
                <area shape="rect" coords="552, 139, 679, 260" />
                <area shape="rect" coords="683, 115, 870, 257" />
                <area shape="rect" coords="874, 129, 983, 253" />
                <area shape="rect" coords="76, 264, 256, 396" />
                <area shape="rect" coords="266, 269, 420, 408" />
                <area shape="rect" coords="422, 267, 546, 431" />
                <area shape="rect" coords="553, 269, 677, 432" />
                <area shape="rect" coords="679, 276, 815, 418" />
                <area shape="rect" coords="829, 260, 993, 398" />
                <area shape="rect" coords="79, 400, 249, 544" />
                <area shape="rect" coords="253, 414, 407, 542" />
                <area shape="rect" coords="407, 435, 532, 539" />
                <area shape="rect" coords="538, 434, 735, 558" />
                <area shape="rect" coords="739, 462, 833, 565" />
                <area shape="rect" coords="847, 401, 993, 531" />
                <area shape="rect" coords="78, 551, 222, 695" />
                <area shape="rect" coords="225, 545, 373, 700" />
                <area shape="rect" coords="378, 547, 486, 698" />
                <area shape="rect" coords="500, 567, 677, 700" />
                <area shape="rect" coords="693, 569, 836, 702" />
                <area shape="rect" coords="837, 534, 1000, 699" />
                <area shape="rect" coords="71, 774, 204, 916" />
                <area shape="rect" coords="232, 787, 348, 915" />
                <area shape="rect" coords="366, 773, 511, 912" />
                <area shape="rect" coords="533, 777, 661, 911" />
                <area shape="rect" coords="687, 766, 845, 895" />
                <area shape="rect" coords="862, 782, 974, 889" />
                <area shape="rect" coords="75, 921, 225, 1037" />
                <area shape="rect" coords="238, 923, 358, 1033" />
                <area shape="rect" coords="376, 922, 499, 1037" />
                <area shape="rect" coords="509, 914, 671, 1027" />
                <area shape="rect" coords="674, 901, 845, 1026" />
                <area shape="rect" coords="861, 891, 991, 1031" />
                <area shape="rect" coords="71, 1039, 233, 1178" />
                <area shape="rect" coords="251, 1044, 380, 1181" />
                <area shape="rect" coords="390, 1042, 546, 1183" />
                <area shape="rect" coords="573, 1031, 705, 1180" />
                <area shape="rect" coords="737, 1040, 848, 1182" />
                <area shape="rect" coords="878, 1042, 988, 1171" />
                <area shape="rect" coords="79, 1181, 208, 1307" />
                <area shape="rect" coords="212, 1192, 326, 1298" />
                <area shape="rect" coords="348, 1185, 475, 1302" />
                <area shape="rect" coords="480, 1185, 600, 1308" />
                <area shape="rect" coords="605, 1184, 720, 1304" />
                <area shape="rect" coords="734, 1186, 838, 1303" />
                <area shape="rect" coords="886, 1176, 983, 1299" />
                <area shape="rect" coords="70, 1307, 274, 1438" />
                <area shape="rect" coords="277, 1304, 459, 1438" />
                <area shape="rect" coords="464, 1310, 613, 1431" />
                <area shape="rect" coords="614, 1305, 833, 1433" />
                <area shape="rect" coords="838, 1301, 990, 1432" />
            </map>
            <map style="<?php echo $_POST['sku']==$pages[2] ? '' : 'display:none;'; ?>" id="image-map<?=$pages[2]?>" name="image-map<?=$pages[2]?>"> 
                <area shape="rect" coords="82, 138, 180, 273" />
                <area shape="rect" coords="195, 118, 322, 270" />
                <area shape="rect" coords="331, 122, 447, 268" />
                <area shape="rect" coords="451, 115, 619, 272" />
                <area shape="rect" coords="620, 113, 829, 284" />
                <area shape="rect" coords="835, 120, 980, 264" />
                <area shape="rect" coords="72, 296, 205, 407" />
                <area shape="rect" coords="205, 278, 386, 404" />
                <area shape="rect" coords="394, 277, 570, 406" />
                <area shape="rect" coords="577, 288, 690, 403" />
                <area shape="rect" coords="714, 288, 822, 404" />
                <area shape="rect" coords="855, 286, 980, 398" />
                <area shape="rect" coords="76, 418, 191, 552" />
                <area shape="rect" coords="206, 406, 313, 551" />
                <area shape="rect" coords="324, 429, 467, 563" />
                <area shape="rect" coords="472, 423, 543, 558" />
                <area shape="rect" coords="551, 409, 768, 558" />
                <area shape="rect" coords="769, 439, 859, 552" />
                <area shape="rect" coords="865, 399, 994, 548" />
                <area shape="rect" coords="828, 633, 993, 815" />
                <area shape="rect" coords="697, 623, 822, 812" />
                <area shape="rect" coords="540, 620, 691, 794" />
                <area shape="rect" coords="382, 641, 537, 792" />
                <area shape="rect" coords="224, 634, 379, 802" />
                <area shape="rect" coords="82, 649, 220, 798" />
                <area shape="rect" coords="99, 801, 229, 953" />
                <area shape="rect" coords="249, 842, 386, 954" />
                <area shape="rect" coords="414, 796, 549, 952" />
                <area shape="rect" coords="562, 816, 725, 1002" />
                <area shape="rect" coords="728, 824, 879, 1000" />
                <area shape="rect" coords="886, 831, 983, 1001" />
                <area shape="rect" coords="77, 954, 258, 1126" />
                <area shape="rect" coords="264, 957, 431, 1127" />
                <area shape="rect" coords="439, 954, 556, 1126" />
                <area shape="rect" coords="583, 1000, 699, 1126" />
                <area shape="rect" coords="708, 1011, 848, 1128" />
                <area shape="rect" coords="853, 1002, 984, 1128" />
                <area shape="rect" coords="71, 1199, 169, 1310" />
                <area shape="rect" coords="176, 1212, 263, 1307" />
                <area shape="rect" coords="275, 1202, 376, 1312" />
                <area shape="rect" coords="382, 1223, 458, 1310" />
                <area shape="rect" coords="465, 1226, 537, 1317" />
                <area shape="rect" coords="540, 1212, 636, 1312" />
                <area shape="rect" coords="639, 1213, 722, 1314" />
                <area shape="rect" coords="738, 1211, 824, 1312" />
                <area shape="rect" coords="825, 1207, 899, 1312" />
                <area shape="rect" coords="906, 1202, 999, 1310" />
                <area shape="rect" coords="78, 1312, 215, 1433" />
                <area shape="rect" coords="232, 1311, 340, 1430" />
                <area shape="rect" coords="343, 1326, 449, 1433" />
                <area shape="rect" coords="457, 1332, 546, 1431" />
                <area shape="rect" coords="558, 1334, 613, 1430" />
                <area shape="rect" coords="632, 1318, 719, 1432" />
                <area shape="rect" coords="723, 1321, 819, 1434" />
                <area shape="rect" coords="826, 1317, 896, 1432" />
                <area shape="rect" coords="899, 1315, 1004, 1434" />
            </map>
        </p>
    </div>
    <div class="col-sm-6 maptable">
        <div id="imageMapTable">&nbsp;</div>
    </div>
</div>
<? } ?>