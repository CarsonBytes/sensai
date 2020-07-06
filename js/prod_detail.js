
var slider1;
var slider2 = null;
var slider_md = null;
var slider1_info = null;
var slider2_info = null;
var slider_md_info = null;
var main_scrollY = 0;

function getImgSizeUrl(url, width) {
    //width : XL, L, M, S, XS
    var all_sizes = ['_2000', '_1500', '_762', '_277', '_50'];

    var regexp = new RegExp(all_sizes.join('|'), 'g');

    switch (width) {
        case 'XL':
            return url.replace(regexp, '_2000');
            break;
        case 'L':
            return url.replace(regexp, '_1500');
            break;
        case 'M':
            return url.replace(regexp, '_762');
            break;
        case 'S':
            return url.replace(regexp, '_277');
            break;
        case 'XS':
            return url.replace(regexp, '_50');
            break;
    }
    return false;
}

function imageZoom(img_element) {
    var cx, cy;
    var img, lens, result;
    var x_diff, y_diff;
    var natural_width_L, natural_height_L;

    jQuery('.loader').show();

    //check which edge is longer, and calculate the ratio of M : L size image
    if (img_element.get(0).naturalWidth > img_element.get(0).naturalHeight) {
        natural_width_L = 1500; // L size longest edge is 1500
        cy = cx = natural_width_L / img_element.width();
        natural_height_L = img_element.height() * cy;
    } else {
        natural_height_L = 1500; // L size longest edge is 1500
        cy = cx = natural_height_L / img_element.height();
        natural_width_L = img_element.width() * cy;
    }

    //check whether zoom preview div is too big, ensure the zoom preview could cover the whole image area
    x_diff = natural_width_L - jQuery('.image_zoom_preview').width();
    y_diff = natural_height_L - jQuery('.image_zoom_preview').height();

    if ((x_diff < 0) && (x_diff < y_diff)) {
        cy = cx = jQuery('.image_zoom_preview').width() / img_element.width()
    } else if ((y_diff < 0) && (y_diff < x_diff)) {
        cy = cx = jQuery('.image_zoom_preview').height() / img_element.height()
    }

    // hide all previews first
    jQuery('.large_preview_bg').hide();

    if (!jQuery('.image_zoom_preview > [data-id=' + img_element.data('id') + ']').length) {
        jQuery('.image_zoom_preview').append('<div class="large_preview_bg" data-id="' + img_element.data('id') + '" style="background-image: url(' + getImgSizeUrl(img_element.get(0).src, 'L') + ')"></div>');
    }

    // show the active preview
    jQuery('.image_zoom_preview > [data-id=' + img_element.data('id') + ']').show();
    result = jQuery('.image_zoom_preview > [data-id=' + img_element.data('id') + ']').get(0);

    /*create lens:*/
    lens = document.createElement("div");
    lens.setAttribute("class", "magnifier_lens");

    /*insert lens:*/
    img_element.get(0).parentElement.insertBefore(lens, img);

    /*calculate the ratio between result DIV and lens:*/
    jQuery('.magnifier_lens')
        .css('width', result.offsetWidth / cx)
        .css('height', result.offsetHeight / cy)

    /*set background properties for the result DIV:*/
    result.style.backgroundSize = (img_element.width() * cx) + "px " + (img_element.height() * cy) + "px";
    /*execute a function when someone moves the cursor over the image, or the lens:*/
    lens.addEventListener("mousemove", moveLens);
    img_element.get(0).addEventListener("mousemove", moveLens);
    /*and also for touch screens:*/
    lens.addEventListener("touchmove", moveLens);
    img_element.get(0).addEventListener("touchmove", moveLens);
    function moveLens(e) {
        var pos, x, y;
        /*prevent any other actions that may occur when moving over the image:*/
        e.preventDefault();
        /*get the cursor's x and y positions:*/
        pos = getCursorPos(e);
        /*calculate the position of the lens:*/
        x = pos.x - (lens.offsetWidth / 2);
        y = pos.y - (lens.offsetHeight / 2);
        /*prevent the lens from being positioned outside the image:*/
        if (x > img_element.width() - lens.offsetWidth) { x = img_element.width() - lens.offsetWidth; }
        if (x < 0) { x = 0; }
        if (y > img_element.height() - lens.offsetHeight) { y = img_element.height() - lens.offsetHeight; }
        if (y < 0) { y = 0; }
        /*set the position of the lens:*/
        lens.style.left = x + "px";
        lens.style.top = y + "px";
        /*display what the lens "sees":*/
        result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
    }
    function getCursorPos(e) {
        var a, x = 0, y = 0;
        e = e || window.event;
        /*get the x and y positions of the image:*/
        a = img_element.get(0).getBoundingClientRect();
        /*calculate the cursor's x and y coordinates, relative to the image:*/
        x = e.pageX - a.left;
        y = e.pageY - a.top;
        /*consider any page scrolling:*/
        x = x - window.pageXOffset;
        y = y - window.pageYOffset;
        return { x: x, y: y };
    }
}

