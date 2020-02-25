var sm_sliders = [];
var slider1_info = null; // sm slider
var slider2_info = null; // slider in sm gallery
var productGallery_slider = null;
var main_scrollY = 0;

jQuery(function ($) {
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
            });

            // bind function to event
            productGallery_slider.events.on('indexChanged', function () {
                slider2_info = productGallery_slider.getInfo();
                sm_sliders[current_sm_slider_id].goTo(slider2_info.index);
            });

            //tweak to -100 (2 lines) for related bundles
            $('.productGallery .productGallery_slider[data-id=' + current_sm_slider_id + '], .productGallery[data-id=' + current_sm_slider_id + '] .productGallery_slider > .tns-item')
                .css('height', $(window).height() - 100);

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
    });


    $('.productGallery_m, .productGallery').on('hidden.bs.modal', function (e) {
        //scroll back to original position of the main page
        $(window).scrollTop(main_scrollY);
    })


    $(".productGallery").on("show", function () {
        $("body").addClass("modal-open");
    }).on("hidden", function () {
        $("body").removeClass("modal-open")
    });
});
