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

    return '<div class="col_name">'+rowData.name_jp + '<br />(' + cell.getValue() + ')</div>';
};

var sourceFormatter = function (cell, formatterParams) {
    var rowData = cell.getData();
    var cellValue = cell.getValue();

    console.log(rowData);

    var html = '<ul class="col_source">';

    if ('source1' in rowData) 
        html += '<li><a href="'+rowData.source1+'"><i class=\"fas fa-external-link-alt\"></i></a></li>';

    if ('source2' in rowData) 
        html += '<li><a href="'+rowData.source2+'"><i class=\"fas fa-external-link-alt\"></i></a></li>';

    if ('source3' in rowData) 
        html += '<li><a href="'+rowData.source3+'"><i class=\"fas fa-external-link-alt\"></i></a></li>';

    html += '</ul>';

    return html;
};

jQuery(function ($) {
    if ($('#example-table').length) {
        table = new Tabulator("#example-table", {
            columnVertAlign:"middle", //align header contents to bottom of cell
            tooltipsHeader:true, //enable header tooltips
            tooltipGenerationMode:"hover", //regenerate tooltip as users mouse enters the cell;
            tooltips:true,
            height: "600px",
            data: tabledata,
            layout: "fitColumns",
            langs:{
                "jp-jp":{
                    "columns":{
                        "name":"名前",
                        "audio":"オーディオ",
                        "wiki":"ウィキペディア",
                        "source1":"外部参照",
                        //"source2":"外部参照2",
                        //"source3":"外部参照3",
                    }
                },
            },
            columns: [
                { field: "id", width: 20, headerSort:false},
                { title: "Name", field: "name", formatter: nameFormatter, headerSort:false, widthGrow:4/*, width: 180*/},
                { title: "Audio", field: "audio", formatter: audioIcon, titleFormatter: audioIcon, /* width: 90,  */align: "center", cellClick: function (e, cell) { window.open(cell.getRow().getData().audio) }, headerSort:false },
                { title: "Wikipedia", field: "wiki", formatter: wikiIcon, titleFormatter: wikiIcon,/*  width: 80, */ align: "center", cellClick: function (e, cell) { window.open(cell.getRow().getData().wiki) }, headerSort:false },
                { title: "Source 1", field: "source1", formatter: sourceFormatter, widthGrow:2, /* width: 90, */ align: "center", cellClick: function (e, cell) { window.open(cell.getRow().getData().source1) }, headerSort:false }
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

    $("div").filter(function () {
        return $(this).text() === "FaLang translation system by Faboba";
    }).css("display", "none");

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