jQuery(function ($) {
    var isSlider2Init = false;
    var isSliderMDInit = false;

    slider1 = tns({
        container: '.my-slider1',
        items: 1,
        controls: false,
        navPosition: 'bottom',
        center: true,
        autoHeight: true,
        preventScrollOnTouch: 'auto',
        gutter: 30
        , loop: false
        , lazyload: true
    });
    $('.my-slider1').find('img').on('load', function () {
        slider1.updateSliderHeight();
    });
    function initScreen() {
        //console.log('sized')
        $('#productGallery .my-slider2, #productGallery .my-slider2 > .tns-item')
            .css('height', $(window).height() - 50);

        if ($(window).width() <= 970) {
            $('#productGallery_m').modal('hide');
            $('#productGallery_m .enlarged_image img').hide();

        } else {
            if (!isSliderMDInit) {
                slider_md = tns({
                    container: '.my-slider-md',
                    items: 1,
                    navAsThumbnails: true,
                    navContainer: '#slider_md_thumbnails',
                    navPosition: 'top',
                    controls: false,
                    center: true,
                    preventScrollOnTouch: 'auto',
                    gutter: 30,
                    loop: false,
                    speed: 0,
                    animateIn: 'no_fade',
                    animateOut: 'no_fade'
                    , autoHeight: true
                    , lazyload: true
                });
                isSliderMDInit = true;
            }
            $('.my-slider-md').find('img').on('load', function () {
                $(this).parents('.slider_md_wrapper').find('.image_canvas_caption .default_caption').show();
                slider_md.updateSliderHeight();
            });
        }

        $('#productGallery_m .enlarged_image img')
            .css('max-height', $('#productGallery_m .modal-content').height() - 68);

    }

    function showGalleryImg(img_id, img_src) {
        //select active thumbnail
        $('#productGallery_m .image_wrapper').removeClass('selected');
        $('#productGallery_m .image_wrapper img[data-id=' + img_id + ']').parents('.image_wrapper')
            .addClass('selected');

        // hide all slides and stop animation first
        $('#productGallery_m .enlarged_image img')
            .clearQueue().finish()
            .removeClass('active').hide();

        if (!$('#productGallery_m .enlarged_image img[data-id=' + img_id + ']').length) {
            $('#productGallery_m .enlarged_image').append('<div data-id="' + img_id + '" style="width:100%;height:100%;"><img src="' + img_src + '" data-id="' + img_id + '" /></div>');
        }

        // show the active slide
        $('#productGallery_m .enlarged_image img[data-id=' + img_id + ']')
            .css('max-height', $(window).height() * 0.85 - 68)
            .addClass('active')
            .fadeIn();

        var active_img = $('#productGallery_m .enlarged_image img.active');

        $('#productGallery_m .enlarged_image').trigger('zoom.destroy');

        $('#productGallery_m .enlarged_image > div').hide();

        $('#productGallery_m .enlarged_image img').removeClass('zoomable');

        //check zoom image is already created before or not, if not, then create 1, if so, then just use it without reloading
        if (!$('#productGallery_m .enlarged_image div[data-id=' + img_id + '] img.zoomImg').length) {
            // as the 1500w is most likely larger than a light box in a normal screen, we do the zooming anyways, 
            // and also the image being loaded returns inaccurate dimensions...
            /* if ((active_img.get(0).naturalWidth > active_img.get(0).offsetWidth)
                ||
                (active_img.get(0).naturalHeight > active_img.get(0).offsetHeight)
            ) { */
            $('#productGallery_m .enlarged_image div[data-id=' + img_id + ']').zoom(
                {
                    on: 'click',
                    url: getImgSizeUrl(active_img.prop('src'), 'L'),
                    callback: function () {
                        active_img
                            .addClass('zoomable')
                            .css('cursor', 'zoom-in');
                    }
                }
            );
            /* } */
        }
        $('#productGallery_m .enlarged_image div[data-id=' + img_id + ']').fadeIn();
    }

    initScreen();

    $('body').on('click', '.my-slider1 .tns-slide-active img', function (e) {

        main_scrollY = $(window).scrollTop();

        //init modal size
        $('#productGallery').modal();

        slider1_info = slider1.getInfo();

        //$('.my-slider2').hide();
        if (!isSlider2Init) {
            slider2 = tns({
                container: '.my-slider2',
                items: 1,
                navAsThumbnails: true,
                navContainer: '#customize-thumbnails',
                controls: false,
                center: true,
                preventScrollOnTouch: 'auto',
                gutter: 30,
                animateIn: 'no_fade',
                animateOut: 'no_fade',
                loop: false
                , lazyload: true
            });
            $('.my-slider2').find('img').on('load', function () {
                slider2.updateSliderHeight();
            });
            isSlider2Init = true;
        }
        slider2.goTo(slider1_info.index);

        // bind function to event
        slider2.events.on('indexChanged', function () {
            slider2_info = slider2.getInfo();

            slider1.goTo(slider2_info.index);
        });

        $('#productGallery .my-slider2, #productGallery .my-slider2 > .tns-item')
            .css('height', $(window).height() - 50);

        $('.my-slider2').show();

    })
        .on('mouseenter', '#slider_md_thumbnails li', function (e) {
            slider_md.goTo($(this).data('nav'));
        })
        .on('mouseenter', '.slider_md_wrapper .tns-slide-active', function (e) {
            //hover and show image zoom
            $('.image_zoom_preview')
                .show()
                .css('width', $('.main_content').outerWidth() + 30)
                .css('height', $('.simple-product > .row').outerHeight());

            imageZoom($(this).find('img'));
        })
        .on('mouseleave', '.slider_md_wrapper .tns-slide-active', function (e) {
            //hide image zoom
            $('.image_zoom_preview').hide();
            $('.magnifier_lens').remove();
        })
        .on('click', '.slider_md_wrapper .tns-slide-active .magnifier_lens', function (e) {
            main_scrollY = $(window).scrollTop();

            var img_id = $(this).parents('.a-image-wrapper').find('img').data('id');
            var img_src = getImgSizeUrl($(this).parents('.a-image-wrapper').find('img').prop('src'), 'M');

            showGalleryImg(img_id, img_src);

            $('#productGallery_m').modal();

        })
        .on('click', '#productGallery_m .image_wrapper', function (e) {
            $('#productGallery_m .image_wrapper').removeClass('selected');
            $(this).addClass('selected');

            var img_id = $(this).find('img').data('id');
            var img_src = getImgSizeUrl($(this).find('img').prop('src'), 'M')

            showGalleryImg(img_id, img_src);
        })

    $('#productGallery_m, #productGallery').on('hidden.bs.modal', function (e) {
        //scroll back to original position of the main page
        $(window).scrollTop(main_scrollY);
    })

    $(".btn_to_amazon")
        .on('mousedown touchstart', function (event) {
            $(this).addClass('focus');
        })
        .on('mouseup mouseout touchend', function (event) {
            $(this).removeClass('focus');
        })

    $(window).on('orientationchange', function () {
        $('#productGallery .my-slider2, #productGallery .my-slider2 > .tns-item')
            .css('height', $(window).height() - 50);
        $(window).one('resize', function () {
            slider1.updateSliderHeight();
        });
    })

    $(window).on('resize', function () {
        initScreen();
    });

    $("#productGallery").on("show", function () {
        $("body").addClass("modal-open");
    }).on("hidden", function () {
        $("body").removeClass("modal-open")
    });

})