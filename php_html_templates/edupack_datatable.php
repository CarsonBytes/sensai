<?php
// No direct access
defined('_JEXEC') or die;

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
            <a href="#" class="toggle_handbook" data-state="0" data-init="0">
                <i class="fas fa-book-open"></i> Toggle Handbook preview
            </a>
        </span>
    </span>
    <span>
        <span>
            <a href="#" class="toggle_interactive_table" data-state="0" data-init="0">
                Toggle interactive learning materials
                &nbsp;<i class="fas fa-caret-right"></i><i class="fas fa-caret-down" style="display:none;"></i>
            </a>
        </span>
    </span>
</div>
<div class='imageMapWrapper'></div>