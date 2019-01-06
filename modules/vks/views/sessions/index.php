<?php

use yii\helpers\Html;

$this->title = 'Журнал предстоящих сеансов видеосвязи';
$this->params['breadcrumbs'][] = ['label' => 'ВКС', 'url' => ['/vks']];
$this->params['breadcrumbs'][] = "Журнал";

$about = "Журнал предстоящих сеансов видеосвязи";
$add_hint = 'Добавить предстоящий сеанс';
$dell_hint = 'Удалить выделенные сеансы';

Yii::$app->cache->flush();
?>

<div class="vks-pannel">
  <h1><?= Html::encode($this->title) ?>
    <sup class="h-title fa fa-question-circle-o" aria-hidden="true"
         data-toggle="tooltip" data-placement="right" title="<?php echo $about ?>"></sup>
  </h1>
</div>

<style>
  /*td {*/
  /*text-align: center;*/
  /*}*/
  #main-table tbody td {
    font-size: 12px;
  }
  .h-title {
    font-size: 18px;
    color: #1e6887;
  }

</style>

<div class="row">
  <div class="">
    <div class="container-fluid" style="margin-bottom: 20px">
      <?= Html::a('Добавить',
        ['create-up-session'], [
          'class' => 'btn btn-success btn-sm',
          'style' => ['margin-top' => '5px'],
          'data-toggle' => "tooltip",
          'data-placement' => "top",
          'title' => $add_hint,
        ]) ?>
      <?= Html::a('Удалить',
        [''], [
          'class' => 'btn btn-danger btn-sm hiddendel',
          'style' => ['margin-top' => '5px', 'display' => 'none'],
          'data-toggle' => "tooltip",
          'data-placement' => "top",
          'title' => $dell_hint,
        ]) ?>
    </div>
  </div>

  <div class="container-fluid">
    <?php

    echo '
        <table id="main-table" class="display no-wrap cell-border" style="width:100%">
          <thead>
            <tr>
              <th></th>
              <th >Дата</th>
              <th >Месяц</th>
              <th >Время</th>
              <th >Время</th>
              <th >Тип ВКС</th>
              <th >Студии</th>
              <th >Абонент</th>
              <th >Абонент</th>
              <th >Распоряжение</th>
              <th data-priority="3">Action</th>
              <th></th>
            </tr>
          </thead>
        </table>';
    ?>
  </div>

  <input class="csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" style="display: none">
</div>
<br>


<script>
  // $(document).ready(function () {
  //     $('[data-toggle="tooltip"]').tooltip();
  // });

  // ************************* Работа таблицы **************************************

  $(document).ready(function () {
    $.fn.dataTable.pipeline = function (opts) {
      var conf = $.extend({
        pages: 2,     // number of pages to cache
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
          ajax = true;
          settings.clearCache = false;
        }
        else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
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

  $(document).ready(function () {
    var table = $('#main-table').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
        var today = new Date();
        var date = aData[1];
        var pattern = /(\d{2})\.(\d{2})\.(\d{4})/;
        var dt = new Date(date.replace(pattern,'$3-$2-$1'));
        if ( moment(today).isAfter(dt, 'day') )
        {
          $('td', nRow).css('background-color', '#f2dede' );
        }
        else if ( moment(dt).isSame(today, 'day') )
        {
          $('td', nRow).css('background-color', '#dff0d8');
        }
        else {}
      },
      "ajax": $.fn.dataTable.pipeline({
        url: '/vks/sessions/server-side',
        pages: 2 // number of pages to cache
      }),
      orderFixed: [2, 'asc'],
      rowGroup: {
        dataSrc: 2
      },
      "columnDefs": [
        {
          "orderable": false,
          "targets": -2,
          "data": null,
          "width": '70px',
          "defaultContent":
            "<a href='#' class='fa fa-edit edit' style='padding-right: 5px' title='Обновить' data-placement='top' data-toggle='tooltip'></a>" +
            "<a href='#' class='fa fa-info view' title='Подробности' style='padding-right: 5px'></a>" +
            "<a href='#' class='fa fa-calendar-check-o confirm' title='Подтвердить сеанс' style='padding-right: 5px'></a>" +
            "<a href='#' class='fa fa-calendar-minus-o abort' title='Отменить сеанс'></a>"
        }, {
          "orderable": false,
          "className": 'select-checkbox',
          "targets": -1,
          "defaultContent": ""
        },
        {
          "targets": 0,
          "data": null,
          "visible": false
        }, {
          "targets": 2,
          "visible": false
        }, {
          "targets": 4,
          "visible": false
        },
        {
          "targets": 3,
          "render": function (data, type, row) {
            return row[3] + ' /т' + "<br> " + row[4] + ' /р';
          }
        },
        {
          "targets": 7,
          "render": function (data, type, row) {
            return row[7] + "<br> " + row[8];
          }
        }, {
          "targets": 8,
          "visible": false
        }
      ],
      select: {
        style: 'os',
        selector: 'td:last-child'
      },
      language: {
        url: "/lib/ru.json"
      }
    });

    $('#main-table tbody').on('click', '.edit', function (e) {
      e.preventDefault();
      var data = table.row($(this).parents('tr')).data();
      location.href = "/vks/sessions/update-up-session?id=" + data[0];
    });
    $('#main-table tbody').on('click', '.view', function (e) {
      e.preventDefault();
      var data = table.row($(this).parents('tr')).data();
      var href = "/vks/sessions/view-up-session?id=" + data[0];
      window.open(href);
    });
    $('#main-table tbody').on('click', '.confirm', function (e) {
      e.preventDefault();
      var data = table.row($(this).parents('tr')).data();
      location.href = "/vks/sessions/confirm?id=" + data[0];
    });
  });

  // Работа таблицы -> событие выделения и снятия выделения

  $(document).ready(function () {
    var table = $('#main-table').DataTable();
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
  });


  //********************** Удаление записей ***********************************

  $(document).ready(function () {
    $('.hiddendel').click(function (event) {
      event.preventDefault();
      var csrf = $('meta[name=csrf-token]').attr("content");
      var table = $('#main-table').DataTable();
      var data = table.rows({selected: true}).data();
      var ar = [];
      var count = data.length;
      for (var i = 0; i < count; i++) {
        ar[i] = data[i][0];
      }
      if (confirm('Вы действительно хотите удалить выделенные сеансы? Выделено ' + data.length + '!!!  ')) {
        $(".modal").modal("show");
        $.ajax({
          url: "/vks/sessions/delete",
          type: "post",
          dataType: "JSON",
          data: {jsonData: ar, _csrf: csrf},
          success: function (result) {
            $("#main-table").DataTable().clearPipeline().draw();
            $(".modal").modal('hide');
            $('.hiddendel').hide();
          },
          error: function () {
            alert('Ошибка! Обратитесь к разработчику.');
            $(".modal").modal('hide');
          }
        });
      }
    })
  });

  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

</script>