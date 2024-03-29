var selectedSKU;
var selectedPage;
var selectedType;
var table;
jQuery(function ($) {
    var selectedImageMap;
    var tableSKU = '';

    var audioBtn = function (cell, formatterParams, onRendered) {
        return '<i class="fas fa-volume-up"></i> '+ formatterParams.lang ;
    }

    function isScrolledIntoView(el) {
        var rect = el.getBoundingClientRect();
        var elemTop = rect.top;
        var elemBottom = rect.bottom;

        // Only completely visible elements return true:
        var isVisible = (elemTop >= 0) && (elemBottom <= window.innerHeight);
        // Partially visible elements return true:
        //isVisible = elemTop < window.innerHeight && elemBottom >= 0;
        return isVisible;
    }
    function initImgMap() {
        $('.image-map-container img:not(.' + selectedType + selectedSKU + selectedPage.toString() + ')').hide()
        $('.image-map-container img.' + selectedType + selectedSKU + selectedPage.toString()).show()
        /* console.log(selectedType + selectedSKU + selectedPage.toString())
        console.log(selectedType)
        console.log(selectedSKU)
        console.log(selectedPage) */

        $('map area').css('cursor', 'pointer')
        $("map").hide();

        selectedImageMap = $("#image-map" + selectedType + selectedSKU + selectedPage);
        var n = 1;
        selectedImageMap.find('area').siblings().each(function () {
            //$(this).prop('data-row',n);
            $(this).attr('data-row', n++);
        })

        //console.log(selectedImageMap)

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

            if (selectedType == 'edupack') {
                var $row = $(this).data('row');
                var currentRowID = $row;
            } else {
                var $row = table.getRows().filter(row => row.getData().handbook_page == $('ul.pages li.selected').data('page') && row.getData().handbook_order == $(this).data('row'))[0]
                var currentRowID = $row.getData().id;
            }

            /* console.log($('ul.pages li.selected').data('page'))
            console.log($(this).data('row'))

            console.log($row) */


            if (currentRowID == 1 || currentRowID == table.getRows().length)
                table.scrollToRow($row, 'top', true);
            else
                table.scrollToRow(currentRowID - 1, 'top', true);

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

            var scrollElement;
            if (!$('.navbar').is(':visible') || currentRowID > table.getRows().length - 2)
                scrollElement = $("#imageMapTable");
            else
                scrollElement = $("#imageMapTable"); //$(".edupack_button");

            $("html, body").animate(
                { scrollTop: scrollElement.offset().top },
                500
            );

            return false;

        });
        $(window).trigger('resize'); //fix image map placement incorrect after showing the hidden image
    }
    function initImgMapTable(isSwitchPage = false) {
        if (tableSKU == $('ul.pages li.selected').data('sku') && isSwitchPage) return false;
        table = new Tabulator("#imageMapTable", {
            maxHeight: '100%',
            resizableColumns: false,
            cellVertAlign: "middle",
            columnHeaderVertAlign: "middle",
            tooltipsHeader: false, //enable header tooltips
            //tooltipGenerationMode: "hover", //regenerate tooltip as users mouse enters the cell;
            //tooltips: false,
            movableColumns: false,
            ajaxURL: '/bin/cap/' + $('ul.pages li.selected').data('sku') + '.json', //ajax URL
            layout: "fitColumns",
            langs: {
                "ja-JP": {
                    "columns": {
                        "name": "名前 EN",
                        "name_de": "名前 DE",
                        "name_jp": "名前 JP",
                        "audio": "EN",
                        "audio_de": "DE",
                        "audio_jp": "JP",
                        "source": "外部参照 EN",
                        "source_de": "外部参照 DE",
                        "source_jp": "外部参照 JP",
                    }
                },
                "en-GB": {
                    "columns": {
                        "name": "Name EN",
                        "name_de": "Name DE",
                        "name_jp": "Name JP",
                        "audio": "EN",
                        "audio_de": "DE",
                        "audio_jp": "JP",
                        "source": "Source EN",
                        "source_de": "Source DE",
                        "source_jp": "Source JP",
                    }
                },
            },
            columns: [
                //{ field: "id", width: 20, headerSort: false },
                /* { field: "handbook_page", width: 20, headerSort: false },
                { field: "handbook_order", width: 20, headerSort: false }, */
                { title: "Name DE", field: "name_de", formatter: "html", variableHeight: true, headerSort: false, widthGrow: 3 },
                { title: "Name JP", field: "name_jp", formatter: "html", variableHeight: true, headerSort: false, widthGrow: 2 },
                { title: "Name EN", field: "name", formatter: "html", variableHeight: true, headerSort: false, widthGrow: 2 },
                { title: "DE", field: "audio_de", formatter: "html", hozAlign: "center", titleFormatter: audioBtn, titleFormatterParams: { lang: 'DE' },widthGrow: 1, headerSort: false },
                { title: "JP", field: "audio_jp", formatter: "html", hozAlign: "center", titleFormatter: audioBtn, titleFormatterParams: { lang: 'JP' },widthGrow: 1, headerSort: false },
                { title: "EN", field: "audio", formatter: "html", hozAlign: "center", titleFormatter: audioBtn, titleFormatterParams: { lang: 'EN' }, widthGrow: 1, headerSort: false },
                { title: "Source EN", field: "source", formatter: "html", /* variableHeight: true, */ widthGrow: 2, headerSort: false },
                { title: "Source DE", field: "source_de", formatter: "html", /* variableHeight: true, */ widthGrow: 2, headerSort: false },
                { title: "Source JP", field: "source_jp", formatter: "html", /* variableHeight: true, */ widthGrow: 2, headerSort: false }
            ],
            renderComplete: function () {
                renderAudioBtn()
            }
        });
        table.setLocale(locale);
        $('#imageMapTable .tabulator-tableHolder').on('scroll', function () {
            renderAudioBtn()
        })
        tableSKU = $('ul.pages li.selected').data('sku');
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
            $('a.toggle_interactive_table').data('state', 0);
            $('.fa-caret-right').show();
            $('.fa-caret-down').hide();
            toggle_element.find('.fa-caret-right').hide();
            toggle_element.find('.fa-caret-down').show();
            toggle_element.data('state', 1)
        } else {
            $('.imageMapWrapper').hide();
            $('.fa-caret-right').show();
            $('.fa-caret-down').hide();
            $('a.toggle_interactive_table').data('state', 0);
        }

    }
    function bindPageClick(selectedLi) {
        selectedLi = (typeof selectedLi !== 'undefined') ? selectedLi.parent('li') : $('ul.pages li.selected');
        //console.log(selectedLi)
        selectedSKU = selectedLi.data('sku')
        selectedPage = selectedLi.data('page')
        selectedType = selectedLi.data('type')
        $('ul.pages li').removeClass('selected')
        selectedLi.addClass('selected')
        initImgMap()
        initImgMapTable(true)
    }

    var table_columns = {};
    table_columns['en-GB'] = ['name', 'audio', 'source'];
    table_columns['ja-JP'] = ['name_jp', 'name', 'audio_jp', 'source_jp'];
    table_columns['de-DE'] = ['name_de', 'name', 'audio_de', 'source_de'];

    function switchLocale(locale = 'all') {
        if (locale == 'all') {
            for (var locale_code in table_columns) {
                table_columns[locale_code].forEach(
                    function (element) {
                        table.showColumn(element)
                    }
                )
            }
        } else {
            for (var locale_code in table_columns) {
                if (locale_code != locale)
                    table_columns[locale_code].forEach(
                        function (element) {
                            table.hideColumn(element)
                        }
                    )
                else
                    continue;

            }
            for (var locale_code in table_columns) {
                if (locale_code == locale)
                    table_columns[locale_code].forEach(
                        function (element) {
                            table.showColumn(element)
                        }
                    )
                else
                    continue;

            }
        }
        table.redraw();
    }

    var isAjaxLoaded = false;
    $('body').on('click', 'a.toggle_interactive_table', function (e) {
        e.preventDefault();
        var loader = $(this).find('.ajax_loader');
        var span = $(this).find('span');
        var thiselemnt = $(this);
        selectedSKU = thiselemnt.data('sku');
        selectedPage = thiselemnt.data('page');
        selectedType = thiselemnt.data('type');
        if (loader.is(':visible')) return false;
        if ($(this).data('state') == 0) {
            /* if (!isAjaxLoaded) { */
            $.ajax({
                url: "/html/",
                method: 'POST',
                data: {
                    type: selectedType,
                    sku: selectedSKU,
                    page: selectedPage
                },
                beforeSend: function() {
                    loader.show();
                    span.css('visibility', 'hidden');
                }
            })
            .done(function (html) {
                $('.imageMapWrapper').html(html);
                //isAjaxLoaded = true;
                toggleInteractiveTable(1, thiselemnt)
                bindPageClick();
                $('ul.pages li a').on('click', function (e) {
                    e.preventDefault();
                    bindPageClick($(this));
                    return false;
                })
                loader.hide();
                span.css('visibility', 'visible');
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
            window.open('/files/?type=handbook&sku=' + $(this).data('sku'), '_blank');
        else
            window.open('/html/flip/?i=' + $(this).data('sku'), '_blank');

    }).on('change', '.locale_selector', function (e) {
        switchLocale($(this).prop('value'));
    });


    $(window).on('orientationchange', function () {
        $(window).one('resize', function () {
            if ($('a.toggle_interactive_table').data('state') == 1)
                initImgMapTable()
        });
    })

    $('.edupack_button').show();


});