var selectedSKU;
var selectedPage;
var selectedType;
jQuery(function ($) {
    var table;
    var selectedImageMap;
    var tableSKU = '';
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
                scrollElement = $(".edupack_button");

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
                /* { field: "handbook_page", width: 20, headerSort: false },
                { field: "handbook_order", width: 20, headerSort: false }, */
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
    var isAjaxLoaded = false;
    $('body').on('click', 'a.toggle_interactive_table', function (e) {
        e.preventDefault();
        var thiselemnt = $(this)
        selectedSKU = thiselemnt.data('sku');
        selectedPage = thiselemnt.data('page');
        selectedType = thiselemnt.data('type');
        if ($(this).data('state') == 0) {
            /* if (!isAjaxLoaded) { */
            $.ajax({
                url: "/html/",
                method: 'POST',
                data: {
                    type: selectedType,
                    sku: selectedSKU,
                    page: selectedPage
                }
            }).done(function (html) {
                $('.imageMapWrapper').html(html);
                //isAjaxLoaded = true;
                toggleInteractiveTable(1, thiselemnt)
                bindPageClick();
                $('ul.pages li a').on('click', function (e) {
                    e.preventDefault();
                    bindPageClick($(this));
                    return false;
                })
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
    });


    $(window).on('orientationchange', function () {
        $(window).one('resize', function () {
            if ($('a.toggle_interactive_table').data('state') == 1)
                initImgMapTable()
        });
    })

    $('.edupack_button').show();
});