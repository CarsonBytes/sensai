var selectedSKU = 'P12001';
jQuery(function ($) {
    var table;
    var selectedImageMap;
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
        selectedImageMap.find('area').click(function (e) {

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
        var nameFormatter = function (cell, formatterParams) {
            var rowData = cell.getData();
            var cellValue = cell.getValue();

            return '<div class="col_name">' + rowData.name_jp + '<br />(' + cell.getValue() + ')</div>';
        };
        selectedImageMap.find('area').siblings().each(function () {
            //$(this).prop('data-row',n);
            $(this).attr('data-row', n++);
        })
        table = new Tabulator("#imageMapTable", {
            maxHeight: '100%',
            columnHeaderVertAlign: "middle", //align header contents to bottom of cell
            tooltipsHeader: false, //enable header tooltips
            tooltipGenerationMode: "hover", //regenerate tooltip as users mouse enters the cell;
            tooltips: false,
            movableColumns: false,
            //data: tabledata,
            ajaxURL: '/bin/cap/' + selectedSKU + '.json', //ajax URL
            layout: "fitColumns",
            langs: {
                "jp-jp": {
                    "columns": {
                        "name": "名前",
                        "audio": "オーディオ",
                        "source1": "外部参照",
                    }
                },
            },
            columns: [
                { field: "id", width: 20, headerSort: false },
                { title: "Name", field: "name", formatter: nameFormatter, headerSort: false, widthGrow: 1/*, width: 180*/ },
                { title: "Audio", field: "audio", formatter: "html", width: 100, hozAlign: "center", headerSort: false },
                { title: "Source 1", field: "source1", formatter: "html", widthGrow: 1, /* width: 90,  align: "center", cellClick: function (e, cell) { window.open(cell.getRow().getData().source1) },*/ headerSort: false }
            ],
            renderComplete: function () {
                $('audio.audioplay').mediaelementplayer({
                    features: ['playpause'],
                    audioWidth: 20,
                    audioHeight: 20
                });
            }
        });
        table.setLocale("jp-jp");
        $('#imageMapTable .tabulator-tableHolder').on('scroll', function () {
            $('audio.audioplay').mediaelementplayer({
                features: ['playpause'],
                audioWidth: 20,
                audioHeight: 20
            });
        })
    }

    function toggleInteractiveTable(to_status, toggle_element) {
        if (to_status == 1) {
            if (toggle_element.data('init') == 0) {
                initImgMap();
                toggle_element.data('init', 1)
            }
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
                $(this).parents('ul').find('li').not('[data-page="'+selectedSKU+'"]').removeClass('selected')
                $(this).parents('ul').find('li[data-page="'+selectedSKU+'"]').addClass('selected')
                initImgMap()
                initImgMapTable()
            }
            return false;
        })
    }
    var isAjaxLoaded = false;
    $('a.toggle_interactive_table').on('click', function (e) {
        e.preventDefault();
        var thiselemnt = $(this)
        if ($(this).data('state') == 0) {
            if (!isAjaxLoaded) {
                $.ajax({
                    url: "/html/edupack/cats.php",
                    method: 'POST',
                    data: { sku: selectedSKU }
                }).done(function (html) {
                    $('.imageMapWrapper').html(html);
                    isAjaxLoaded = true;
                    toggleInteractiveTable(1, thiselemnt)
                    bindPageClick();
                })
            } else {
                toggleInteractiveTable(1, thiselemnt)
            }
        } else {
            toggleInteractiveTable(0, thiselemnt)
        }
        return false;
    })
});