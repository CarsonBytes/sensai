<?php
// No direct access
defined('_JEXEC') or die;

include JPATH_SITE . '/php_html_templates/functions.php';

?>
<style>
    .btn_to_amazon.to_view {
        text-align: center;
        float: right;
    }

    .btn_to_amazon .a-button-inner img {
        display: block;
        position: absolute;
        top: 2px;
        left: 2px;
        width: 25px;
        height: 25px;
        border-radius: 2px;
    }

    .item-page {
        max-width: 1000px;
        margin: 0 auto;
    }

    .item-page .articlebody {
        padding: 0;
    }

    .main_content img {
        width: 150px;
        float: left;
        height: auto;
        margin-right: 20px;
    }

    .main_content p {
        text-align: justify;
    }
</style>
<?php
$promos = getFilePaths();
?>
<div class="free_items col-sm-12 col-md-12 col-lg-12">
    <div class="free_items_wrapper">
        <?php $j = 0;
        foreach ($promos as $promo) {
            $file_params = json_decode($promo->params);
            $download_status = getUserFileDownloadStatus($promo);
            $is_pdf_prompt = isset($download_status['prompt']);
        ?>

            <?php if ($is_pdf_prompt) { ?>
                <script>
                    var prompt = <?php echo json_encode($download_status['prompt']) ?>;
                    jQuery(function($) {
                        $('body').on('click', '.to_view.pdf_<?php echo $promo->code; ?>', function(e) {
                            e.preventDefault();
                            var htmlOutput = $.templates("#modal_dialog_tpl").render(prompt);
                            $('.modal.dialog').html(htmlOutput).modal();
                        }).on('click', '.dl_anyways, .take_me_there', function() {
                            $('.modal.dialog').modal('hide');
                            window.open($(this).data('link'), $(this).data('target'));
                        });
                    });
                </script>
            <?php } ?>

            <div class="free_item">
                <div class="col-xs-12 col-md-12 main_content_col">
                    <div class="main_content">
                        <h1 itemprop="name" class="product-title"><?php echo $file_params->title; ?></h1>
                        <img src="<?php echo $file_params->thumb; ?>" />
                        <?php echo $file_params->introtext; ?>
                        <a href="<?php echo $is_pdf_prompt ? '#' : $download_status['link'] ?>" class="btn_to_amazon to_view pdf_<?php echo $promo->code; ?>" >
                            <span class="a-button-inner">
                                <img src="<?php echo JUri::base() . 'images/icon/sensai_more.svg' ?>" />
                                <input title="View" class="a-button-input" type="button" aria-labelledby="a-autoid-1-announce">
                                <span class="a-button-text" aria-hidden="true" id="a-autoid-1-announce">
                                    GET IT NOW
                                </span>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr />
            </div>
        <?php
            $j++;
        }
        ?>
    </div>
</div>
<div class="clearfix"></div>

<?php
