<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "genre".
 *
 * @property int $id
 * @property string $name
 *
 * @property GameGenre[] $gameGenres
 * @property Game[] $games
 */
class Genre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'genre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
        ];
    }

    public static function getFormattedGenres($genres)
    {
        return ArrayHelper::toArray($genres, [
            'app\models\Genre' => [
                'id',
                'name'
            ]
        ]);
    }

    public function saveGenre($data)
    {
        $isNew = $this->isNewRecord;
        if (!$this->load($data, '') || !$this->save()) {
            return [
                'success' => false,
                'message' => $isNew ? 'Failed to create the genre.' : 'Failed to update the genre.',
                'errors' => $this->errors
            ];
        }
        return [
            'success' => true,
            'message' => $isNew ? 'Genre created successfully.' : 'Genre updated successfully.',
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
            ]
        ];
    }

    /**
     * Gets query for [[GameGenres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGameGenres()
    {
        return $this->hasMany(GameGenre::class, ['genre_id' => 'id']);
    }

    /**
     * Gets query for [[Games]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGames()
    {
        return $this->hasMany(Game::class, ['id' => 'game_id'])->viaTable('game_genre', ['genre_id' => 'id']);
    }
}
