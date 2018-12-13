<?php

namespace app\modules\vks\controllers;

use app\modules\tehdoc\models\SSP;
use app\modules\vks\models\VksSessions;
use app\modules\vks\models\VksSubscribes;
use Yii;
use yii\web\Controller;

class SessionsController extends Controller
{
    public function actionIndex()
    {
        $model = VksSessions::find()->where(['=', 'vks_upcoming_session', 1])->all();
        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionServerSide()
    {
        $table = 'vks_sessions_tbl';
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array(
                'db' => 'vks_date',
                'dt' => 1,
                'formatter' => function ($d, $row) { //TODO разобраться с форматом отображения даты
                    if ($d != null) {
                        return date('d.m.Y', strtotime($d));
                    } else {
                        return '-';
                    }
                }
            ),
            array(
                'db' => 'vks_date',
                'dt' => 2,
                'formatter' => function ($d, $row) { //TODO разобраться с форматом отображения даты
                    if ($d != null) {
                        $month = date('m', strtotime($d));
                        $dates = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
                        return $dates[$month - 1];
                    } else {
                        return '-';
                    }
                }
            ),
            array('db' => 'vks_teh_time_start',
                'dt' => 3,
                'formatter' => function ($d, $row) { //TODO разобраться с форматом отображения даты
                    if ($d != null) {
                        return date('H:i', strtotime($d));
                    } else {
                        return '-';
                    }
                }
            ),
            array('db' => 'vks_work_time_start',
                'dt' => 4,
                'formatter' => function ($d, $row) { //TODO разобраться с форматом отображения даты
                    if ($d != null) {
                        return date('H:i', strtotime($d));
                    } else {
                        return '-';
                    }
                }
            ),
            array('db' => 'vks_type_text', 'dt' => 5),
            array('db' => 'vks_place_text', 'dt' => 6),
            array('db' => 'vks_subscriber_office_text', 'dt' => 7),
            array('db' => 'vks_subscriber_name', 'dt' => 8),
            array('db' => 'vks_order_text', 'dt' => 9),
        );
        $sql_details = \Yii::$app->params['sql_details'];
        return json_encode(
            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
    }

    public function actionCreate()
    {
        $time_teh = '';
        $time_work = '';
        $model = new VksSessions();
        if ($model->load(Yii::$app->request->post())) {
            date_default_timezone_set('Europe/Moscow');
            $time_teh = $model->vks_teh_time_start;
            $time_work = $model->vks_work_time_start;
            if ($time_teh) {
                $date = new \DateTime($model->vks_date);
                $time_teh = $model->vks_teh_time_start;
                $teh_start = explode(':', $time_teh);
                $date->setTime($teh_start[0], $teh_start[1]);
                $model->vks_teh_time_start = $date->format('Y-m-d H:i:s');
            }
            if ($time_work) {
                $date_2 = new \DateTime($model->vks_date);
                $time_work = $model->vks_work_time_start;
                $work_start = explode(':', $time_work);
                $date_2->setTime($work_start[0], $work_start[1]);
                $model->vks_work_time_start = $date_2->format('Y-m-d H:i:s');
            }
//            $currentTime = new \DateTime();
//            $model->vks_record_create = $currentTime->format('Y-m-d H:i:s');
//            $model->vks_record_ipdate = $currentTime->format('Y-m-d H:i:s');
            $model->vks_record_create = date('Y-m-d H:i:s');
            $model->vks_record_ipdate = date('Y-m-d H:i:s');
            $model->vks_upcoming_session = 1;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Предстоящий сеанс видеосвязи добавлен!');
                return $this->redirect('index');
            } else {
                Yii::$app->session->setFlash('error', 'Что-то не так.');
                if ($time_teh) {
                    $model->vks_teh_time_start = $time_teh;
                }
                if ($time_work) {
                    $model->vks_work_time_start = $time_work;
                }
                $vksDate = new \DateTime($model->vks_date);
                $model->vks_date = $vksDate->format('d-m-Y');
//                return var_dump($model->vks_date);
            }
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }


    public function actionUpdateUpcoming($id)
    {
        $model = VksSessions::findOne(['id' => $id]);
        if ($model->load(Yii::$app->request->post())) {
            $time_teh = $model->vks_teh_time_start;
            $time_work = $model->vks_work_time_start;
            if ($time_teh) {
                $date = new \DateTime($model->vks_date);
                $time_teh = $model->vks_teh_time_start;
                $teh_start = explode(':', $time_teh);
                $date->setTime($teh_start[0], $teh_start[1]);
                $model->vks_teh_time_start = $date->format('Y-m-d H:i:s');
            }
            if ($model->vks_work_time_start) {
                $date_2 = new \DateTime($model->vks_date);
                $time_work = $model->vks_work_time_start;
                $work_start = explode(':', $time_work);
                $date_2->setTime($work_start[0], $work_start[1]);
                $model->vks_work_time_start = $date_2->format('Y-m-d H:i:s');
            }
            $currentTime = new \DateTime();
            $model->vks_record_ipdate = $currentTime->format('Y-m-d H:i:s');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Запись успешно обновлена!');
                return $this->redirect('index');
            } else {
                Yii::$app->session->setFlash('error', 'Что-то не так.');
            }
        }
        $vksDate = new \DateTime($model->vks_date);
        $model->vks_date = $vksDate->format('d-m-Y');
        if ($model->vks_teh_time_start) {
            $vksTStart = new \DateTime($model->vks_teh_time_start);
            $model->vks_teh_time_start = $vksTStart->format('H:i');
        }
        if ($model->vks_work_time_start) {
            $vksWStart = new \DateTime($model->vks_work_time_start);
            $model->vks_work_time_start = $vksWStart->format('H:i');
        }
        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionSubscribersMsk()
    {
        $sql = "SELECT id as value, surnames as label FROM vks_subscribes_tbl where surnames IS NOT NULL and surnames != ''";
        $arrayOfNames = VksSubscribes::findBySql($sql)->asArray()->all();
        $newArrayOfNames = [];
        $tempArrayOfNames = [];
        $i = 0;
        foreach ($arrayOfNames as $fkey => $name){
            $i = $i + $fkey;
            $tempArrayOfNames = explode('; ', $name['label']);
            foreach ($tempArrayOfNames as $key => $temp){
                $i = $i + $key;
                $newArrayOfNames[$i]['value'] = $name['value'];
                $newArrayOfNames[$i]['label'] = $temp;
            }
        }
//        return var_dump($arrayOfNames);
//        return var_dump($newArrayOfNames);
        return json_encode(array_splice($newArrayOfNames, 0));
        return json_encode($arrayOfNames);

//        return var_dump(VksSubscribes::find()->select(['surnames'])->asArray()->all());

//        $array = ["Гуцан А.В.", "Голодец О.Ю.", "Жорж З.Д"];
//        return json_encode($array);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDelete()
    {
        $report = true;
        foreach ($_POST['jsonData'] as $d) {
            $model = $this->findModel($d);
            $report = $model->delete();
        }
        if ($report) {
            return true;
        }
        return false;
    }


    public function actionDeleteSingle($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Запись удалена');
            return $this->redirect(['index']);
        }
        Yii::$app->session->setFlash('error', 'Удалить запись не удалось');
        return $this->redirect(['index']);
    }

    public function actionConfirm()
    {
        $model = new VksSessions();
        return $this->render('confirm', [
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        $model = VksSessions::findOne(['id' => $id]);
            if (!empty($model)) {
                return $model;
            }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}