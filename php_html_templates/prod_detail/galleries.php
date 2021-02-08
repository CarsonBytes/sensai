<?php
// No direct access

defined('_JEXEC') or die;

$additional_images = json_decode($this->product->additional_images);
$additional_images_alts = (array) json_decode($this->product->additional_images_alt);

array_unshift($additional_images, $this->product->main_image);
array_unshift($additional_images_alts, $this->product->main_image_alt);

//if there is no bundle_with_chart_imgs in params found, there is just 1 gallery, which is its main_image + additional_images
//else there will be 2 galleries, the 1st gallery would be bundle with chart, while the 2nd one is bundle without charts
$gallery_images_1 = array(); //1st gallery
$gallery_images_2 = array();  //2nd gallery

$gallery_modal_array = array(
    'title' => $this->product->product_name,
    'with_chart' => '(' . JText::sprintf('TITLE_WITH_CHARTS') . ')',
    'no_chart' => '' //JText::sprintf('TITLE_WITHOUT_CHARTS'),
);

if (isset($bundle_params) && property_exists($bundle_params, 'bundle_chart_imgs')) {
    $gallery_images_1 = explode('|', $bundle_params->bundle_chart_imgs[0]);
    $gallery_images_2 = $additional_images;
    $gallery_modal_array['gallery_images_2'] = $gallery_images_2;
} else {
    $gallery_images_1 = $additional_images;
    $gallery_modal_array['with_chart'] = '';
}
$gallery_modal_array['gallery_images_1'] = $gallery_images_1;

$layout = new JLayoutFile('custom.prod_detail.slider');
echo $layout->render(array(
    'id' => 1,
    'main_image' => $this->product->main_image,
    'gallery_images' => $gallery_images_1,
));

if (!empty($gallery_images_2)) {
    echo $layout->render(array(
        'id' => 2,
        'main_image' => $this->product->main_image,
        'gallery_images' => $gallery_images_2,
    ));
}
?>
<script>
    var gallery_modal_array = <?php echo json_encode($gallery_modal_array) ?>;
    var selected_option = 'with_chart';
    gallery_modal_array.selected_option = selected_option;
    const IMG_SIZE = {
        'XL': '2000',
        'L': '1500',
        'M': '762',
        'S': '277',
        'XS': '50'
    }
    const base_url = '<?php echo JURI::base(true); ?>';
    jQuery(function($) {
        $.views.converters("getImgSizeUrl", function(url, size) {
            //add base url if necessary
            if (url.includes(base_url) == false) {
                url = base_url + url;
            }

            var size = this.tagCtx.props.size;
            var sizes = Object.values(IMG_SIZE);

            sizes.forEach(x => {
                var y = '_' + x + '.'
                url = url.replace(y, '_' + IMG_SIZE[size] + '.');
            });

            return url;
        });
    });
</script>
<script id="modal_gallery_m" type="text/x-jsrender">
    <div class="vertical_alignment_helper">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="close_btn_wrapper">
                        <button type="button" class="btn btn-default close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="main_wrapper">
                            <div class="thumbnails_column">
                                <div class="title">{{:title}}{{if selected_option == 'with_chart'}} {{:with_chart}}{{/if}}</div>
                                <div class="thumbnails_wrapper">
                                    <div class="thumbnails_row_wrapper">
                                        {{if selected_option == 'with_chart' }}
					                    {{for gallery_images_1 }}
                                            <div class="image_wrapper">
                                                {{if #getIndex() == 0  }}
                                                    <img data-id="main" class="thumbnail_image" src="{{getImgSizeUrl: size='XS'}}" title="" />
                                                {{else}}
                                                    <img data-id="additional-{{:#getIndex()}}" class="thumbnail_image" src="{{getImgSizeUrl: size='XS'}}" title="" />
                                                {{/if}}
                                            </div>
                                            {{if #getIndex() == 2 && #get("array").data.length > 3}}
                                                </div>
                                                <div class="thumbnails_row_wrapper">
                                            {{/if}}
                                        {{/for}}
                                        {{else}}
					                    {{for gallery_images_2 }}
                                            <div class="image_wrapper">
                                                {{if #getIndex() == 0  }}
                                                    <img data-id="main" class="thumbnail_image" src="{{getImgSizeUrl: size='XS'}}" title="" />
                                                {{else}}
                                                    <img data-id="additional-{{:#getIndex()}}" class="thumbnail_image" src="{{getImgSizeUrl: size='XS'}}" title="" />
                                                {{/if}}
                                            </div>
                                            {{if #getIndex() == 2 && #get("array").data.length > 3}}
                                                </div>
                                                <div class="thumbnails_row_wrapper">
                                            {{/if}}
                                        {{/for}}
                                        {{/if}}
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
</script>

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