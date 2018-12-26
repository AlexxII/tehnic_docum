<?php

namespace app\modules\tehdoc\modules\equipment\controllers;

use app\modules\tehdoc\models\Images;
use app\modules\tehdoc\modules\equipment\models\Complex;
use app\modules\tehdoc\modules\equipment\models\Tools;
use yii\web\Controller;
use Yii;
use app\base\Model;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

class ComplexController extends Controller
{
  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionCreate()
  {
    $modelComplex = new Complex();
    $modelsTool = [new Tools ()];
    $fUpLoad = [new Images];
    $modelComplex->quantity = 1;                             // По умолчанию, кол-во оборудования - 1

    if ($modelComplex->load(Yii::$app->request->post())) {
      $modelsTool = Model::createMultiple(Tools::class);
      Model::loadMultiple($modelsTool, Yii::$app->request->post());
      // validate all models

      $valid = $modelComplex->validate();
      $valid = Model::loadRandom($modelsTool);
      $valid = Model::validateMultiple($modelsTool) && $valid;
      if ($valid) {
        $transaction = Yii::$app->db->beginTransaction();
        try {
          if ($flag = $modelComplex->save(false)) {
            foreach ($modelsTool as $index => $modelTool) {
//                            $modelTool->parent_id = $modelComplex->id;          //  наследует от родителя
//                            $modelTool->pak_id = $modelComplex->parent_id;      //  наследует от родителя
              if (!($flag = $modelTool->save(false))) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('esrror', 'Оборудование не добавлено');
                break;
              }
              if (!empty(Yii::$app->request->post('Images', []))) {
                $fUpLoad = new Images();
                $fUpLoad->imageFiles = UploadedFile::getInstances($fUpLoad, "[{$index}]imageFiles");
                if ($fUpLoad->uploadImage($modelTool->id)) {
                  Yii::$app->session->setFlash('succes', 'Оборудование добавлено');
                } else {
                  Yii::$app->session->setFlash('error', 'Оборудование добавлено, но не загружены изображения');
                }
              } else {
                Yii::$app->session->setFlash('success', 'Оборудование добавлено');
              }
            }
          }
          if ($flag) {
            $transaction->commit();
            return $this->redirect(['view', 'id' => $modelComplex->id]);
          }
        } catch (Exception $e) {
          Yii::$app->session->setFlash('error', 'Оборудование не добавлено');
          $transaction->rollBack();
        }
      } else {
        Yii::$app->session->setFlash('error', 'Что-то с валидностью данных');
      }
    }
    return $this->render('create', [
      'modelComplex' => $modelComplex,
      'modelsTool' => (empty($modelsTool)) ? [new Tools] : $modelsTool,
      'fUpload' => (empty($fUpLoad)) ? [new Images] : $fUpLoad
    ]);
  }

  public function actionUpdate($id)
  {
    $modelComplex = $this->findModel($id);
    $modelsTool = $modelComplex->tools;
    $fupload = [new Images()];
    if ($modelComplex->load(Yii::$app->request->post())) {
      $oldIDs = ArrayHelper::map($modelsTool, 'id', 'id');
      $modelsTool = Model::createMultiple(Tools::class, $modelsTool);
      Model::loadMultiple($modelsTool, Yii::$app->request->post());
      $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsTool, 'id', 'id')));
      // validate all models
      $valid = $modelComplex->validate();
      $valid = Model::validateMultiple($modelsTool) && $valid;
      if ($valid) {
        $transaction = Yii::$app->db->beginTransaction();
        try {
          if ($flag = $modelComplex->save(false)) {
            if (!empty($deletedIDs)) {
              Tools::deleteAll(['id' => $deletedIDs]);
            }
            foreach ($modelsTool as $index => $modelTool) {
              $modelTool->parent_id = $modelComplex->id;
              if (!($flag = $modelTool->save(false))) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Оборудование не добавлено');
                break;
              }
              if (!empty(Yii::$app->request->post('Images', []))) {
                $fUpLoad = new Images();
                $fUpLoad->imageFiles = UploadedFile::getInstances($fUpLoad, "[{$index}]imageFiles");
                if ($fUpLoad->uploadImage($modelTool->id)) {
                  Yii::$app->session->setFlash('succes', 'Оборудование добавлено');
                } else {
                  Yii::$app->session->setFlash('error', 'Оборудование добавлено, но не загружены изображения');
                }
              } else {
                Yii::$app->session->setFlash('success', 'Оборудование добавлено');
              }
            }
          }
          if ($flag) {
            $transaction->commit();
            return $this->redirect(['view', 'id' => $modelComplex->id]);
          }
        } catch (Exception $e) {
          $transaction->rollBack();
          Yii::$app->session->setFlash('error', 'Оборудование не добавлено');
        }
      }
    }
    return $this->render('update', [
      'modelComplex' => $modelComplex,
      'modelsTool' => (empty($modelsTool)) ? [new Tools] : $modelsTool,
      'fUpload' => (empty($fUpLoad)) ? [new Images] : $fUpLoad,
    ]);
  }

  public function actionView($id)
  {
    $model = $this->findModel($id);
    $modelsTool = $model->tools;
    return $this->render('view', [
      'modelComplex' => $model,
      'modelsTool' => $modelsTool,
    ]);
  }


  public function actionDelete($id, $all = 0)
  {
    $model = $this->findModel($id);
    if ($model->delete()) {
      if ($all == 1) {
        foreach ($model->tools as $tool) {
          $photos = $tool->photos;
          foreach ($photos as $photo) {
            unlink(\Yii::$app->params['uploadPath'] . $photo->photo_path);
            $photo->delete();
          }
//          Photo::deleteAll(['eq_id' => $tool->id]);
          $tool->delete();
        }
        Yii::$app->session->setFlash('success', 'Запись успешно удалена с компонентами');
      } else {
        Yii::$app->session->setFlash('success', 'Запись успешно удалена, без компонентов');
      }
    }
    return $this->redirect(['index']);
  }

  protected function findModel($id)
  {
    if (($model = Complex::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
  }

}