<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $pages = 11;
    $type = 'handbook';
    $skus = array(
        'P12001' => array(1,2,3,4,5,6),
        'P12002' => array(7,8,9,10,11)
    )
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
    ?>
        <li class="<?php echo $_POST['page']==$i ? 'selected' : ''; ?>" data-type="handbook" data-sku="<?php echo in_array($i, $skus['P12001']) ? 'P12001' : 'P12002' ?>" data-page="<?php echo $i?>" ><a href="#"><?php echo $i; ?></a></li>
    <?php } ?>
</ul>
<div class="clearfix"></div>
<div class="row interactive_table">
    <div class="col-sm-6">
        <div class="image-map-container">
            <?php for ($i=1;$i<=$pages;$i++){  
                $sku = in_array($i, $skus['P12001']) ? 'P12001' : 'P12002'; ?>
                <img class="lazyload <?=$type.$sku.$i ?>" data-src="/images/handbook/cats/interactive_handbook_cats_1500_<?=$i?>.jpg" usemap="#image-map<?=$type.$sku.$i ?>" />
            <?php } ?>
            <div class="map-selector">&nbsp;</div>
        </div>
        <p>
            <?php $i = 2; $sku = in_array($i, $skus['P12001']) ? 'P12001' : 'P12002'; ?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="13, 35, 490, 390" />
                <area shape="rect" coords="493, 44, 1020, 388" />
                <area shape="rect" coords="21, 391, 656, 921" />
                <area shape="rect" coords="661, 443, 991, 924" />
                <area shape="rect" coords="63, 934, 576, 1463" />
                <area shape="rect" coords="578, 950, 1010, 1466" />
            </map>
            <?php $i = 3; $sku = in_array($i, $skus['P12001']) ? 'P12001' : 'P12002'; ?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="91, 25, 510, 457" />
                <area shape="rect" coords="612, 19, 965, 496" />
                <area shape="rect" coords="54, 462, 597, 1020" />
                <area shape="rect" coords="625, 507, 946, 1027" />
                <area shape="rect" coords="36, 1039, 540, 1468" />
                <area shape="rect" coords="570, 1035, 984, 1444" />
            </map>
            <?php $i = 4; $sku = in_array($i, $skus['P12001']) ? 'P12001' : 'P12002'; ?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="18, 15, 409, 464" />
                <area shape="rect" coords="420, 126, 1017, 467" />
                <area shape="rect" coords="36, 473, 425, 890" />
                <area shape="rect" coords="492, 475, 954, 880" />
                <area shape="rect" coords="32, 912, 481, 1466" />
                <area shape="rect" coords="548, 886, 900, 1456" />
            </map>
            <?php $i = 5; $sku = in_array($i, $skus['P12001']) ? 'P12001' : 'P12002'; ?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="67, 40, 409, 430" />
                <area shape="rect" coords="513, 56, 973, 399" />
                <area shape="rect" coords="430, 412, 897, 646" />
                <area shape="rect" coords="14, 466, 304, 987" />
                <area shape="rect" coords="315, 718, 615, 1098" />
                <area shape="rect" coords="687, 650, 987, 1100" />
                <area shape="rect" coords="29, 1050, 307, 1481" />
                <area shape="rect" coords="323, 1137, 637, 1481" />
                <area shape="rect" coords="651, 1115, 1010, 1457" />
            </map>
            <?php $i = 6; $sku = in_array($i, $skus['P12001']) ? 'P12001' : 'P12002'; ?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="34, 42, 667, 395" />
                <area shape="rect" coords="670, 48, 1008, 395" />
                <area shape="rect" coords="51, 449, 521, 859" />
                <area shape="rect" coords="523, 404, 1012, 873" />
                <area shape="rect" coords="50, 998, 218, 1429" />
                <area shape="rect" coords="223, 899, 449, 1431" />
                <area shape="rect" coords="455, 933, 656, 1403" />
                <area shape="rect" coords="656, 969, 1009, 1324" />
            </map>
            <?php $i = 7; $sku = in_array($i, $skus['P12001']) ? 'P12001' : 'P12002'; ?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="171, 65, 633, 556" />
                <area shape="rect" coords="637, 186, 968, 577" />
                <area shape="rect" coords="421, 588, 992, 1070" />
                <area shape="rect" coords="426, 1071, 989, 1468" />
            </map>
            <?php $i = 8; $sku = in_array($i, $skus['P12001']) ? 'P12001' : 'P12002'; ?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="35, 51, 1004, 527" />
                <area shape="rect" coords="63, 570, 320, 1102" />
                <area shape="rect" coords="419, 546, 1002, 923" />
                <area shape="rect" coords="322, 932, 632, 1456" />
                <area shape="rect" coords="652, 941, 1001, 1346" />
            </map>
            <?php $i = 9; $sku = in_array($i, $skus['P12001']) ? 'P12001' : 'P12002'; ?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="19, 42, 579, 544" />
                <area shape="rect" coords="585, 69, 999, 550" />
                <area shape="rect" coords="46, 566, 435, 1053" />
                <area shape="rect" coords="439, 577, 714, 1067" />
                <area shape="rect" coords="744, 570, 1009, 1003" />
                <area shape="rect" coords="49, 1064, 737, 1449" />
                <area shape="rect" coords="747, 1005, 988, 1481" />            
            </map>
            <?php $i = 10; $sku = in_array($i, $skus['P12001']) ? 'P12001' : 'P12002'; ?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="35, 159, 687, 591" />
                <area shape="rect" coords="710, 41, 987, 602" />
                <area shape="rect" coords="48, 599, 479, 952" />
                <area shape="rect" coords="514, 609, 973, 951" />
                <area shape="rect" coords="104, 985, 568, 1448" />
                <area shape="rect" coords="573, 956, 967, 1467" />            
            </map>
            <?php $i = 11; $sku = in_array($i, $skus['P12001']) ? 'P12001' : 'P12002'; ?>
            <map style="<?php echo $_POST['page']==$i ? '' : 'display:none;'; ?>" id="image-map<?=$type.$sku.$i ?>" name="image-map<?=$type.$sku.$i ?>">
                <area shape="rect" coords="35, 40, 507, 500" />
                <area shape="rect" coords="534, 22, 986, 533" />
                <area shape="rect" coords="39, 519, 492, 926" />
                <area shape="rect" coords="523, 556, 982, 896" />
                <area shape="rect" coords="30, 935, 445, 1461" />
                <area shape="rect" coords="447, 972, 674, 1467" />
                <area shape="rect" coords="691, 982, 989, 1462" />          
            </map>
        </p>
    </div>
    <div class="col-sm-6 maptable">
        <div id="imageMapTable">&nbsp;</div>
    </div>
</div>
<?php } ?>