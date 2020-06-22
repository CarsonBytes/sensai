var table;
jQuery(function ($) {
    function initImgMap() {
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
                { scrollTop: $("#imageMapTable").offset().top },
                500
            );

            return false;

        });
    }
    function initImgMapTable() {
        var n = 1;
        var nameFormatter = function (cell, formatterParams) {
            var rowData = cell.getData();
            var cellValue = cell.getValue();

            return '<div class="col_name">' + rowData.name_jp + '<br />(' + cell.getValue() + ')</div>';
        };
        $('#image-map area').siblings().each(function () {
            //$(this).prop('data-row',n);
            $(this).attr('data-row', n++);
        })
        table = new Tabulator("#imageMapTable", {
            maxHeight: '100%',
            //height: '600px',
            columnHeaderVertAlign: "middle", //align header contents to bottom of cell
            //columnHeaderVertAlign :"middle", //align header contents to bottom of cell
            tooltipsHeader: false, //enable header tooltips
            tooltipGenerationMode: "hover", //regenerate tooltip as users mouse enters the cell;
            tooltips: false,
            movableColumns: false,
            //data: tabledata,
            ajaxURL: "/bin/cap/P12001.json", //ajax URL
            layout: "fitColumns",
            langs: {
                "jp-jp": {
                    "columns": {
                        "name": "名前",
                        "audio": "オーディオ",
                        //"wiki": "ウィキペディア",
                        "source1": "外部参照",
                        //"source2":"外部参照2",
                        //"source3":"外部参照3",
                    }
                },
            },
            columns: [
                { field: "id", width: 20, headerSort: false },
                { title: "Name", field: "name", formatter: nameFormatter, headerSort: false, widthGrow: 1/*, width: 180*/ },
                //{ title: "Audio", field: "audio", formatter: audioIcon, titleFormatter: audioIcon, /* width: 90,  */align: "center", cellClick: function (e, cell) { window.open(cell.getRow().getData().audio) }, headerSort: false },
                //{ title: "Wikipedia", field: "wiki", formatter: wikiIcon, titleFormatter: wikiIcon,/*  width: 80, */ align: "center", cellClick: function (e, cell) { window.open(cell.getRow().getData().wiki) }, headerSort: false },
                { title: "Audio", field: "audio", formatter: "html", width: 100, hozAlign: "center", headerSort: false },
                { title: "Source 1", field: "source1", formatter: "html", widthGrow: 1, /* width: 90,  align: "center", cellClick: function (e, cell) { window.open(cell.getRow().getData().source1) },*/ headerSort: false }
                //{ title: "Source 2", field: "source2", formatter: linkIcon, width: 90, align: "center", cellClick: function (e, cell) { window.open(cell.getRow().getData().source2) } },
                //{ title: "Source 3", field: "source3", formatter: linkIcon, width: 90, align: "center", cellClick: function (e, cell) { window.open(cell.getRow().getData().source3) } }
            ],
            renderComplete: function () {
                /* console.log('renderComplete');
                console.log($('audio.audioplay')); */
                $('audio.audioplay').mediaelementplayer({
                    features: ['playpause'],
                    audioWidth: 20,
                    audioHeight: 20
                });
            }
        });
        table.setLocale("jp-jp");
        $('#imageMapTable .tabulator-tableHolder').on('scroll', function () {
            /* console.log('scroll');
            console.log($('audio.audioplay')); */
            $('audio.audioplay').mediaelementplayer({
                features: ['playpause'],
                audioWidth: 20,
                audioHeight: 20
            });
        })
    }
    $('a.toggle_interactive_table').on('click', function () {
        if ($(this).data('state') == 0) {
            if ($(this).data('init') == 0) {
                initImgMap();
                $(this).data('init', 1)
            }
            initImgMapTable();
            $('.interactive_table').show();
            $(window).trigger('resize');
            $(this).find('.fa-caret-right').hide();
            $(this).find('.fa-caret-down').show();
            $(this).data('state', 1)
        } else {
            $('.interactive_table').hide();
            $(this).find('.fa-caret-down').hide();
            $(this).find('.fa-caret-right').show();
            $(this).data('state', 0)
        }
    })
});