<?php

namespace app\models;

/**
 * This is the model class for table "game".
 *
 * @property int $id
 * @property string $name
 * @property string $developer
 *
 * @property GameGenre[] $gameGenres
 * @property Genre[] $genres
 */

class Game extends \yii\db\ActiveRecord
{
    public $genreIds = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'developer'], 'required'],
            [['name', 'developer'], 'string', 'max' => 255],
            [['name'], 'unique'],
            ['genreIds', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'developer' => 'Developer',
        ];
    }

    public function saveGame($data)
    {
        $isNew = $this->isNewRecord;
        if (!$this->load($data, '') || !$this->save()) {
            return [
                'success' => false,
                'message' => $isNew ? 'Failed to create the game.' : 'Failed to update the game.',
                'errors' => $this->errors
            ];
        }
        $this->saveGenreRelations();

        return [
            'success' => true,
            'message' => $isNew ? 'Game created successfully.' : 'Game updated successfully.',
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'developer' => $this->developer
            ]
        ];
    }

    public function saveGenreRelations()
    {
        GameGenre::deleteAll(['game_id' => $this->id]);

        foreach ($this->genreIds as $genreId) {
            $gameGenre = new GameGenre();
            $gameGenre->game_id = $this->id;
            $gameGenre->genre_id = $genreId;
            $gameGenre->save();
        }
    }

    public function getFormattedGames()
    {
        $genres = [];
        foreach ($this->gameGenres as $gameGenre) {
            $genres[] = [
                'id' => $gameGenre->genre->id,
                'name' => $gameGenre->genre->name
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'developer' => $this->developer,
            'genres' => $genres
        ];
    }

    /**
     * Gets query for [[GameGenres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGameGenres()
    {
        return $this->hasMany(GameGenre::class, ['game_id' => 'id']);
    }

    /**
     * Gets query for [[Genres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenres()
    {
        return $this->hasMany(Genre::class, ['id' => 'genre_id'])
            ->viaTable('game_genre', ['game_id' => 'id']);
    }
}
