<?php
// No direct access
defined('_JEXEC') or die;
?>
<style>
    .deco_bundles .btn_to_amazon.to_view {
        float: left;
    }

    .deco_bundles .btn_to_amazon.to_order {
        float: right;
    }

    .deco_bundles .btn_to_amazon .a-button-inner img {
        display: block;
        position: absolute;
        top: 2px;
        left: 2px;
        width: 25px;
        height: 25px;
        border-radius: 2px;
    }
</style>
<div class="row bundles">
    <div class="col-xs-12 deco_bundles_wrapper">
        <div class="deco_bundles related_bundles">
            <h2>Related Bundles</h2>
            <?php $j = 0;
            foreach ($related_bundles as $bundle) {
                $bundle_link = JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $bundle['j2store_product_id']);
            ?>
                <div class="deco_bundle_wrapper">
                    <a class="bundle_title" href="<?php echo $bundle_link; ?>">
                        <?php echo $bundle['title'];
                        ?>
                    </a>
                    <?php /*?><div class="matched_tags">
                        <span>Matched Tags:</span>
                        <?php
                        $matched_tag_titles = explode(',', $bundle['matched_tag_titles']);
                        $matched_tag_alias = explode(',', $bundle['matched_tag_alias']);
                        $i = 0;
                        foreach ($matched_tag_titles as $matched_tag_title) {
                            if ($i > 0) {
                                echo ', ';
                            } ?><a target="_blank" href="<?php echo JUri::base() . 'tag/' . $matched_tag_alias[$i]; ?>"><?php echo $matched_tag_title; ?></a>
                        <?php
                            $i++;
                        }
                        ?>
                    </div><?php */ ?>

                    <div class="slider_sm_wrapper hidden-md hidden-lg">
                        <div class="sm_slider" data-id="<?php echo $j ?>">

                            <div><img class="tns-lazy-img" data-src="/<?php echo $bundle['thumb_image'] ?>" /></div>

                            <?php
                            $params = json_decode($bundle['params']);
                            $img_names = $params->img_names;
                            foreach ($img_names as $img_name) { ?>
                                <div><img class="tns-lazy-img" data-src="<?php echo getImgSizeUrl($img_name, 'S') ?>" /></div>
                            <?php } ?>
                        </div>

                        <div class="btn_to_amazon to_single hidden-xs hidden-sm">
                            <?php /*<span class="a-button-inner">
                                <i class="a-icon a-icon-buynow"></i>
                                <input title="これを買おう" class="a-button-input" type="button" aria-labelledby="a-autoid-1-announce">
                                <span class="a-button-text" aria-hidden="true" id="a-autoid-1-announce">
                                    アマゾンでこれを買う
                                </span>
                            </span>*/ ?>
                        </div>
                    </div>

                    <div class="deco_bundle hidden-sm hidden-xs" data-id="<?php echo $bundle['content_id']; ?>">
                        <div class="bundle_thumb">
                            <a class="img_link" data-fancybox="gallery" href="<?php echo getImgSizeUrl($bundle['thumb_image'], 'XL'); ?>">
                                <div class="img_wrapper">
                                    <img class="lazyload" src="https://via.placeholder.com/183x205/FFFFFF/FFFFFF" data-src="/<?php echo $bundle['thumb_image']; ?>" />
                                </div>
                            </a>
                            <div class="btn_to_amazon to_view" onclick="window.location ='<?php echo JRoute::_('index.php?option=com_j2store&view=products&task=view&&id=' . $bundle['j2store_product_id']); ?>';">
                                <span class="a-button-inner">
                                    <img src="<?php echo JUri::base() . 'images/icon/sensai_more.svg' ?>" />
                                    <input title="これを買おう" class="a-button-input" type="button" aria-labelledby="a-autoid-1-announce">
                                    <span class="a-button-text" aria-hidden="true" id="a-autoid-1-announce">
                                        View
                                    </span>
                                </span>
                            </div>
                            <div class="btn_to_amazon to_order">
                                <span class="a-button-inner">
                                    <img src="<?php echo JUri::base() . 'images/icon/amazon_more.png' ?>" />
                                    <input title="これを買おう" class="a-button-input" type="button" aria-labelledby="a-autoid-1-announce">
                                    <span class="a-button-text" aria-hidden="true" id="a-autoid-1-announce">
                                        Order
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="vertical_line"></div>
                        <div class="col_2 hidden-sm hidden-xs">
                            <div class="deco_thumbs">
                                <?php
                                foreach ($img_names as $img_name) {
                                ?>
                                    <a class="img_link" data-fancybox="gallery" href="<?php echo getImgSizeUrl($img_name, 'XL') ?>">
                                        <div class="img_wrapper">
                                            <img class="lazyload" data-src="<?php echo getImgSizeUrl($img_name, 'S') ?>" />
                                        </div>
                                    </a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <!-- Modal -->
                <div class="modal productGallery" data-id="<?php echo $j ?>" tabindex="-1" role="dialog" aria-labelledby="productGalleryLabel" data-backdrop="false">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="back_btn_wrapper">
                                    <button type="button" class="btn btn-default back" data-dismiss="modal"></button>
                                    <div class="back_btn_text">
                                        <span>戻る</span>
                                    </div>
                                </div>

                                <div class="productGallery_slider" data-id="<?php echo $j ?>">
                                    <div><img class="lazyload" data-src="/<?php echo $bundle['thumb_image'] ?>" /></div>

                                    <?php foreach ($img_names as $img_name) { ?>
                                        <div><img class="lazyload" data-src="<?php echo getImgSizeUrl($img_name, 'S') ?>" /></div>
                                    <?php } ?>
                                </div>
                                <ul class="thumbnails slider_sm_thumbnails" data-id="<?php echo $j ?>">
                                    <li>
                                        <div class="image-wrapper">
                                            <div class="a-image-wrapper">
                                                <img class="lazyload" data-src="/<?php echo $bundle['thumb_image'] ?>" />
                                            </div>
                                        </div>
                                    </li>

                                    <?php
                                    foreach ($img_names as $img_name) { ?>
                                        <li>
                                            <div class="image-wrapper">
                                                <div class="a-image-wrapper">
                                                    <img class="lazyload" data-src="<?php echo getImgSizeUrl($img_name, 'S') ?>" />
                                                </div>
                                            </div>
                                        </li>
                                    <?php
                                    } ?>
                                    <div class="clearfix"></div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php $j++;
            } ?>
        </div>
    </div>
</div>