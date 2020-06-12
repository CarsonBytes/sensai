var sm_sliders = [];
var md_sliders = [];
var productGallery_slider = null;
var slider1_info = null;
var slider2_info = null;
var slider_md_info = null;
var main_scrollY = 0;
var cx, cy;
function imageZoom(current_md_slider_id) {
    var img, lens, result;

    //img = document.getElementById(imgID);
    img = jQuery('.md_slider[data-id=' + current_md_slider_id + '] .tns-slide-active img').get(0);
    //result = document.getElementById(resultID);
    result = jQuery('.image_zoom_preview[data-id=' + current_md_slider_id + ']').get(0);

    /* console.log(result)
    console.log(result.offsetWidth)
    console.log(result.offsetHeight) */

    /*create lens:*//* 
    lens = document.createElement("div");
    lens.setAttribute("class", "magnifier_lens"); */
    /*insert lens:*//* 
    img.parentElement.insertBefore(lens, img); */
    /*calculate the ratio between result DIV and lens:*/

    jQuery('<div class="magnifier_lens"></div>')
        .insertBefore('.md_slider[data-id=' + current_md_slider_id + '] .tns-slide-active img')
        .css('width', result.offsetWidth / cx)
        .css('height', result.offsetHeight / cy);

    lens = jQuery('.md_slider[data-id=' + current_md_slider_id + '] .tns-slide-active .magnifier_lens').get(0);

    /*
    cx = result.offsetWidth / lens.offsetWidth;
    cy = result.offsetHeight / lens.offsetHeight;
    */
    /*set background properties for the result DIV:*/
    result.style.backgroundImage = "url('" + img.src + "')";
    result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
    /*execute a function when someone moves the cursor over the image, or the lens:*/
    lens.addEventListener("mousemove", moveLens);
    img.addEventListener("mousemove", moveLens);
    /*and also for touch screens:*/
    lens.addEventListener("touchmove", moveLens);
    img.addEventListener("touchmove", moveLens);
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
        if (x > img.width - lens.offsetWidth) { x = img.width - lens.offsetWidth; }
        if (x < 0) { x = 0; }
        if (y > img.height - lens.offsetHeight) { y = img.height - lens.offsetHeight; }
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
        a = img.getBoundingClientRect();
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
    $no_of_slider_sets = $('.sm_slider').length;

    $('.sm_slider').each(function (index) {
        sm_sliders[index] = tns({
            container: ".sm_slider[data-id='" + index + "']",
            items: 1,
            controls: false,
            navPosition: 'bottom',
            center: true,
            autoHeight: true,
            preventScrollOnTouch: 'auto',
            gutter: 30
            ,loop: false
            ,lazyload: true
        });
    });

    $('.md_slider').each(function (index) {
        md_sliders[index] = tns({
            container: ".md_slider[data-id='" + index + "']",
            items: 1,
            navAsThumbnails: true,
            navContainer: ".slider_md_thumbnails[data-id='" + index + "']",
            navPosition: 'top',
            controls: false,
            center: true,
            preventScrollOnTouch: 'auto',
            gutter: 30,
            loop: false,
            speed: 0,
            animateIn: 'no_fade',
            animateOut: 'no_fade'
            ,lazyload: true
        });
    });


    $('body')
        .on('click', '.sm_slider .tns-slide-active img', function (e) {

            var current_sm_slider_id = $(this).parents('.sm_slider').data('id');
            main_scrollY = $(window).scrollTop();

            //init modal size
            $('.productGallery[data-id=' + current_sm_slider_id + ']').modal();

            slider1_info = sm_sliders[current_sm_slider_id].getInfo();

            if (productGallery_slider != null) {
                /* console.log('rebuilding..') */
                productGallery_slider.destroy();
                productGallery_slider = null;
            }
            productGallery_slider = tns({
                container: ".productGallery_slider[data-id='" + current_sm_slider_id + "']",
                items: 1,
                navAsThumbnails: true,
                navContainer: ".slider_sm_thumbnails[data-id='" + current_sm_slider_id + "']",
                controls: false,
                center: true,
                preventScrollOnTouch: 'auto',
                gutter: 30,
                loop: false,
                startIndex: slider1_info.index - 1
                //,lazyload: true
            });
            /* console.log(productGallery_slider[current_sm_slider_id]);
            console.log(current_sm_slider_id); */

            //productGallery_slider.goTo(slider1_info.index - 1);

            // bind function to event
            productGallery_slider.events.on('indexChanged', function () {
                slider2_info = productGallery_slider.getInfo();
                sm_sliders[current_sm_slider_id].goTo(slider2_info.index);
            });

            $('.productGallery .productGallery_slider[data-id=' + current_sm_slider_id + '], .productGallery[data-id=' + current_sm_slider_id + '] .productGallery_slider > .tns-item')
                .css('height', $(window).height() - 50);

        })
        .on('mouseenter', '.slider_md_thumbnails li', function (e) {
            md_sliders[$(this).parents('.slider_md_thumbnails').data('id')].goTo($(this).data('nav'));
        })
        .on('mouseenter', '.slider_md_wrapper .tns-slide-active', function (e) {
            var current_md_slider_id = $(this).parents('.md_slider').data('id');
            //hover and show image zoom
            $('.image_zoom_preview[data-id=' + current_md_slider_id + ']')
                .show()
                .css('width', $('.main_content').outerWidth() + 30)
                .css('height', $('.free_item').outerHeight() - 20);

            /* console.log($('.main_content').outerWidth())
            console.log($('.free_item').outerHeight()) */

            cx = $(this).find('img').get(0).naturalWidth / $(this).find('img').width();
            cy = $(this).find('img').get(0).naturalHeight / $(this).find('img').height();
            /* 
                        console.log(cx)
                        console.log(cy) */

            //check whether zoom preview div is too big, ensure the zoom preview could cover the whole image area
            var x_diff, y_diff;
            x_diff = $(this).find('img').get(0).naturalWidth - $('.image_zoom_preview[data-id=' + current_md_slider_id + ']').width();
            y_diff = $(this).find('img').get(0).naturalHeight - $('.image_zoom_preview[data-id=' + current_md_slider_id + ']').height();
            /* 
                        console.log(x_diff)
                        console.log(y_diff) */

            if ((x_diff < 0) && (x_diff < y_diff)) {
                cy = cx = $('.image_zoom_preview[data-id=' + current_md_slider_id + ']').width() / $(this).find('img').width()
            } else if ((y_diff < 0) && (y_diff < x_diff)) {
                cy = cx = $('.image_zoom_preview[data-id=' + current_md_slider_id + ']').height() / $(this).find('img').height()
            }
            /* console.log(cx)
            console.log(cy) */
            imageZoom(current_md_slider_id);
        })
        .on('mouseleave', '.slider_md_wrapper .tns-slide-active', function (e) {
            var current_md_slider_id = $(this).parents('.md_slider').data('id');
            //hide image zoom
            $('.image_zoom_preview[data-id=' + current_md_slider_id + ']').hide();
            $('.md_slider[data-id=' + current_md_slider_id + '] .magnifier_lens').remove();
        })
        .on('click', '.slider_md_wrapper .tns-slide-active .magnifier_lens', function (e) {
            console.log('clicked')

            var current_md_slider_id = $(this).parents('.md_slider').data('id');
            var img_id = $(this).parents('.a-image-wrapper').find('img').data('id');
            var img_src = $(this).parents('.a-image-wrapper').find('img').prop('src');
            main_scrollY = $(window).scrollTop();

            console.log(current_md_slider_id);
            console.log('.productGallery_m[data-id=' + current_md_slider_id + ']');


            $('.productGallery_m[data-id=' + current_md_slider_id + '] .image_wrapper').removeClass('selected');
            $('.productGallery_m[data-id=' + current_md_slider_id + '] .image_wrapper img[data-id=' + img_id + ']').parents('.image_wrapper')
                .addClass('selected');

            $('.productGallery_m[data-id=' + current_md_slider_id + '] .enlarged_image img').clearQueue().finish();

            $('.productGallery_m[data-id=' + current_md_slider_id + '] .enlarged_image img')
                .hide()
                .css('max-height', $(window).height() * 0.85 - 68)
                .prop('src', img_src)

            $('.productGallery_m[data-id=' + current_md_slider_id + ']').modal();

        })
        .on('click', '.productGallery_m .image_wrapper', function (e) {
            var current_md_slider_id = $(this).parents('.productGallery_m').data('id');
            $('.productGallery_m[data-id=' + current_md_slider_id + '] .image_wrapper').removeClass('selected');
            $(this).addClass('selected');

            $('.productGallery_m[data-id=' + current_md_slider_id + '] .enlarged_image img').clearQueue().finish();

            $('.productGallery_m[data-id=' + current_md_slider_id + '] .enlarged_image img')
                .hide()
                .css('max-height', $('.productGallery_m[data-id=' + current_md_slider_id + '] .modal-content').height() - 68)
                .prop('src', $(this).find('img').prop('src'))
        })

    $('.productGallery_m, .productGallery').on('hidden.bs.modal', function (e) {
        //scroll back to original position of the main page
        $(window).scrollTop(main_scrollY);
    })

    $(".productGallery_m .enlarged_image img").on("load change", function () {
        var current_md_slider_id = $(this).parents('.productGallery_m').data('id');
        $('.productGallery_m[data-id=' + current_md_slider_id + '] .enlarged_image img').fadeIn();
        $('.productGallery_m[data-id=' + current_md_slider_id + '] .enlarged_image').trigger('zoom.destroy');
        $('.productGallery_m[data-id=' + current_md_slider_id + '] .enlarged_image img.zoomImg').remove();
        $(this).removeClass('zoomable');

        if (($(this).get(0).naturalWidth >
            $('.productGallery_m[data-id=' + current_md_slider_id + '] .table_wrapper').get(0).offsetWidth)
            ||
            ($(this).get(0).naturalHeight >
                $('.productGallery_m[data-id=' + current_md_slider_id + '] .table_wrapper').get(0).offsetHeight)
        ) {
            $('.productGallery_m[data-id=' + current_md_slider_id + '] .enlarged_image').zoom({ on: 'click', url: $(this).prop('src') });
            $(this).addClass('zoomable')
        }
    })

    $(".btn_to_amazon")
        .on('mousedown touchstart', function (event) {
            $(this).addClass('touched');
        })
        .on('mouseup mouseout touchend', function (event) {
            $(this).removeClass('touched');
        })


    window.addEventListener("orientationchange", function () {
        //console.log('orientation')
        $('.productGallery .productGallery_slider, .productGallery .productGallery_slider > .tns-item')
            .css('height', $(window).height() - 50);
    }, false);

    $(window).on('resize', function () {
        //console.log('sized')
        $('.productGallery .productGallery_slider, .productGallery .productGallery_slider > .tns-item')
            .css('height', $(window).height() - 50);

        if ($(window).width() <= 970) {
            $('.productGallery_m').modal('hide');
            $('.productGallery_m .enlarged_image img')
                .prop('src', '');
        }

        $('.productGallery_m .enlarged_image img')
            .css('max-height', $('.productGallery_m .modal-content').height() - 68);

    });

    $(".productGallery").on("show", function () {
        $("body").addClass("modal-open");
    }).on("hidden", function () {
        $("body").removeClass("modal-open")
    });

    $('form.info_request').on('submit', function (e) {
        var name = $(this).find('input[name=name]');
        var email = $(this).find('input[name=email]');
        var success = $(this).find('.success');
        var fail = $(this).find('.fail');
        var btn_to_amazon = $(this).find('.btn_to_amazon');

        if (!name.is(':visible')) {
            name.show().focus();
            email.show();
            return false;
        }

        if (name.val() == '') {
            name.focus();
            return false;
        }
        if (!validateEmail(email.val())) {
            email.focus();
            return false;
        }

        var data = {
            name: name.val(),
            email: email.val(),
            file: $(this).find('input[name=file]').val()
        };

        $.ajax({
            type: "POST",
            url: "/ajax/email_downloadable_hash.php",
            data: data,
            success: function (result) {
                //console.log(result);
                if (result) {
                    name.hide();
                    email.hide();
                    btn_to_amazon.hide();
                    success.show();
                } else {
                    fail.show();
                }
            }
        });


        return false;
    })


})
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}