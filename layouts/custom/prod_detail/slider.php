<?php
// No direct access
defined('_JEXEC') or die;

$id_suffix = $displayData['id'] > 1 ? '_' . $displayData['id'] : '';

?>
<div class="slider_sm_wrapper hidden-md hidden-lg slider_<?php echo $displayData['id']; ?>">
    <div class="my-slider1">

        <div><img class="tns-lazy-img" data-src="<?php echo getImgSizeUrl($displayData['main_image'], 'S') ?>" alt="<?php echo $displayData['main_image'] ?>" /></div>

        <?php
        if ($displayData['gallery_images'][0] != '') {
            foreach ($displayData['gallery_images'] as $gallery_image) {
                if ($gallery_image != '') { ?>
                    <div><img class="tns-lazy-img" data-src="<?php echo getImgSizeUrl($gallery_image, 'S') ?>" alt="" /></div>
        <?php
                }
            }
        } ?>
    </div>
</div>

<div class="slider_md_whole_wrapper hidden-sm hidden-xs slider_<?php echo $displayData['id']; ?> <?php echo count($displayData['gallery_images']) > 10 ? 'two_cols' : '' ?>" style="<?php echo $displayData['id'] > 1 ? 'display:none;' : ''; ?>">
    <div class="slider_md_thumbnails_wrapper">
        <ul class="thumbnails" id="slider_md_thumbnails<?php echo $id_suffix; ?>">
            <?php $i = 0;
            foreach ($displayData['gallery_images'] as $gallery_image) { ?>
                <li>
                    <div class="image-wrapper">
                        <div class="a-image-wrapper"><img src="<?php echo getImgSizeUrl($gallery_image, 'XS') ?>" alt="" /></div>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="slider_md_wrapper">
        <div class="my-slider-md<?php echo $id_suffix; ?>">
            <?php
            $i = 0;
            foreach ($displayData['gallery_images'] as $gallery_image) {
                if ($gallery_image != '') {
                    if ($i == 0) { ?>
                        <div class="image-wrapper">
                            <div class="a-image-wrapper"><img data-id="main" class="tns-lazy-img" data-src="<?php echo getImgSizeUrl($gallery_image, 'M') ?>" alt="<?php /* echo $displayData['main_image']_alt */ ?>" /></div>
                        </div>
                    <?php } else { ?>
                        <div class="image-wrapper">
                            <div class="a-image-wrapper"><img data-id="<?php echo 'additional-' . $i ?>" src="<?php echo getImgSizeUrl($gallery_image, 'M') ?>" alt="" /></div>
                        </div>
            <?php }
                    $i++;
                }
            } ?>
        </div>

        <div class="image_canvas_caption">
            <div class="image_canvas_caption_wrapper">
                <span class="default_caption" style="display:none;"><?php echo JText::sprintf('GALLERY_ZOOM') ?></span>
            </div>
        </div>
    </div>
</div>