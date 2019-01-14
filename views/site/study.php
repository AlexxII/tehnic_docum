<?php
$this->title = 'Обучение и тренировка по JS и JQuery';

\wbraganca\fancytree\FancytreeAsset::register($this);

?>
<div class="site-index">

  <div class="jumbotron">
    <h4>Обучение и тренировка по JS</h4>
  </div>

  <?php
    echo mt_rand();
  Yii::$app->cache->flush();
  ?>


  <div>
    <input id="myLocation" type="hidden">
    <input id="fancyTree" data-target="#myFancyTreeID" name="placement_id">
    <div id="myFancyTreeID" class="form-control" data-target="#myLocation" style="display:none;width:500px"></div>
  </div>


  <div class="body-content">


  </div>
</div>

<script>

  function makeBuffer() {
    var buf = '';
    function buffer(str) {
      if(arguments.length == 0){
        return buf;
      }
      buf += str;
    }
    buffer.clear = function () {
      buf = '';
    };
    return buffer;
  }

  var f = makeBuffer();
  f('te');
  f(' re');
  console.log(f());
  console.log(f.clear);
  f.clear();
  console.log(f());


  $(document).ready(function () {
    $(function () {
      $('#fancyTree').on('click', function () {
        console.log('me');
        $($(this).data('target')).slideDown();
      });

      $('#myFancyTreeID').fancytree({
        minExpandLevel: 5,
        activate: function (event, data) {
          var node = data.node;
          if (!$.isEmptyObject(node.key)) {
            var $displayControl = $('span' + $(this).data('target'));
            var $valueControl = $('input' + $(this).data('target'));
            $displayControl.html(node.title);
            $valueControl.val(node.key);
            $(this).slideToggle();
          }
        },
        source: {
          url: '/admin/placement/placements',
          cache: false
        },
      });
    });
  });


</script>
