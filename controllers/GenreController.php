<?php

namespace app\controllers;

use app\models\Genre;
use app\models\search\GenreSearch;

class GenreController extends GeneralController
{
    /**
     * Get all genres
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        $searchModel = new GenreSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $formattedGenres = Genre::getFormattedGenres($dataProvider->getModels());

        return $this->respondWithPagination($dataProvider, $formattedGenres);
    }

    /**
     * Get one genre by id
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id, Genre::class);

        return $this->asJson([
            'success' => true,
            'data' => Genre::getFormattedGenres([$model])[0],
        ]);
    }

    /**
     * Create a genre. Accepts parameters: name
     * @return \yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Genre();
        $result = $model->saveGenre($this->request->post());

        return $this->asJson($result);
    }

    /**
     * Update the created genre. Accepts parameters: name
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id, Genre::class);
        $result = $model->saveGenre($this->request->post());

        return $this->asJson($result);
    }

    /**
     * Delete genre by genre id
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $game = $this->findModel($id, Genre::class);
        $isDeleted = $game->delete();

        return $this->asJson([
            'success' => $isDeleted,
            'message' => $isDeleted ? 'Genre deleted successfully.' : 'Failed to delete the genre.'
        ]);
    }
}
