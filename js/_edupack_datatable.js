var selectedSKU;
jQuery(function ($) {
    var table;
    var selectedImageMap;
    var audio_icon = '<audio src="https://www.w3schools.com/html/horse.mp3" class="audioplay"></audio>';
    function initImgMap() {
        $('.image-map-container img:not([data-sku="' + selectedSKU + '"])').hide()
        $('.image-map-container img[data-sku="' + selectedSKU + '"]').css('display', 'block')
        $('map area').css('cursor', 'pointer')

        $("#image-map").hide();

        selectedImageMap = $("#image-map" + selectedSKU);

        selectedImageMap.show();

        selectedImageMap.imageMapResize();

        selectedImageMap.find('area').hover(
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

        selectedImageMap.find('area').off('click')
        selectedImageMap.find('area').on('click', function (e) {

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
                { scrollTop: $("#imageMapTable").offset().top },
                500
            );

            return false;

        });
        $(window).trigger('resize'); //fix image map placement incorrect after showing the hidden image
    }
    function initImgMapTable() {
        var n = 1;
        selectedImageMap.find('area').siblings().each(function () {
            //$(this).prop('data-row',n);
            $(this).attr('data-row', n++);
        })
        table = new Tabulator("#imageMapTable", {
            maxHeight: '100%',
            resizableColumns: false,
            cellVertAlign: "middle",
            columnHeaderVertAlign: "middle",
            tooltipsHeader: false, //enable header tooltips
            //tooltipGenerationMode: "hover", //regenerate tooltip as users mouse enters the cell;
            //tooltips: false,
            movableColumns: false,
            //data: tabledata,
            ajaxURL: '/bin/cap/' + selectedSKU + '.json', //ajax URL
            layout: "fitColumns",
            langs: {
                "jp-jp": {
                    "columns": {
                        "formatted_name": "名前",
                        "audio": "オーディオ",
                        "source1": "外部参照 JP",
                        "source2": "外部参照 EN",
                    }
                },
            },
            columns: [
                //{ field: "id", width: 20, headerSort: false },
                { title: "Name", field: "formatted_name", formatter: "html", variableHeight: true, headerSort: false, widthGrow: 1 },
                { title: "Audio", field: "audio", formatter: "html", width: 100, hozAlign: "center", headerSort: false },
                { title: "Source 1", field: "source1", formatter: "html", /* variableHeight: true, */ widthGrow: 1, headerSort: false },
                { title: "Source 2", field: "source2", formatter: "html", /* variableHeight: true, */ widthGrow: 1, headerSort: false }
            ],
            renderComplete: function () {
                renderAudioBtn()
            }
        });
        table.setLocale("jp-jp");
        $('#imageMapTable .tabulator-tableHolder').on('scroll', function () {
            renderAudioBtn()
        })
    }

    function renderAudioBtn() {
        $('audio.audioplay').mediaelementplayer({
            features: ['playpause'],
            audioWidth: 20,
            audioHeight: 20
        });
    }

    function toggleInteractiveTable(to_status, toggle_element) {
        if (to_status == 1) {
            initImgMap();
            initImgMapTable();
            $('.imageMapWrapper').show();
            $(window).trigger('resize');
            toggle_element.find('.fa-caret-right').hide();
            toggle_element.find('.fa-caret-down').show();
            toggle_element.data('state', 1)
        } else {
            $('.imageMapWrapper').hide();
            toggle_element.find('.fa-caret-down').hide();
            toggle_element.find('.fa-caret-right').show();
            toggle_element.data('state', 0)
        }

    }
    function bindPageClick() {
        $('ul.pages li a').on('click', function (e) {
            e.preventDefault();
            if (selectedSKU != $(this).parent('li').data('page')) {
                selectedSKU = $(this).parent('li').data('page')
                $(this).parents('ul').find('li').not('[data-page="' + selectedSKU + '"]').removeClass('selected')
                $(this).parents('ul').find('li[data-page="' + selectedSKU + '"]').addClass('selected')
                initImgMap()
                initImgMapTable()
            }
            return false;
        })
    }
    var isAjaxLoaded = false;
    $('body').on('click', 'a.toggle_interactive_table', function (e) {
        e.preventDefault();
        var thiselemnt = $(this)
        selectedSKU = thiselemnt.data('title');
        if ($(this).data('state') == 0) {
            /* if (!isAjaxLoaded) { */
            $.ajax({
                url: "/html/",
                method: 'POST',
                data: {
                    type: 'edupack',
                    sku: selectedSKU
                }
            }).done(function (html) {
                $('.imageMapWrapper').html(html);
                isAjaxLoaded = true;
                toggleInteractiveTable(1, thiselemnt)
                bindPageClick();
            })
            /* } else {
                toggleInteractiveTable(1, thiselemnt)
            } */
        } else {
            toggleInteractiveTable(0, thiselemnt)
        }
        return false;
    }).on('click', 'a.toggle_handbook', function (e) {
        e.preventDefault()
        if ($(window).width() <= 1024)
            window.open('/files/?type=handbook&sku=' + $(this).data('title'), '_blank');
        else
            window.open('/html/flip/?i=' + $(this).data('title'), '_blank');
    });


    $(window).on('orientationchange', function () {
        $(window).one('resize', function () {
            if ($('a.toggle_interactive_table').data('state') == 1)
                initImgMapTable()
        });
    })
});