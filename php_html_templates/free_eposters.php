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

    .main_content h3.product-title:hover {
        color: #444;
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

    strong {
        color: red;
    }

    h3 {
        margin: 5px 0;
    }
</style>
<script>
    jQuery(function($) {
        $('body')
            .on('click', '.to_view', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var code = $(this).data('code');
                var loader = $(this).find('.loader');
                var icon_display = $(this).find('.icon_display');
                if (loader.is(':visible')) return false;
                $.ajax({
                    type: "POST",
                    url: "/ajax/eposter_link.php",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    beforeSend: function() {
                        loader.show();
                        icon_display.css('visibility', 'hidden');
                    },
                    success: function(result) {
                        if (result.status == 1) {
                            result.prompt.btns[0].link += code;
                            var htmlOutput = $.templates("#modal_dialog_tpl").render(result['prompt']);
                            $('.modal.dialog').html(htmlOutput).modal();
                        } else if (result.status == 0) {
                            window.location.href = result.link + code;
                        } else if (result.status == -3 || result.status == -5) {
                            var htmlOutput = $.templates("#modal_dialog_tpl").render(result['prompt']);
                            $('.modal.dialog').html(htmlOutput).modal();
                        }
                        loader.hide();
                        icon_display.css('visibility', 'visible');
                    }
                });
            }).on('click', '.dl_the_file, .take_me_there', function() {
                $('.modal.dialog').modal('hide');
                window.open($(this).data('link'), $(this).data('target'));
            })
    });
</script>
<?php
$promos = getFilePaths();
?>
<div class="free_items">
    <div class="free_items_wrapper">
        <?php $j = 0;
        foreach ($promos as $promo) {
            if (!isset($promo->title) && $promo->title=='') continue;
        ?>
            <div class="free_item">
                <div class="main_content_col">
                    <div class="main_content">
                        <h1 itemprop="name" class="product-title"><?php echo $promo->title; ?></h1>
                        <img src="<?php echo $promo->thumb; ?>" />
                        <?php echo $promo->introtext; ?>
                        <a data-code="<?php echo $promo->code; ?>" data-id="<?php echo $promo->id; ?>" href="#" class="btn_to_amazon to_view">
                            <span class="a-button-inner">
                                <img class="icon_display" src="<?php echo JUri::base() . 'images/icon/sensai_more.svg' ?>" />
                                <input title="View" class="a-button-input" type="button" aria-labelledby="a-autoid-1-announce">
                                <div style="margin: 10px auto;font-size: 3px;display:none;" class="loader">Loading...</div>
                                <span class="a-button-text icon_display" aria-hidden="true" id="a-autoid-1-announce">
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
