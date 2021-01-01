<div class="selection_text">
    <strong>Option:</strong>
    <div data-option="with_chart" class="option_text selected">With our exclusive chart posters: <a href="#">Popular dog breeds</a></div>
    <div data-option="no_chart" class="option_text">Without our exclusive chart posters</div>
</div>
<style>
    .product_tags strong,
    .selection_text strong {
        padding-left: 2px;
        padding-bottom: 2px;
        font-weight: 700;
    }

    .selection_text div {
        display: none;
    }

    .selection_text div.selected {
        display: inline-block;
    }

    .selection_boxes {
        margin-left: -6px;
    }

    .selection_box {
        border: 1px solid #e0e0e0;
        cursor: pointer;
        display: inline-block;
        position: relative;
        margin-top: 4px;
        margin-bottom: 4px;
        padding: 0 !important;
        margin-left: 6px;
        margin-right: 0;
    }

    .selection_box .active,
    .selection_box .hover {
        display: none;
    }

    .selection_box.selected .default {
        display: none;
    }

    .selection_box.selected .active {
        display: inline-block;
    }

    .selection_box:hover .default,
    .selection_box:hover .active {
        display: none;
    }

    .selection_box:hover .hover {
        display: inline-block;
    }

    .selection_box.selected:hover .active {
        display: inline-block;
    }

    .selection_box.selected:hover .hover {
        display: none;
    }

    .selection_box img {
        width: 38px;
        height: auto;
    }
</style>
<script>
    var slider_md_2;
    var isSliderMD2Init = false;
    jQuery(function($) {
        $('.selection_box').on('click', function() {
            var selected_option = $(this).find('img').data('option');
            $('.selection_box').removeClass('selected');
            $(this).addClass('selected');

            $('.option_text').removeClass('selected');
            $('.option_text[data-option="' + selected_option + '"]').addClass('selected');

            if (selected_option == 'no_chart') {
                $('.chart_toggle_in_title').hide();
                $('.slider_md_whole_wrapper.slider_1').hide();
                $('.slider_md_whole_wrapper.slider_2').show();

                if (!isSliderMD2Init) {
                    slider_md_2 = tns({
                        container: '.my-slider-md_2',
                        items: 1,
                        navAsThumbnails: true,
                        navContainer: '#slider_md_thumbnails_2',
                        navPosition: 'top',
                        controls: false,
                        center: true,
                        preventScrollOnTouch: 'auto',
                        gutter: 30,
                        loop: false,
                        speed: 0,
                        animateIn: 'no_fade',
                        animateOut: 'no_fade',
                        autoHeight: true,
                        lazyload: true
                    });
                    $('.my-slider-md_2').find('img').on('load', function() {
                        $(this).parents('.slider_md_wrapper').find('.image_canvas_caption .default_caption').show();
                        slider_md_2.updateSliderHeight();
                    });
                    isSliderMD2Init = true;
                }
                slider_md_2.updateSliderHeight();
                slider_md_2.goTo('first');
                $('.this_bundle .img_link.is_chart').fadeOut(500);
            } else {
                $('.chart_toggle_in_title').show();
                $('.slider_md_whole_wrapper.slider_2').hide();
                $('.slider_md_whole_wrapper.slider_1').show();
                slider_md.updateSliderHeight();
                slider_md.goTo('first');
                $('.this_bundle .img_link.is_chart').fadeIn(500);
            }
        })
    })
</script>
<div class="selection_boxes">
    <div class="selection_box selected">
        <img class="default" src="<?php echo JUri::base() . 'images/icon/plus_default.svg'; ?>" alt="Without our exclusive chart posters" data-option="with_chart">
        <img class="active" src="<?php echo JUri::base() . 'images/icon/plus_selected.svg'; ?>" alt="With our exclusive chart posters" data-option="with_chart">
        <img class="hover" src="<?php echo JUri::base() . 'images/icon/plus_over.svg'; ?>" alt="With our exclusive chart posters" data-option="with_chart">
    </div>
    <div class="selection_box ">
        <img class="default" src="<?php echo JUri::base() . 'images/icon/bundle_default.svg'; ?>" alt="With our exclusive chart posters" data-option="no_chart">
        <img class="active" src="<?php echo JUri::base() . 'images/icon/bundle_selected.svg'; ?>" alt="With our exclusive chart posters" data-option="no_chart">
        <img class="hover" src="<?php echo JUri::base() . 'images/icon/bundle_over.svg'; ?>" alt="With our exclusive chart posters" data-option="no_chart">
    </div>
</div>