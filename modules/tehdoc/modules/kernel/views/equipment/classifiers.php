<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;


$this->title = 'Пользовательские классификаторы';
$this->params['breadcrumbs'][] = ['label' => 'Тех Док', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = ['label' => 'Оборудование', 'url' => ['/tehdoc/kernel/']];
$this->params['breadcrumbs'][] = $this->title;

$about = "Панель отображения и управления оборудованием, логически поделенного на пользовательские классификаторы. При сбое, перезапустите форму, воспользовавшись соответствующей клавишей.";
$refresh_hint = 'Перезапустить форму';
$dell_hint = 'Удалить выделенное оборудование из таблицы классификатора';
$send_hint = 'Передать выделенные строки в подробную версию таблицы';

?>

<style>
  .h-title {
    font-size: 18px;
    color: #1e6887;
  }

  li {
    word-wrap: break-word
  }

  .fa {
    font-size: 15px;
  }

  ul.fancytree-container {
    font-size: 12px;
  }

  input {
    color: black;
  }

  #main-table {
    font-size: 12px;
  }

  td .fa {
    font-size: 22px;
  }

  .show-menu-button {
    position: absolute;
    background-color: #f5f7f8;
    top: 0px;
    left: -20px;
    width: 15px;
    height: 100%;
    cursor: pointer;
    text-align: center;
    padding-top: 25px;
    border-radius: 1px;
  }

</style>

<div class="eq-classifiers-pannel">
  <h1><?= Html::encode($this->title) ?>
    <sup class="h-title fa fa-question-circle-o" aria-hidden="true"
         data-toggle="tooltip" data-placement="right" title="<?php echo $about ?>"></sup>
  </h1>
</div>

<div class="row">
  <div class="col-lg-4 col-md-4 fancy-tree" style="padding-bottom: 5px">
    <div class="row" style="margin-bottom: 10px;padding-left: 15px">
      <?= Html::a('<i class="fa fa-refresh" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-success btn-sm refresh',
          'style' => ['margin-top' => '5px'],
          'title' => $refresh_hint,
          'data-toggle' => 'tooltip',
          'data-placement' => 'top'
      ]) ?>
    </div>

    <div style="position: relative">
      <div class="hideMenu-button hidden-sm hidden-xs" style="position: absolute;top: 5px;right: -20px">
        <a href="#" class="fa fa-reply-all" data-placement="top" data-toggle="tooltip" title="Свернуть"
           aria-hidden="true"></a>
      </div>

      <div class="container-fuid" style="float:left; width: 100%">
        <input class="form-control form-control-sm" autocomplete="off" name="search" placeholder="Поиск...">
      </div>
      <div style="padding-top: 8px; right: 10px; position: absolute">
        <a href="" id="btnResetSearch">
          <i class="fa fa-times-circle" aria-hidden="true" style="font-size:20px; color: #9d9d9d"></i>
        </a>
      </div>
    </div>

    <div class="row" style="padding: 0 15px">
      <div style="border-radius:2px;padding-top:40px">

      <?php
        echo \wbraganca\fancytree\FancytreeWidget::widget([
            'options' => [
                'source' => [
                    'url' => '/admin/classifier/classifiers',
                ],
                'extensions' => ['filter'],
                'quicksearch' => true,
                'minExpandLevel' => 2,
                'filter' => [
                    'autoApply' => true,   // Re-apply last filter if lazy data is loaded
                    'autoExpand' => false, // Expand all branches that contain matches while filtered
                    'counter' => true,     // Show a badge with number of matching child nodes near parent icons
                    'fuzzy' => false,      // Match single characters in order, e.g. 'fb' will match 'FooBar'
                    'hideExpandedCounter' => true,  // Hide counter badge if parent is expanded
                    'hideExpanders' => false,       // Hide expanders if all child nodes are hidden by filter
                    'highlight' => true,   // Highlight matches by wrapping inside <mark> tags
                    'leavesOnly' => true, // Match end nodes only
                    'nodata' => true,      // Display a 'no data' status node if result is empty
                    'mode' => "dimm"       // Grayout unmatched nodes (pass "hide" to remove unmatched node instead)
                ],
                'activate' => new \yii\web\JsExpression('function(node, data) {
                        var node = data.node;
                        var table = $("#example").DataTable();
                        if (node.key == -999){
                            $(".add-subcategory").hide();
                            return;
                        } else {
                            $(".add-subcategory").show();
                        }
                        var title = node.title;
                        var id = node.data.id;
                        showTable(id);                        
                        $(".lft").text(node.data.lft);                       
                        $(".rgt").text(node.data.rgt);                       
        }'),
                'renderNode' => new \yii\web\JsExpression('function(node, data) {
            }'),
            ]
        ]); ?>
      </div>
    </div>
  </div>


  <div class="col-lg-8 col-md-8 about about-padding" style="position: relative;">
    <div class="control-buttons-wrap" style="position: absolute;top: 0px;">
    <?= Html::a('Удалить',
        [''], [
            'class' => 'btn btn-danger btn-sm hiddendel',
            'style' => ['margin-top' => '5px', 'display' => 'none'],
            'data-toggle' => "tooltip",
            'data-placement' => "top",
            'title' => $dell_hint,
        ]) ?>
    <?= Html::a('Передать->',
        [''], [
            'class' => 'btn btn-primary btn-sm hiddendel',
            'style' => ['margin-top' => '5px', 'display' => 'none'],
            'data-toggle' => "tooltip",
            'data-placement' => "top",
            'title' => $send_hint,
        ]) ?>
    </div>
    <input class="lft" style="display: none">
    <input class="rgt" style="display: none">
    <div class="table-wrapper" style="min-height:40px">
    </div>
    <div class="about-header" style="font-size:18px"></div>
    <div id="tableDiv"></div>
  </div>

