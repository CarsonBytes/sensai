<?php
// No direct access

use ParagonIE\Sodium\Core\Curve25519\Ge\P2;

defined('_JEXEC') or die;

$additional_images = json_decode($this->product->additional_images);
$additional_images_alts = (array) json_decode($this->product->additional_images_alt);

array_unshift($additional_images, $this->product->main_image);
array_unshift($additional_images_alts, $this->product->main_image_alt);

//if there is no bundle_with_chart_imgs in params found, there is just 1 gallery, which is its main_image + additional_images
//else there will be 2 galleries, the 1st gallery would be bundle with chart, while the 2nd one is bundle without charts
$gallery_images_1 = array(); //1st gallery
$gallery_images_2 = array();  //2nd gallery

if (isset($bundle_params) && property_exists($bundle_params, 'bundle_chart_imgs')) {
    $gallery_images_1 = explode('|', $bundle_params->bundle_chart_imgs[0]);
    $gallery_images_2 = $additional_images;
} else {
    $gallery_images_1 = $additional_images;
}
?>
<style>
    /** to avoid image and page jumping
 */
    .slider_md_wrapper {
        visibility: hidden;
    }

    .slider_md_whole_wrapper.two_cols {
        padding-left: 90px;
    }

    .slider_md_whole_wrapper.two_cols .slider_md_thumbnails_wrapper {
        margin-left: -90px;
        padding-right: 10px;
        width: 90px;
    }

    .slider_md_whole_wrapper.two_cols .slider_md_thumbnails_wrapper ul {
        columns: 2;
    }

    .slider_md_whole_wrapper.two_cols .slider_md_thumbnails_wrapper ul li {
        break-inside: avoid-column;
    }
</style>
<script>
    jQuery(function($) {
        $('body').on('mouseenter', '#slider_md_thumbnails_2 li', function(e) {
            slider_md_2.goTo($(this).data('nav'));
        })

        $('.slider_md_wrapper').css('visibility','inherit');
    })
</script>
<div class="slider_sm_wrapper hidden-md hidden-lg">
    <div class="my-slider1">

        <div><img class="tns-lazy-img" data-src="<?php echo getImgSizeUrl($this->product->main_image, 'S') ?>" alt="<?php echo $this->product->main_image_alt ?>" /></div>

        <?php
        $i = 0;
        if ($additional_images[0] != '') {
            foreach ($additional_images as $additional_image) { ?>
                <div><img class="tns-lazy-img" data-src="<?php echo getImgSizeUrl($additional_image, 'S') ?>" alt="<?php echo $i == 0 ? current($additional_images_alts) : next($additional_images_alts); ?>" /></div>
        <?php
                $i++;
            }
        } ?>
    </div>
</div>

