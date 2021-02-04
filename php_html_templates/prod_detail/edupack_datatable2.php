<?php
// No direct access
defined('_JEXEC') or die;

require_once(JPATH_SITE . '/php_html_templates/functions.php');

$document = JFactory::getDocument();

$document->addStyleSheet('https://cdn.jsdelivr.net/combine/npm/tabulator-tables@4/dist/css/tabulator.min.css');

//$document->addStyleSheet('https://cdn.jsdelivr.net/npm/mediaelement@4/build/mediaelementplayer.min.css');
$document->addStyleSheet('/css/mediaelementplayer.css');

$document->addScript('https://cdn.jsdelivr.net/combine/npm/tabulator-tables@4,npm/image-map-resizer@1.0.10,npm/mediaelement@4/build/mediaelement-and-player.min.js');
//$document->addScript('/js/edupack_datatable.js');
$document->addScript('/js/edupack_datatable2.js');


//if (!isset($sku)) $sku = 'P12004';
switch ($chart_params->chart_skus[0]) {
    case 'A0B_10630':
        $sku = "P12001";
        break;
    case 'A0B_10610':
        $sku = "P12003";
        break;
    default:
        $sku = "P12001";
        break;
}

/**
 * TODO dynamic pdf code
 */
$pdf_code = 'test';
$download_status = getUserFileDownloadStatus(getFilePath($pdf_code));
$is_pdf_prompt = isset($download_status['prompt']);
?>
<script>
	var locale = '<?php echo JFactory::getLanguage()->getTag();?>' ;
</script>
<style>
    .maptable {
        height: 95vh;
    }

    .edupack_button {
        padding-top: 4px;
        margin-top: 0 !important;
    }

    .edupack_button>span {
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
        margin: 5px 0;
    }

    .edupack_button>span:active,
    .edupack_button>span:active:hover {
        border-color: #a2a6ac #979aa1 #82858a;
    }

    .edupack_button>span:active>span {
        box-shadow: 0 1px 3px rgba(0, 0, 0, .2) inset;
        background-color: #e7e9ec;
        background-image: none;
    }

    .edupack_button>span>span {
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

    .edupack_button>span:hover>span {
        background: #e0e3e8;
        background: -webkit-linear-gradient(top, #e7eaf0, #d9dce1);
        background: linear-gradient(to bottom, #e7eaf0, #d9dce1);
    }

    .edupack_button a {
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

    .tabulator-row.tabulator-selectable:hover {
        cursor: auto;
    }
</style>

<?php if ($is_pdf_prompt) { ?>
    <script>
        var prompt = <?php echo json_encode($download_status['prompt']) ?>;
        jQuery(function($) {
            $('body').on('click', 'a.download_pdf', function(e) {
                e.preventDefault();
                var htmlOutput = $.templates("#modal_dialog_tpl").render(prompt);
                $('.modal.dialog').html(htmlOutput).modal();
            }).on('click', '.dl_anyways, .take_me_there', function() {
                $('.modal.dialog').modal('hide');
                window.open($(this).data('link'),$(this).data('target')); 
            });
        });
    </script>
<?php } ?>

<div class="edupack_button" style="display:none;">
    <span>
        <span>
            <a href="#" class="toggle_interactive_table" data-state="0" data-type="edupack" data-sku="<?php echo $sku; ?>" data-page="">
                Toggle interactive posters
                &nbsp;<i class="fas fa-caret-right"></i><i class="fas fa-caret-down" style="display:none;"></i>
            </a>
        </span>
    </span>
    <span>
        <span>
            <a href="<?php echo $is_pdf_prompt ? '#' : $download_status['link'] ?>" target="_blank" class="download_pdf">
                <?php echo $download_status['is_redownload'] ? 'Re-' : ''; ?>Download PDF
                &nbsp;<i class="fas fa-download"></i>
            </a>
        </span>
    </span>

    <?php /*<span>
        <span>
            <a href="#" class="toggle_interactive_table" data-state="0" data-type="handbook" data-sku="<?php echo $sku; ?>" data-page="2">
                Toggle interactive handbooks
                &nbsp;<i class="fas fa-caret-right"></i><i class="fas fa-caret-down" style="display:none;"></i>
            </a>
        </span>
    </span>
    <span>
        <span>
            <a href="#" target="_blank" class="toggle_handbook" data-sku="<?php echo $sku; ?>" data-state="0">
                <i class="fas fa-book-open"></i> Toggle Handbook preview
            </a>
        </span>
    </span>*/ ?>
</div>

<div class='imageMapWrapper'></div>