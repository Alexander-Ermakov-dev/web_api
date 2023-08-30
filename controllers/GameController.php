<?php

namespace app\controllers;

use app\models\Game;
use app\models\search\GameSearch;

class GameController extends GeneralController
{
    /**
     * Get all games and related genres
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        $searchModel = new GameSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $games = $dataProvider->getModels();

        $formattedGames = [];
        foreach ($games as $game) {
            $formattedGames[] = $game->getFormattedGames();
        }
        return $this->respondWithPagination($dataProvider, $formattedGames);
    }

    /**
     * Get one game by id
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $game = $this->findModel($id, Game::class);

        return $this->asJson([
            'success' => true,
            'data' => $game->getFormattedGames(),
        ]);
    }

    /**
     * Create a game. Accepts parameters: name, developer, genreIds[]
     * @return \yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Game();
        $result = $model->saveGame($this->request->post());

        return $this->asJson($result);

    }

    /**
     * Update the created game. Accepts parameters: name, developer, genreIds[]
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id, Game::class);
        $result = $model->saveGame($this->request->post());

        return $this->asJson($result);
    }

    /**
     * Delete game by game id
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $game = $this->findModel($id, Game::class);
        $isDeleted = $game->delete();

        return $this->asJson([
            'success' => $isDeleted,
            'message' => $isDeleted ? 'Game deleted successfully.' : 'Failed to delete the game.'
        ]);
    }

    /**
     * Search games by genre id
     * @param $genreId
     * @return \yii\web\Response
     */
    public function actionGamesByGenre($genreId)
    {
        $games = Game::find()
            ->alias('g')
            ->joinWith('gameGenres gg', false)
            ->where(['gg.genre_id' => $genreId])
            ->select(['g.name', 'g.developer'])
            ->asArray()
            ->all();
        return $this->asJson(['games' => $games]);
    }
}