<div class="slider_md_whole_wrapper hidden-sm hidden-xs slider_1 <?php echo count($gallery_images_1) > 10 ? 'two_cols' : '' ?>">
    <div class="slider_md_thumbnails_wrapper">
        <ul class="thumbnails" id="slider_md_thumbnails">
            <?php $i = 0;
            foreach ($gallery_images_1 as $gallery_image) { ?>
                <li>
                    <div class="image-wrapper">
                        <div class="a-image-wrapper"><img src="<?php echo getImgSizeUrl($gallery_image, 'XS') ?>" alt="" /></div>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="slider_md_wrapper">
        <div class="my-slider-md">
            <?php
            $i = 0;
            foreach ($gallery_images_1 as $gallery_image) {
                if ($i == 0) { ?>
                    <div class="image-wrapper">
                        <div class="a-image-wrapper"><img data-id="main" class="tns-lazy-img" data-src="<?php echo getImgSizeUrl($gallery_image, 'M') ?>" alt="<?php /* echo $this->product->main_image_alt */ ?>" /></div>
                    </div>
                <?php } else { ?>
                    <div class="image-wrapper">
                        <div class="a-image-wrapper"><img data-id="<?php echo 'additional-' . $i ?>" src="<?php echo getImgSizeUrl($gallery_image, 'M') ?>" alt="" /></div>
                    </div>
            <?php }
                $i++;
            } ?>
        </div>

        <div class="image_canvas_caption">
            <div class="image_canvas_caption_wrapper">
                <span class="default_caption" style="display:none;">画像にマウスを合わせると拡大されます</span>
            </div>
        </div>
    </div>
</div>
<?php if (!empty($gallery_images_2)) { ?>
    <div class="slider_md_whole_wrapper hidden-sm hidden-xs slider_2 <?php echo count($gallery_images_2) > 10 ? 'two_cols' : '' ?>" style="display:none;">
        <div class="slider_md_thumbnails_wrapper">
            <ul class="thumbnails" id="slider_md_thumbnails_2">

                <?php $i = 0;
                foreach ($gallery_images_2 as $gallery_image) { ?>
                    <li>
                        <div class="image-wrapper">
                            <div class="a-image-wrapper"><img src="<?php echo getImgSizeUrl($gallery_image, 'XS') ?>" alt="<?php /* echo $i == 0 ? current($additional_images_alts) : next($additional_images_alts);  */ ?>" /></div>
                        </div>
                    </li>
                <?php
                    $i++;
                }
                ?>
            </ul>
        </div>
        <div class="slider_md_wrapper">
            <div class="my-slider-md_2">
                <?php
                $i = 0;
                foreach ($gallery_images_2 as $gallery_image) {
                    if ($i == 0) { ?>
                        <div class="image-wrapper">
                            <div class="a-image-wrapper"><img data-id="main" class="tns-lazy-img" data-src="<?php echo getImgSizeUrl($gallery_image, 'M') ?>" alt="<?php /* echo $this->product->main_image_alt */ ?>" /></div>
                        </div>
                    <?php } else { ?>
                        <div class="image-wrapper">
                            <div class="a-image-wrapper"><img data-id="<?php echo 'additional-' . $i ?>" src="<?php echo getImgSizeUrl($gallery_image, 'M') ?>" alt="" /></div>
                        </div>
                <?php }
                    $i++;
                } ?>
            </div>

            <div class="image_canvas_caption">
                <div class="image_canvas_caption_wrapper">
                    <span class="default_caption" style="display:none;">画像にマウスを合わせると拡大されます</span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- Modal -->
<div class="modal" id="productGallery" tabindex="-1" role="dialog" aria-labelledby="productGalleryLabel" data-backdrop="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="back_btn_wrapper">
                    <button type="button" class="btn btn-default back" data-dismiss="modal"></button>
                    <div class="back_btn_text">
                        <span>戻る</span>
                    </div>
                </div>

                <div class="my-slider2">
                    <div><img class="tns-lazy-img" data-src="<?php echo getImgSizeUrl($this->product->main_image, 'M') ?>" alt="<?php echo $this->product->main_image_alt ?>" /></div>

                    <?php
                    $i = 0;
                    if ($additional_images[0] != '') {
                        foreach ($additional_images as $additional_image) { ?>
                            <div><img class="tns-lazy-img" data-src="<?php echo getImgSizeUrl($additional_image, 'M') ?>" alt="<?php echo $i == 0 ? current($additional_images_alts) : next($additional_images_alts); ?>" /></div>
                    <?php
                            $i++;
                        }
                    } ?>
                </div>
                <ul class="thumbnails" id="customize-thumbnails">
                    <li>
                        <div class="image-wrapper">
                            <div class="a-image-wrapper"><img src="<?php echo getImgSizeUrl($this->product->main_image, 'XS') ?>" alt="<?php echo $this->product->main_image_alt ?>" /></div>
                        </div>
                    </li>

                    <?php
                    $i = 0;
                    if ($additional_images[0] != '') {
                        foreach ($additional_images as $additional_image) { ?>
                            <li>
                                <div class="image-wrapper">
                                    <div class="a-image-wrapper"><img src="<?php echo getImgSizeUrl($additional_image, 'XS') ?>" alt="<?php echo $i == 0 ? current($additional_images_alts) : next($additional_images_alts); ?>" /></div>
                                </div>
                            </li>
                    <?php
                            $i++;
                        }
                    } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal" id="productGallery_m" tabindex="-1" role="dialog" aria-labelledby="productGalleryLabel_m">
    <div class="vertical_alignment_helper">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="close_btn_wrapper">
                    <button type="button" class="btn btn-default close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <div class="main_wrapper">
                        <div class="thumbnails_column">
                            <div class="title"><?php echo $this->loadTemplate('title'); ?></div>
                            <div class="thumbnails_wrapper">
                                <div class="thumbnails_row_wrapper">
                                    <div class="image_wrapper">
                                        <img data-id="main" class="thumbnail_image" src="<?php echo getImgSizeUrl($this->product->main_image, 'XS') ?>" title="<?php echo $this->product->main_image_alt ?>" />
                                    </div>
                                    <?php
                                    $i = 0;
                                    //$additional_images->{2}=$additional_images->{3};
                                    if ($additional_images[0] != '') {
                                        foreach ($additional_images as $additional_image) { ?>
                                            <div class="image_wrapper">
                                                <img data-id="additional-<?php echo $i ?>" class="thumbnail_image" src="<?php echo getImgSizeUrl($additional_image, 'XS') ?>" title="<?php echo $i == 0 ? current($additional_images_alts) : next($additional_images_alts); ?>" />
                                            </div>
                                            <?php if (($i == 2) && count($additional_images) > 3) { ?>
                                </div>
                                <div class="thumbnails_row_wrapper">
                                <?php } ?>

                        <?php $i++;
                                        }
                                    } ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="enlarged_image_wrapper">
                            <div class="table_wrapper">
                                <div class="enlarged_image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>