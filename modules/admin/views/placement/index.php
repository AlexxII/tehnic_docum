<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;


$this->title = 'Места размещения';
$this->params['breadcrumbs'][] = ['label' => 'Админ панель', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = $this->title;

$about = "Панель управления местами размещения оборудвания.";
$add_hint = 'Добавить новый узел';
$add_tree_hint = 'Добавить дерево';
$refresh_hint = 'Перезапустить форму';
$del_hint = 'Удалить выбранную категорию БЕЗ вложений';
$del_root_hint = 'Удалить дерево с вложениями';
$del_multi_nodes = 'Удвлить выбранную категорию С вложениями';

?>

<style>
  .h-title {
    font-size: 18px;
    color: #1e6887;
  }

  .fa {
    font-size: 15px;
  }

  ul.fancytree-container {
    font-size: 16px;
  }

  input {
    color: black;
  }
</style>

<div class="admin-placement-pannel">

  <h1><?= Html::encode($this->title) ?>
    <sup class="h-title fa fa-question-circle-o" aria-hidden="true"
         data-toggle="tooltip" data-placement="right" title="<?php echo $about ?>"></sup>
  </h1>
</div>
<div class="row">
  <div class="">
    <div class="container-fluid" style="margin-bottom: 10px">
      <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-success btn-sm add-subcategory',
          'style' => ['margin-top' => '5px'],
          'title' => $add_hint,
          'data-toggle' => 'tooltip',
          'data-placement' => 'top'
      ]) ?>
      <?= Html::a('<i class="fa fa-tree" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-success btn-sm add-category',
          'style' => ['margin-top' => '5px' , 'display' => 'none'],
          'title' => $add_tree_hint,
          'data-toggle' => 'tooltip',
          'data-placement' => 'top'
      ]) ?>
      <?= Html::a('<i class="fa fa-refresh" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-success btn-sm refresh',
          'style' => ['margin-top' => '5px'],
          'title' => $refresh_hint,
          'data-toggle' => 'tooltip',
          'data-placement' => 'top'
      ]) ?>
      <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-danger btn-sm del-node',
          'style' => ['margin-top' => '5px', 'display' => 'none'],
          'title' => $del_hint,
          'data-toggle' => 'tooltip',
          'data-placement' => 'top'
      ]) ?>
      <?= Html::a('<i class="fa fa-object-group" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-danger btn-sm del-multi-nodes',
          'style' => ['margin-top' => '5px', 'display' => 'none'],
          'title' => $del_multi_nodes,
          'data-toggle' => 'tooltip',
          'data-placement' => 'top'
      ]) ?>
    </div>

  </div>

  <div class="col-lg-7 col-md-7">
    <div class="">
      <div style="position: relative">
        <div class="container-fuid" style="float:left; width: 100%">
          <input class="form-control form-control-sm" autocomplete="off" name="search" placeholder="Поиск...">
        </div>
        <div style="padding-top: 8px; right: 10px; position: absolute">
          <a href="" id="btnResetSearch"><i class="fa fa-times-circle" aria-hidden="true"
                                            style="font-size:20px; color: #9d9d9d"></i></a>
        </div>
      </div>
    </div>

    <div class="row" style="padding: 0 15px">
      <div class="" style="border-radius:2px;padding-top:40px">

        <?php
        echo \wbraganca\fancytree\FancytreeWidget::widget([
            'options' => [
                'source' => [
                    'url' => '/admin/placement/placements',
                ],
                'extensions' => ['dnd', 'edit', 'filter'],
                'quicksearch' => true,
                'minExpandLevel' => 2,
                'dnd' => [
                    'preventVoidMoves' => true,
                    'preventRecursiveMoves' => true,
                    'autoCollapse' => true,
                    'dragStart' => new \yii\web\JsExpression('function(node, data) {
                    return true;
                }'),
                    'dragEnter' => new \yii\web\JsExpression('function(node, data) {
                    return true;
                }'),
                    'dragDrop' => new \yii\web\JsExpression('function(node, data) {
                    $.get("/admin/placement/move", {item: data.otherNode.data.id, action: data.hitMode, second:
                    node.data.id},function(){
                    data.otherNode.moveTo(node, data.hitMode);
                    })
                }'),
                ],
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

                'edit' => [
                    'inputCss' => [
                        'minWidth' => "10em"
                    ],
                    'triggerStart' => ["clickActive", "dblclick", "f2", "mac+enter", "shift+click"],
                    'beforeEdit' => new \yii\web\JsExpression('function(event, data){
                      // Return false to prevent edit mode
        }'),
                    'edit' => new \yii\web\JsExpression('function(event, data){
                      // Editor was opened (available as data.input)
        }'),
                    'beforeClose' => new \yii\web\JsExpression('function(event, data){
                      data.save;
        }'),
                    'save' => new \yii\web\JsExpression('function(event, data){
                        var node = data.node;
                        if (data.isNew){
                            $.ajax({
                              url: "/admin/placement/create",
                              data: { parentTitle: node.parent.title, title: data.input.val() }
                            }).done(function(result){
      //                          node.setTitle(result.acceptedTitle);
                            }).fail(function(result){
                                node.setTitle(data.orgTitle);
                            }).always(function(){
                                data.input.removeClass("pending");
                            });
                        } else {
                            $.ajax({
                              url: "/admin/placement/update",
                              data: { id: node.data.id, title: data.input.val() }
                            }).done(function(result){
      //                          node.setTitle(result.acceptedTitle);
                            }).fail(function(result){
                                node.setTitle(data.orgTitle);
                            }).always(function(){
                                data.input.removeClass("pending");
                            });
                        }
                        return true;
        }'),
                    'close' => new \yii\web\JsExpression('function(event, data){
                        // Editor was removed
                        if( data.save ) {
                          // Since we started an async request, mark the node as preliminary
                          $(data.node.span).addClass("pending");
                        }
        }')
                ],
                'activate' => new \yii\web\JsExpression('function(node, data) {
                        var node = data.node;
                        if (node.key == -999){
                            $(".add-subcategory").hide();
                            return;
                        } else {
                            $(".add-subcategory").show();
                        }
                        if (node.data.lvl == 0){
                            $(".del-node").hide();
                            $(".del-multi-nodes").hide();
                        } else {
                            if (node.hasChildren()){
                                $(".del-multi-nodes").show();
                            } else {
                                $(".del-multi-nodes").hide();
                            }
                            $(".del-node").show();
                        }
                        
                        if (node.data.url) {
                            window.location=(node.data.url);
                        }
        }'),
                'renderNode' => new \yii\web\JsExpression('function(node, data) {
                        if (data.node.key == -999){
                            $(".add-category").show();
                            $(".add-subcategory").hide();
                        } else {
                            $(".add-category").hide();
                        }
            }'),
            ]
        ]); ?>
      </div>
    </div>
  </div>


  <div class="col-lg-6 col-md-6" style="border-radius:2px;padding-top:10px">
    <?php
    //        print_r($model);
    ?>

  </div>

