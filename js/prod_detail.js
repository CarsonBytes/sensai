var tabledata = [];
for (i = 1; i < 100; i++) {
    tabledata.push({ id: i, name: 'Labrador Retriever', name_jp: 'ラブラドール・レトリバー', wiki: 'https://www.wikipedia.com', source1: 'https://www.google.com', source2: 'https://www.yahoo.com', source3: 'https://www.google.jp', audio: 'https://www.w3schools.com/html/horse.ogg' });
}
var table;

//Generate print icon
var wikiIcon = function (cell, formatterParams) {
    return "<i class=\"fab fa-wikipedia-w\"></i>";
};
var linkIcon = function (cell, formatterParams) {
    //return "<i class=\"fas fa-external-link-alt\"></i>";
    return "<i class=\"fas fa-external-link-alt\"></i>";
};
var audioIcon = function (cell, formatterParams) {
    //return "<i class=\"fas fa-play\"></i>";
    return "<i class=\"fas fa-volume-up\"></i>";
    //return '<audio controls><source src="https://www.w3schools.com/html/horse.ogg" type="audio/ogg"><source src="https://www.w3schools.com/html/horse.mp3" type="audio/mpeg">Your browser does not support the audio element.</audio>';
    //return "<audio src=\"https://www.w3schools.com/html/horse.ogg\"></audio>";
};

var nameFormatter = function (cell, formatterParams) {
    var rowData = cell.getData();
    var cellValue = cell.getValue();

    return '<div class="col_name">' + rowData.name_jp + '<br />(' + cell.getValue() + ')</div>';
};