</div>


<script>
    var showMenuBtn =
        '<div class="show-menu-button" data-placement="top" data-toggle="tooltip" title="Развернуть" onclick="onClick()">' +
        '<i class="fa fa-chevron-right" aria-hidden="true"></i>'+
        '</div>';

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('.hideMenu-button').click(function (e) {
            e.preventDefault();
            $('.fancy-tree').animate({
                    width: "0%"
                },
                {
                    duration: 1000,
                    complete: function () {
                        $('#main-table_wrapper').css('margin-left', '20px');
                        $('.about').css('width', '');
                        $('.about').removeClass('col-lg-9 col-md-9').addClass('col-lg-12 col-md-12');
                        redrawTable()
                        $('.fancy-tree').hide();
                        $('[data-toggle="tooltip"]').tooltip();
                        if ($('.show-menu-button').length === 0) {
                            $('#main-table_wrapper').append(showMenuBtn);
                        }
                        $('.show-menu-button').show();
                    },
                    step: function (now, fx) {
                        if (now <= 25) {
                            $('.about').removeClass('col-lg-8 col-md-8').addClass('col-lg-9 col-md-9');
                            redrawTable()
                        }
                        if (now <= 11 && now >= 5) {
                            $('.fancy-tree').hide();
                            $('#main-table_wrapper').css('position', 'relative');
                            $('[data-toggle="tooltip"]').tooltip();
                            console.log($('.show-menu-button').length);
                            if ($('.show-menu-button').length === 0) {
                                $('#main-table_wrapper').append(showMenuBtn);
                            }
                            $('.show-menu-button').show();
                        }
                    }
                }
            );
        });
    });


    function redrawTable(){
        var table = $('#main-table').DataTable();
        table.draw();
        return true;
    }


    function onClick() {
        var table = $('#main-table').DataTable();
        var width = '33%';
        if ($(document).width() < 600){
            width = '100%';
        }
        $('.show-menu-button').hide();
        $('.fancy-tree').animate({
                width: width
            },
            {
                duration: 1000,
                complete: function () {
                    $('.about').css('width', '');
                    $('#main-table_wrapper').css('margin-left', '0px');
                    $('#main-table_wrapper').css('position', 'inherit');
                    $('[data-toggle="tooltip"]').tooltip();
                    $('.fancy-tree').css('width', '');
                    table.draw();
                },
                step: function (now, fx) {
                    if (now > 5 && now < 14) {
                        $('.fancy-tree').show();
                        $('.about').removeClass('col-lg-12 col-md-12').addClass('col-lg-10 col-md-10');
                        table.draw();
                    } else if (now > 16){
                        $('.about').removeClass('col-lg-10 col-md-10').addClass('col-lg-8 col-md-8');
                    }
                }
            }
        );
    }

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).ready(function () {
        $('.refresh').click(function (event) {
            event.preventDefault();
            var tree = $(".fancytree-ext-filter").fancytree("getTree");
            console.log(tree);
            tree.reload();
            $(".about-header").text("");
            $(".about-main").html('');
            $(".del-node").hide();
            $(".del-multi-nodes").hide();
            $(".lft").text('');
            $(".rgt").text('');
            $("#main-table").DataTable().clearPipeline().draw();
        })
    });

    $("input[name=search]").keyup(function (e) {
        var n,
            tree = $.ui.fancytree.getTree(),
            args = "autoApply autoExpand fuzzy hideExpanders highlight leavesOnly nodata".split(" "),
            opts = {},
            filterFunc = $("#branchMode").is(":checked") ? tree.filterBranches : tree.filterNodes,
            match = $(this).val();

        $.each(args, function (i, o) {
            opts[o] = $("#" + o).is(":checked");
        });
        opts.mode = $("#hideMode").is(":checked") ? "hide" : "dimm";

        if (e && e.which === $.ui.keyCode.ESCAPE || $.trim(match) === "") {
            $("button#btnResetSearch").click();
            return;
        }
        if ($("#regex").is(":checked")) {
            // Pass function to perform match
            n = filterFunc.call(tree, function (node) {
                return new RegExp(match, "i").test(node.title);
            }, opts);
        } else {
            // Pass a string to perform case insensitive matching
            n = filterFunc.call(tree, match, opts);
        }
        $("#btnResetSearch").attr("disabled", false);
    }).focus();


    $("#btnResetSearch").click(function (e) {
        e.preventDefault();
        $("input[name=search]").val("");
        $("span#matches").text("");
        var tree = $(".fancytree-ext-filter").fancytree("getTree");
        tree.clearFilter();
    }).attr("disabled", true);

    $(document).ready(function () {
        $("input[name=search]").keyup(function (e) {
            if ($(this).val() == '') {
                var tree = $(".fancytree-ext-filter").fancytree("getTree");
                tree.clearFilter();
            }
        })
    });
    $(document).ready(function () {
        $.fn.dataTable.pipeline = function (opts) {
            var conf = $.extend({
                pages: 5,     // number of pages to cache
                url: '',      // script url
                data: null,   // function or object with parameters to send to the server
                              // matching how `ajax.data` works in DataTables
                method: 'GET' // Ajax HTTP method
            }, opts);
            var cacheLower = -1;
            var cacheUpper = null;
            var cacheLastRequest = null;
            var cacheLastJson = null;
            return function (request, drawCallback, settings) {
                var ajax = false;
                var requestStart = request.start;
                var drawStart = request.start;
                var requestLength = request.length;
                var requestEnd = requestStart + requestLength;
                if (settings.clearCache) {
                    // API requested that the cache be cleared
                    ajax = true;
                    settings.clearCache = false;
                }
                else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
                    // outside cached data - need to make a request
                    ajax = true;
                }
                else if (JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
                    JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
                    JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
                ) {
                    ajax = true;
                }
                cacheLastRequest = $.extend(true, {}, request);
                if (ajax) {
                    // Need data from the server
                    if (requestStart < cacheLower) {
                        requestStart = requestStart - (requestLength * (conf.pages - 1));
                        if (requestStart < 0) {
                            requestStart = 0;
                        }
                    }
                    cacheLower = requestStart;
                    cacheUpper = requestStart + (requestLength * conf.pages);
                    request.start = requestStart;
                    request.length = requestLength * conf.pages;
                    if (typeof conf.data === 'function') {
                        var d = conf.data(request);
                        if (d) {
                            $.extend(request, d);
                        }
                    }
                    else if ($.isPlainObject(conf.data)) {
                        $.extend(request, conf.data);
                    }
                    settings.jqXHR = $.ajax({
                        "type": conf.method,
                        "url": conf.url,
                        "data": request,
                        "dataType": "json",
                        "cache": false,
                        "success": function (json) {
                            cacheLastJson = $.extend(true, {}, json);
                            if (cacheLower != drawStart) {
                                json.data.splice(0, drawStart - cacheLower);
                            }
                            if (requestLength >= -1) {
                                json.data.splice(requestLength, json.data.length);
                            }

                            drawCallback(json);
                        }
                    });
                }
                else {
                    json = $.extend(true, {}, cacheLastJson);
                    json.draw = request.draw; // Update the echo for each response
                    json.data.splice(0, requestStart - cacheLower);
                    json.data.splice(requestLength, json.data.length);

                    drawCallback(json);
                }
            }
        };
        $.fn.dataTable.Api.register('clearPipeline()', function () {
            return this.iterator('table', function (settings) {
                settings.clearCache = true;
            });
        });
    });

    var tableName;

    function showTable(id) {
        $.ajax({
            "url": 'display-columns?id=' + id,
            "success": function (json) {
                var tableHeaders = '';
                window.tableName = json.tableName;
                $.each(json.columns, function (i, val) {
                    tableHeaders += "<th>" + val + "</th>";
                });
                $("#tableDiv").empty();
                $("#tableDiv").append('<table id="main-table" class="display" cellspacing="0" width="100%"><thead><tr>' + tableHeaders + '</tr></thead></table>');
                var table = $('#main-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "responsive": true,
                    "ajax": $.fn.dataTable.pipeline({
                        url: "server-side-ex?id=" + id,
                        dataSrc: "",
                        pages: 2 // number of pages to cache
                    }),
                    "columnDefs": [{
                        "targets": -2,
                        "data": null,
                        "defaultContent": "<a href='#' class='fa fa-edit edit' style='padding-right: 5px'></a>" +
                        "<a href='#' class='fa fa-eye view'></a>",
                        "orderable": false,
                        "responsivePriority": 1

                    }, {
                        "orderable": false,
                        "className": 'select-checkbox',
                        "targets": -1,
                        "defaultContent": "",
                        "searchable": false,
                        "responsivePriority": 2
                    }, {
                        "targets": 0,
                        "data": null,
                        "visible": false
                    },{
                        "targets": 0,
                        "data": null,
                        "visible": false
                    },{
                        "targets": 5,
                        "visible": false
                    },
                        {
                        "targets": 2,
                        "render": function (data, type, row) {
                            return row[2] + " " + row[3];
                        }
                    }, {
                        "targets": 3,
                        "data": null,
                        "visible": false
                    }],
                    select: {
                        style: 'os',
                        selector: 'td:last-child'
                    },
                    language: {
                        url: "/lib/ru.json"
                    }
                });
                table.on('select', function (e, dt, type, indexes) {
                    if (type === 'row') {
                        $('.hiddendel').show();
                    }
                });
                table.on('deselect', function (e, dt, type, indexes) {
                    if (type === 'row') {
                        $('.hiddendel').hide();
                    }
                });
                table.on('click', '.edit', function (e) {
                    e.preventDefault();
                    var data = table.row($(this).parents('tr')).data();
                    if (e.ctrlKey) {
                        var href = "/tehdoc/kernel/equipment/update?id=" + data[0];
                        window.open(href);
                    } else {
                        location.href = "/tehdoc/kernel/equipment/update?id=" + data[0];
                    }

                });
                table.on('click', '.view', function (e) {
                    e.preventDefault();
                    var data = table.row($(this).parents('tr')).data();
                    if (e.ctrlKey) {
                        var href = "/tehdoc/kernel/equipment/view?id=" + data[0];
                        window.open(href);
                    } else {
                        location.href = "/tehdoc/kernel/equipment/view?id=" + data[0];
                    }
                });
            },
            "dataType": "json"
        });
    }

    $(document).ready(function () {
        $('.hiddendel').click(function (event) {
            event.preventDefault();
            console.log(window.tableName);
            var csrf = $('meta[name=csrf-token]').attr("content");
            var table = $('#main-table').DataTable();
            var data = table.rows({selected: true}).data();
            var ar = [];
            var count = data.length;
            for (var i = 0; i < count; i++) {
                ar[i] = data[i][5];
            }
            if (confirm('Вы действительно хотите удалить выделенное оборудование? Выделено ' + data.length + '!!!  ')) {
                $(".modal").modal("show");
                $.ajax({
                    url: "/admin/classifier/delete-from-table",
                    type: "post",
                    dataType: "JSON",
                    data: {dellArray: ar, _csrf: csrf, tableName: window.tableName},
                    success: function (result) {
                        $("#main-table").DataTable().clearPipeline().draw();
                        $(".modal").modal('hide');
                        $('.hiddendel').hide();
                    },
                    error: function () {
                        alert('Ошибка! Обратитесь к разработчику.');
                    }
                });
            }
        })
    });

</script>