</div>


<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).ready(function () {
        $('.add-subcategory').click(function (event) {
            event.preventDefault();
            var node = $(".ui-draggable-handle").fancytree("getActiveNode");
            if (!node) {
                alert("Выберите родительскую категорию");
                return;
            }
            node.editCreateNode("child", " ");
        })
    });

    $(document).ready(function () {
        $('.add-category').click(function (event) {
            var tree = $(".ui-draggable-handle").fancytree("getTree");
            $.ajax({
                url: "/admin/placement/create-root",
                data: {title: 'Дерево'}
            })
                .done(function () {
                    tree.reload();
                })
                .fail(function () {
                    alert("Что-то пошло не так. Перезагрузите форму с помошью клавиши.");
                });
        });
    });

    $(document).ready(function () {
        $('.refresh').click(function (event) {
            event.preventDefault();
            var tree = $(".ui-draggable-handle").fancytree("getTree");
            tree.reload();
            $(".del-node").hide();
            $(".del-multi-nodes").hide();
        })
    });

    $(document).ready(function () {
        $('.del-node').click(function (event) {
            if (confirm('Вы уверены, что хотите удалить выбранную категорию?')) {
                event.preventDefault();
                var node = $(".ui-draggable-handle").fancytree("getActiveNode");
                $.ajax({
                    url: "/admin/placement/delete",
                    data: {id: node.data.id}
                })
                    .done(function () {
                        node.remove();
                    })
                    .fail(function () {
                        alert("Что-то пошло не так. Перезагрузите форму с помошью клавиши.");
                    });
            }
        })
    });

    $(document).ready(function () {
        $('.del-multi-nodes').click(function (event) {
            if (confirm('Вы уверены, что хотите удалить узел вместе с вложенниями?')) {
                event.preventDefault();
                var node = $(".ui-draggable-handle").fancytree("getActiveNode");
                if (!node){
                    alert('Выберите узел');
                    return;
                }
                $.ajax({
                    url: "/admin/placement/delete-root",
                    data: {id: node.data.id}
                })
                    .done(function () {
                        node.remove();
                    })
                    .fail(function () {
                        alert("Что-то пошло не так. Перезагрузите форму с помошью клавиши.");
                    });
            }
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
        var tree = $(".ui-draggable-handle").fancytree("getTree");
        tree.clearFilter();
    }).attr("disabled", true);

    $(document).ready(function () {
        $("input[name=search]").keyup(function (e) {
            if ($(this).val() == '') {
                var tree = $(".ui-draggable-handle").fancytree("getTree");
                tree.clearFilter();
            }
        })
    });


</script>