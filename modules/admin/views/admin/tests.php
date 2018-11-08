<?php

use yii\helpers\Html;
use app\modules\tehdoc\modules\kernel\models\SSP;

$this->title = 'Панель тестирования кода';
$this->params['breadcrumbs'][] = $this->title;

$about = "Панель администрирования";

?>

  <div class="admin-pannel-tests">
    <h1><?= Html::encode($this->title) ?>
      <sup class="h-title fa fa-question-circle-o" aria-hidden="true"
           data-toggle="tooltip" data-placement="right" title="<?php echo $about ?>"></sup>
    </h1>
  </div>

<?php


$conn = array(
    'user' => 'equser',
    'pass' => 'ajf49hak',
    'db' => 'tehdb',
    'host' => 'localhost'
);

$bindings = array();
$db = SSP::db( $conn );

$id = 88;
$sql = "SELECT lft, rgt FROM placement_tbl WHERE id = :id";
$stmt = $db->prepare( $sql );                   // создание временной таблицы мест размещения
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetchAll( PDO::FETCH_ASSOC);

/*
$sql = "CREATE TEMPORARY TABLE temp 
  SELECT id FROM placement_tbl WHERE placement_tbl.lft >= :lft AND placement_tbl.rgt <= :rgt ORDER BY :lft";
$stmt = $db->prepare( $sql );                   // создание временной таблицы мест размещения
$stmt->bindValue(':lft', $data[0]['lft'], PDO::PARAM_INT);
$stmt->bindValue(':rgt', $data[0]['rgt'], PDO::PARAM_INT);
$stmt->execute();

$sql = 'SELECT * FROM equipment_tbl WHERE id = id.temp';
$stmt = $db->prepare( $sql );                   // создание временной таблицы мест размещения
$stmt->execute();
$data = $stmt->fetchAll( PDO::FETCH_ASSOC);
var_dump($data);*/


$sql = 'SELECT * FROM equipment_tbl WHERE equipment_tbl.place_id in (
  SELECT id FROM placement_tbl WHERE placement_tbl.lft >= :lft AND placement_tbl.rgt <= :rgt ORDER BY lft)';
$stmt = $db->prepare( $sql );                   // создание временной таблицы мест размещения
$stmt->bindValue(':lft', $data[0]['lft'], PDO::PARAM_INT);
$stmt->bindValue(':rgt', $data[0]['rgt'], PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetchAll( PDO::FETCH_ASSOC);
echo count($data);


