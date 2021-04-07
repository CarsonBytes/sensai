<?php
// No direct access
defined('_JEXEC') or die;

$this_bundle_img_names = array();
$this_bundle_gallery_mapping = array();
if ($product_type == 'chart') {
    //$this_bundle_img_names = $chart_params->img_names;
} else if ($product_type == 'bundle' && isset($bundle_params)) {
    $this_bundle_img_names = $bundle_params->img_names;
    $this_bundle_gallery_mapping = $bundle_params->gallery_mapping;
} else {
    return;
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

        .this_bundle .deco_bundles_wrapper .deco_bundles .deco_bundle_wrapper .deco_bundle .col_2 .deco_thumbs .img_link.is_chart .img_wrapper {
            position: relative;
        }

        .this_bundle .deco_bundles_wrapper .deco_bundles .deco_bundle_wrapper .deco_bundle .col_2 .deco_thumbs .img_link .img_wrapper i.fas.fa-volume-up {
            display: none;
        }

        .this_bundle .deco_bundles_wrapper .deco_bundles .deco_bundle_wrapper .deco_bundle .col_2 .deco_thumbs .img_link.is_chart .img_wrapper i.fas.fa-volume-up {
            display: block;
            padding: 5px;
            background: #C60;
            color: white;
            position: absolute;
            bottom: 0;
            right: 0;
        }

        .this_bundle .deco_bundles_wrapper .deco_bundles .deco_bundle_wrapper .deco_bundle .col_2 .deco_thumbs .img_wrapper .img_link.is_chart:hover i.fas.fa-volume-up {
            background: #c45500 !important;
        }
    }
</style>
<script>
    jQuery(function($) {
        $('body').on('click', '.img_link.in_bundle a', function(e) {
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
<?php if (!empty($this_bundle_img_names)) { ?>
    <div class="row this_bundle">
        <div class="col-xs-12 deco_bundles_wrapper">
            <div class="deco_bundles">
                <h2>This Bundle</h2>
                <div class="deco_bundle_wrapper">
                    <div class="deco_bundle hidden-sm hidden-xs">
                        <div class="col_2 hidden-sm hidden-xs">
                            <div class="deco_thumbs <?php echo $product_type; ?>">
                                <?php if (isset($charts_img_names)) { //charts in a bundle first
                                    $i = 0;
                                    foreach ($charts_img_names as $chart_img_names) {
                                        foreach ($chart_img_names as $img_name) {
                                ?>
                                            <div class="img_link is_chart">
                                                <div class="img_wrapper">
                                                    <i class="fas fa-volume-up"></i>
                                                    <a target="_blank" href="<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $charts_j2_store_product_ids[$i]); ?>">
                                                        <img class="lazyload" data-src="<?php echo getImgSizeUrl($img_name, 'S') ?>" />
                                                    </a>
                                                </div>
                                            </div>
                                <?php
                                        }
                                        $i++;
                                    }
                                }
                                ?>

                                <?php
                                $i = 0;
                                foreach ($this_bundle_img_names as $img_name) {  //regular items in a bundle / chart 
                                ?>
                                    <div class="img_link <?php echo isset($chart_params) ? 'is_chart' : 'in_bundle'; ?>">
                                        <div class="img_wrapper">
                                            <i class="fas fa-volume-up"></i>
                                            <a target="<?php echo isset($chart_params) ? '_blank' : '_self'; ?>" href="<?php echo isset($chart_params) ? JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $chart_params->chart_j2_store_product_id) : '#'; ?>" data-gallery="<?php echo isset($this_bundle_gallery_mapping[$i]) ? $this_bundle_gallery_mapping[$i] : ''; ?>">
                                                <img class="lazyload" data-src="<?php echo getImgSizeUrl($img_name, 'S') ?>" />
                                            </a>
                                        </div>
                                    </div>
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
<?php } ?>