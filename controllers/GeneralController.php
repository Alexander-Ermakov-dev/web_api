<?php

namespace app\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class GeneralController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'create' => ['POST'],
                        'update' => ['POST'],
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }
    protected function respondWithPagination($dataProvider, $formattedData)
    {
        return $this->asJson([
            'success' => true,
            'data' => $formattedData,
            'pagination' => [
                'totalCount' => $dataProvider->getTotalCount(),
                'pageSize' => $dataProvider->getPagination()->getPageSize(),
                'pageCount' => $dataProvider->getPagination()->getPageCount(),
                'currentPage' => $dataProvider->getPagination()->getPage() + 1,
            ]
        ]);
    }
    protected function findModel($id, $modelClass)
    {
        if (($model = $modelClass::findOne(['id' => $id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}