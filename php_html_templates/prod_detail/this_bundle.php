<?php
// No direct access
defined('_JEXEC') or die;

$this_bundle_img_names = array();
$this_bundle_gallery_mapping = array();
if ($product_type == 'chart') {
    $this_bundle_img_names = $chart_params->img_names;
} else if ($product_type == 'bundle') {
    $this_bundle_img_names = $bundle_params->img_names;
    $this_bundle_gallery_mapping = $bundle_params->gallery_mapping;
}

?>
<style>
    @media (min-width: 992px) {
        .this_bundle .deco_bundles_wrapper .deco_bundles .deco_bundle_wrapper .deco_bundle {

            margin: 0;
        }

        .this_bundle .deco_bundles_wrapper .deco_bundles .deco_bundle_wrapper .deco_bundle .col_2 {
            padding: 0;
        }

        .this_bundle .deco_bundles_wrapper .deco_bundles .deco_bundle_wrapper {
            border: 0;
            padding: 0;
        }

        .this_bundle .deco_bundles_wrapper .deco_bundles .deco_bundle_wrapper .deco_bundle .col_2 .deco_thumbs .img_link {
            cursor: pointer;
        }

        .this_bundle .deco_bundles_wrapper .deco_bundles .deco_bundle_wrapper .deco_bundle .col_2 .deco_thumbs.chart {
            justify-content: flex-start;
            margin: 0 -25px;
        }

        .this_bundle .deco_bundles_wrapper .deco_bundles .deco_bundle_wrapper .deco_bundle .col_2 .deco_thumbs.chart .img_link {
            padding: 0 25px;
        }

        .this_bundle .deco_bundles_wrapper .deco_bundles .deco_bundle_wrapper .deco_bundle .col_2 .deco_thumbs .img_link.is_chart {
            position: relative;
        }

        .this_bundle .deco_bundles_wrapper .deco_bundles .deco_bundle_wrapper .deco_bundle .col_2 .deco_thumbs .img_link.is_chart i.fas.fa-volume-up {
            padding: 5px;
            background: #C60;
            color: white;
            position: absolute;
            bottom: 0;
            right: 0;
        }

        .this_bundle .deco_bundles_wrapper .deco_bundles .deco_bundle_wrapper .deco_bundle .col_2 .deco_thumbs .img_link.is_chart:hover i.fas.fa-volume-up {
            background: #c45500 !important;
        }
    }
</style>
<script>
    jQuery(function($) {
        $('body').on('click', 'a.img_link.in_bundle', function(e) {
            e.preventDefault();
            var target_img = $('.slider_md_whole_wrapper:visible .slider_md_thumbnails_wrapper').find("img[src*='" + $(this).data('gallery') + "']");

            if ($('.slider_md_whole_wrapper:visible').hasClass('slider_1')) {
                slider_md.goTo(target_img.parents('li').data('nav'));
            } else {
                slider_md_2.goTo(target_img.parents('li').data('nav'));
            }
        })
    })
</script>
<div class="row this_bundle">
    <div class="col-xs-12 deco_bundles_wrapper">
        <div class="deco_bundles">
            <h2>This Bundle</h2>
            <div class="deco_bundle_wrapper">
                <div class="deco_bundle hidden-sm hidden-xs">
                    <div class="col_2 hidden-sm hidden-xs">
                        <div class="deco_thumbs <?php echo $product_type; ?>">
                            <?php if (isset($charts_params)) {
                                foreach ($charts_params as $charts_param) {
                                    foreach ($charts_param->img_names as $img_name) {
                            ?>
                                        <div class="img_link is_chart">
                                            <i class="fas fa-volume-up"></i>
                                            <div class="img_wrapper">
                                                <a target="_blank" href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $charts_param->chart_j2_store_product_id); ?>">
                                                    <img class="lazyload" data-src="<?php echo getImgSizeUrl($img_name, 'S') ?>" />
                                                </a>
                                            </div>
                                        </div>
                            <?php
                                    }
                                }
                            }
                            ?>

                            <?php
                            $i = 0;
                            foreach ($this_bundle_img_names as $img_name) {
                            ?>
                                <a class="img_link in_bundle" href="#" data-gallery="<?php echo isset($this_bundle_gallery_mapping[$i]) ? $this_bundle_gallery_mapping[$i] : ''; ?>">
                                    <div class="img_wrapper">
                                        <img class="lazyload" data-src="<?php echo getImgSizeUrl($img_name, 'S') ?>" />
                                    </div>
                                </a>
                            <?php
                                $i++;
                            }
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>