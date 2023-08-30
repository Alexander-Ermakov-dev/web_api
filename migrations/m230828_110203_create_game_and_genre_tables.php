<?php

use yii\db\Migration;

/**
 * Class m230828_110203_create_game_and_genre_tables
 */
class m230828_110203_create_game_and_genre_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%game}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'developer' => $this->string()->notNull(),
        ]);

        $this->createTable('{{%genre}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ]);

        $this->createTable('{{%game_genre}}', [
            'game_id' => $this->integer(),
            'genre_id' => $this->integer(),
            'PRIMARY KEY(game_id, genre_id)',
        ]);

        $this->createIndex(
            '{{%idx-game_genre-game_id}}',
            '{{%game_genre}}',
            'game_id'
        );

        $this->addForeignKey(
            '{{%fk-game_genre-game_id}}',
            '{{%game_genre}}',
            'game_id',
            '{{%game}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-game_genre-genre_id}}',
            '{{%game_genre}}',
            'genre_id'
        );

        $this->addForeignKey(
            '{{%fk-game_genre-genre_id}}',
            '{{%game_genre}}',
            'genre_id',
            '{{%genre}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-game_genre-genre_id}}',
            '{{%game_genre}}'
        );

        $this->dropForeignKey(
            '{{%fk-game_genre-game_id}}',
            '{{%game_genre}}'
        );

        $this->dropTable('{{%game_genre}}');
        $this->dropTable('{{%game}}');
        $this->dropTable('{{%genre}}');
    }

}