var sourceFormatter = function (cell, formatterParams) {
    var rowData = cell.getData();
    var cellValue = cell.getValue();

    //console.log(rowData);

    var html = '<ul class="col_source">';

    if ('source1' in rowData)
        html += '<li><a href="' + rowData.source1 + '"><i class=\"fas fa-external-link-alt\"></i></a></li>';

    if ('source2' in rowData)
        html += '<li><a href="' + rowData.source2 + '"><i class=\"fas fa-external-link-alt\"></i></a></li>';

    if ('source3' in rowData)
        html += '<li><a href="' + rowData.source3 + '"><i class=\"fas fa-external-link-alt\"></i></a></li>';

    html += '</ul>';

    return html;
};

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
        jQuery('.image_zoom_preview').append('<div class="large_preview_bg" data-id="' + img_element.data('id') + '" style="position:absolute;width:100%;height:100%;background-image: url(' + getImgSizeUrl(img_element.get(0).src, 'L') + ')"></div>');
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

    lazySizes.init();

    slider1 = tns({
        container: '.my-slider1',
        items: 1,
        controls: false,
        navPosition: 'bottom',
        center: true,
        autoHeight: true,
        preventScrollOnTouch: 'auto',
        gutter: 30
        //,lazyload: true
    });

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
        //,lazyload: true
    });


    $('body').on('click', '.my-slider1 .tns-slide-active img', function (e) {

        main_scrollY = $(window).scrollTop();

        //init modal size
        $('#productGallery').modal();

        slider1_info = slider1.getInfo();

        $('.my-slider2').hide();
        if (slider2 != null) {
            //console.log('rebuilding..')
            slider2.destroy();
        }
        slider2 = tns({
            container: '.my-slider2',
            items: 1,
            navAsThumbnails: true,
            navContainer: '#customize-thumbnails',
            controls: false,
            center: true,
            preventScrollOnTouch: 'auto',
            gutter: 30,
            loop: false
            //,lazyload: true
        });
        slider2.goTo(slider1_info.index - 1);

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
            var img_src = getImgSizeUrl($(this).parents('.a-image-wrapper').find('img').prop('src'), 'L');

            $('#productGallery_m .image_wrapper').removeClass('selected');
            $('#productGallery_m .image_wrapper img[data-id=' + img_id + ']').parents('.image_wrapper')
                .addClass('selected');

            $('#productGallery_m .enlarged_image img').clearQueue().finish();

            $('#productGallery_m .enlarged_image img')
                .hide()
                .css('max-height', $(window).height() * 0.85 - 68)
                .prop('src', img_src)

            $('#productGallery_m').modal();

        })
        .on('click', '#productGallery_m .image_wrapper', function (e) {
            $('#productGallery_m .image_wrapper').removeClass('selected');
            $(this).addClass('selected');

            $('#productGallery_m .enlarged_image img').clearQueue().finish();

            $('#productGallery_m .enlarged_image img')
                .hide()
                .css('max-height', $('#productGallery_m .modal-content').height() - 68)
                .prop('src', getImgSizeUrl($(this).find('img').prop('src'), 'L'))
        })

    $('#productGallery_m, #productGallery').on('hidden.bs.modal', function (e) {
        //scroll back to original position of the main page
        $(window).scrollTop(main_scrollY);
    })

    $("#productGallery_m .enlarged_image img").on("load change", function () {
        $('#productGallery_m .enlarged_image img').fadeIn();

        $('#productGallery_m .enlarged_image').trigger('zoom.destroy');
        $('#productGallery_m .enlarged_image img.zoomImg').remove();
        $(this).removeClass('zoomable');


        /*  console.log($(this).get(0).naturalWidth)
        console.log($('#productGallery_m .table_wrapper').get(0).offsetWidth)
        
        console.log($(this).get(0).naturalHeight)
        console.log($('#productGallery_m .table_wrapper').get(0).offsetHeight)  */

        if (($(this).get(0).naturalWidth >
            $('#productGallery_m .table_wrapper').get(0).offsetWidth)
            ||
            ($(this).get(0).naturalHeight >
                $('#productGallery_m .table_wrapper').get(0).offsetHeight)
        ) {
            $('#productGallery_m .enlarged_image').zoom({ on: 'click', url: getImgSizeUrl($(this).prop('src'), 'L') });
            $(this).addClass('zoomable')
        }
    })

    $(".btn_to_amazon")
        .on('mousedown touchstart', function (event) {
            $(this).addClass('focus');
        })
        .on('mouseup mouseout touchend', function (event) {
            $(this).removeClass('focus');
        })


    window.addEventListener("orientationchange", function () {
        //console.log('orientation')
        $('#productGallery .my-slider2, #productGallery .my-slider2 > .tns-item')
            .css('height', $(window).height() - 50);
    }, false);

    $(window).on('resize', function () {
        //console.log('sized')
        $('#productGallery .my-slider2, #productGallery .my-slider2 > .tns-item')
            .css('height', $(window).height() - 50);

        if ($(window).width() <= 970) {
            $('#productGallery_m').modal('hide');
            $('#productGallery_m .enlarged_image img')
                .prop('src', '');
        }

        $('#productGallery_m .enlarged_image img')
            .css('max-height', $('#productGallery_m .modal-content').height() - 68);

    });

    $("#productGallery").on("show", function () {
        $("body").addClass("modal-open");
    }).on("hidden", function () {
        $("body").removeClass("modal-open")
    });

    if ($('#example-table').length) {
        table = new Tabulator("#example-table", {
            columnHeaderVertAlign: "middle", //align header contents to bottom of cell
            //columnHeaderVertAlign :"middle", //align header contents to bottom of cell
            tooltipsHeader: true, //enable header tooltips
            tooltipGenerationMode: "hover", //regenerate tooltip as users mouse enters the cell;
            tooltips: true,
            height: "600px",
            data: tabledata,
            layout: "fitColumns",
            langs: {
                "jp-jp": {
                    "columns": {
                        "name": "名前",
                        "audio": "オーディオ",
                        "wiki": "ウィキペディア",
                        "source1": "外部参照",
                        //"source2":"外部参照2",
                        //"source3":"外部参照3",
                    }
                },
            },
            columns: [
                { field: "id", width: 20, headerSort: false },
                { title: "Name", field: "name", formatter: nameFormatter, headerSort: false, widthGrow: 4/*, width: 180*/ },
                { title: "Audio", field: "audio", formatter: audioIcon, titleFormatter: audioIcon, /* width: 90,  */align: "center", cellClick: function (e, cell) { window.open(cell.getRow().getData().audio) }, headerSort: false },
                { title: "Wikipedia", field: "wiki", formatter: wikiIcon, titleFormatter: wikiIcon,/*  width: 80, */ align: "center", cellClick: function (e, cell) { window.open(cell.getRow().getData().wiki) }, headerSort: false },
                { title: "Source 1", field: "source1", formatter: sourceFormatter, widthGrow: 2, /* width: 90, */ align: "center", cellClick: function (e, cell) { window.open(cell.getRow().getData().source1) }, headerSort: false }
                //{ title: "Source 2", field: "source2", formatter: linkIcon, width: 90, align: "center", cellClick: function (e, cell) { window.open(cell.getRow().getData().source2) } },
                //{ title: "Source 3", field: "source3", formatter: linkIcon, width: 90, align: "center", cellClick: function (e, cell) { window.open(cell.getRow().getData().source3) } }
            ],
        });

        table.setLocale("jp-jp");
    }

    if ($('#image-map').length) {
        $('#image-map').imageMapResize();

        $('#image-map area').hover(
            function () {
                var coords = $(this).attr('coords').split(',');
                var width = $('.image-map-container').width();
                var height = $('.image-map-container').height();
                $('.image-map-container .map-selector').addClass('hover').css({
                    'left': coords[0] + 'px',
                    'top': coords[1] + 'px',
                    'right': width - coords[2] + 'px',
                    'bottom': height - coords[3] + 'px'
                })
            },
            function () {
                $('.image-map-container .map-selector').removeClass('hover').attr('style', '');
            }
        )
        $('#image-map area').click(function (e) {

            e.preventDefault();

            var $row = $(this).data('row');

            table.scrollToRow($row, 'top', true);

            table.deselectRow();

            setTimeout(function () {
                table.selectRow($row);
            }, 200);

            setTimeout(function () {
                table.deselectRow($row);
            }, 400);

            setTimeout(function () {
                table.selectRow($row);
            }, 600);


            $("html, body").animate(
                { scrollTop: $("#example-table").offset().top },
                500
            );

            return false;

        });
    }

})

/*console.log($(this).attr('coords'))
console.log(coords )
console.log(width )
console.log(height )
console.log(coords[0]+'px')
console.log(coords[1]+'px')
console.log(width - coords[2] + 'px')
console.log(height - coords[3] + 'px')*/

/* function scroll_to_row(kind) {
    table.scrollToRow(document.getElementById("row-id").value, kind, true);
} */