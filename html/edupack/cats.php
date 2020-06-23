<?php
if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
) {
    $pages = ['P12001','P12002'];
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
                <img data-sku="<?=$page?>" class="<?php echo $_POST['sku']==$page ? '' : ''; ?>" src="/images/poster/edupack/cat/<?=$page?>_1500.jpg" usemap="#image-map<?=$page?>" />
            <?php } ?>
            <div class="map-selector">&nbsp;</div>
        </div>
        <p>
            <map style="<?php echo $_POST['sku']==$pages[0] ? '' : 'display:none;'; ?>" id="image-map<?=$pages[0]?>" name="image-map<?=$pages[0]?>">
                <area shape="rect" coords="71, 136, 284, 355" />
                <area shape="rect" coords="290, 188, 463, 352" />
                <area shape="rect" coords="475, 194, 646, 354" />
                <area shape="rect" coords="650, 141, 826, 353" />
                <area shape="rect" coords="837, 144, 990, 355" />
                <area shape="rect" coords="72, 359, 218, 572" />
                <area shape="rect" coords="222, 358, 395, 567" />
                <area shape="rect" coords="402, 393, 660, 561" />
                <area shape="rect" coords="664, 385, 747, 566" />
                <area shape="rect" coords="745, 355, 895, 502" />
                <area shape="rect" coords="900, 361, 997, 549" />
                <area shape="rect" coords="66, 596, 244, 799" />
                <area shape="rect" coords="244, 579, 436, 801" />
                <area shape="rect" coords="439, 569, 514, 805" />
                <area shape="rect" coords="517, 571, 611, 804" />
                <area shape="rect" coords="612, 568, 732, 803" />
                <area shape="rect" coords="730, 570, 834, 769" />
                <area shape="rect" coords="839, 554, 989, 741" />
                <area shape="rect" coords="75, 801, 239, 1004" />
                <area shape="rect" coords="240, 865, 453, 1006" />
                <area shape="rect" coords="454, 805, 576, 995" />
                <area shape="rect" coords="584, 817, 748, 992" />
                <area shape="rect" coords="751, 798, 993, 991" />
                <area shape="rect" coords="78, 1011, 274, 1221" />
                <area shape="rect" coords="274, 1006, 468, 1223" />
                <area shape="rect" coords="468, 1006, 583, 1223" />
                <area shape="rect" coords="590, 997, 704, 1231" />
                <area shape="rect" coords="710, 996, 864, 1216" />
                <area shape="rect" coords="867, 1007, 981, 1222" />
                <area shape="rect" coords="78, 1229, 219, 1434" />
                <area shape="rect" coords="232, 1223, 352, 1435" />
                <area shape="rect" coords="354, 1232, 461, 1430" />
                <area shape="rect" coords="464, 1228, 591, 1433" />
                <area shape="rect" coords="592, 1234, 736, 1431" />
                <area shape="rect" coords="739, 1225, 991, 1436" />
            </map>
            <map style="<?php echo $_POST['sku']==$pages[1] ? '' : 'display:none;'; ?>" id="image-map<?=$pages[1]?>" name="image-map<?=$pages[1]?>"> 
                <area shape="rect" coords="117, 113, 348, 311" />
                
                <area shape="rect" coords="352, 126, 492, 311" />
                
                <area shape="rect" coords="514, 104, 722, 318" />
                
                <area shape="rect" coords="744, 130, 962, 317" />
                
                <area shape="rect" coords="81, 317, 251, 547" />
                
                <area shape="rect" coords="253, 318, 359, 529" />
                
                <area shape="rect" coords="361, 323, 562, 529" />
                
                <area shape="rect" coords="564, 338, 860, 528" />
                
                <area shape="rect" coords="865, 337, 989, 527" />
                
                <area shape="rect" coords="71, 599, 325, 770" />
                
                <area shape="rect" coords="327, 530, 473, 734" />
                
                <area shape="rect" coords="479, 537, 647, 793" />
                
                <area shape="rect" coords="654, 543, 821, 778" />
                
                <area shape="rect" coords="833, 529, 987, 757" />
                
                <area shape="rect" coords="84, 777, 213, 1009" />
                
                <area shape="rect" coords="216, 782, 416, 986" />
                
                <area shape="rect" coords="420, 831, 555, 991" />
                
                <area shape="rect" coords="558, 824, 692, 984" />
                
                <area shape="rect" coords="701, 787, 983, 971" />
                
                <area shape="rect" coords="69, 1054, 256, 1216" />
                
                <area shape="rect" coords="260, 1000, 620, 1211" />
                
                <area shape="rect" coords="620, 985, 788, 1190" />
                
                <area shape="rect" coords="796, 979, 994, 1188" />
                
                <area shape="rect" coords="68, 1243, 243, 1434" />
                
                <area shape="rect" coords="276, 1219, 424, 1436" />
                
                <area shape="rect" coords="428, 1211, 537, 1437" />
                
                <area shape="rect" coords="543, 1215, 718, 1428" />
                
                <area shape="rect" coords="722, 1229, 844, 1427" />
                
                <area shape="rect" coords="852, 1189, 993, 1431" />
            </map>
        </p>
    </div>
    <div class="col-sm-6 maptable">
        <div id="imageMapTable">&nbsp;</div>
    </div>
</div>
<? } ?>