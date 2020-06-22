<?php

$document = JFactory::getDocument();

$document->addStyleSheet('https://cdn.jsdelivr.net/combine/npm/tabulator-tables@4/dist/css/tabulator.min.css');
$document->addStyleSheet('https://cdn.jsdelivr.net/npm/mediaelement@4/build/mediaelementplayer.min.css');

$document->addScript('https://cdn.jsdelivr.net/combine/npm/tabulator-tables@4,npm/image-map-resizer@1.0.10,npm/mediaelement@4/build/mediaelement-and-player.min.js');
$document->addScript('/js/edupack_datatable.js');

?>
<style>
    .maptable {
        height: 95vh;
    }

    .interactive_table {
        display: none;
    }

    .button {
        padding-top: 4px;
        margin-top: 0 !important;
    }

    .button>span {
        background: #e7e9ec;
        border-radius: 3px;
        border-color: #ADB1B8 #A2A6AC #8D9096;
        border-style: solid;
        border-width: 1px;
        cursor: pointer;
        display: inline-block;
        padding: 0;
        text-align: center;
        text-decoration: none !important;
        vertical-align: middle;
    }

    .button>span:active,
    .button>span:active:hover {
        border-color: #a2a6ac #979aa1 #82858a;
    }

    .button>span:active>span {
        box-shadow: 0 1px 3px rgba(0, 0, 0, .2) inset;
        background-color: #e7e9ec;
        background-image: none;
    }

    .button>span>span {
        background: #eff1f3;
        background: -webkit-linear-gradient(top, #f7f8fa, #e7e9ec);
        background: linear-gradient(to bottom, #f7f8fa, #e7e9ec);
        display: block;
        position: relative;
        overflow: hidden;
        height: 29px;
        box-shadow: 0 1px 0 rgba(255, 255, 255, .6) inset;
        border-radius: 2px;
    }

    .button>span:hover>span {
        background: #e0e3e8;
        background: -webkit-linear-gradient(top, #e7eaf0, #d9dce1);
        background: linear-gradient(to bottom, #e7eaf0, #d9dce1);
    }

    .button a {
        color: #111;
        background-color: transparent;
        border: 0;
        display: block;
        font-size: 14px;
        line-height: 29px;
        margin: 0;
        outline: 0;
        padding: 0 10px 0 11px;
        text-align: center;
        white-space: nowrap;
        width: 100%;
        height: 100%;
    }
</style>
<div class="button">
    <span>
        <span>
            <a href="#" class="toggle_interactive_table" data-state="0" data-init="0">
                Toggle interactive learning materials
                &nbsp;<i class="fas fa-caret-right"></i><i class="fas fa-caret-down" style="display:none;"></i>
            </a>
        </span>
    </span>
</div>
<div class="row interactive_table">
    <div class="col-sm-6">
        <div class="image-map-container">
            <img class="lazyload" data-src="/images/poster/edupack/cat/P12001_1500.jpg" alt="" usemap="#image-map" />
            <div class="map-selector">&nbsp;</div>
        </div>
        <p>
            <map id="image-map" name="image-map">
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
            </map></p>
    </div>
    <div class="col-sm-6 maptable">
        <div id="imageMapTable">&nbsp;</div>
    </div>
</div>