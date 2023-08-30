<?php

use yii\db\Migration;

/**
 * Class m230829_152638_insert_game_and_genre_testdata
 */
class m230829_152638_insert_game_and_genre_testdata extends Migration
{
    public function safeUp()
    {
        $this->batchInsert('{{%genre}}', ['name'], [
            ['Moba'],
            ['RPG'],
            ['Action'],
            ['Simulator'],
            ['Strategy'],
        ]);

        $this->batchInsert('{{%game}}', ['name', 'developer'], [
            ['Dota 2', 'Valve'],
            ['LoL', 'Riot Games'],
            ['CS', 'Valve'],
            ['Valorant', 'Riot Games'],
            ['NFS', 'Electronic Arts'],
            ['SIMS', 'Electronic Arts'],
        ]);
        // Получение ID для игр
        $dota2Id = $this->getDb()->createCommand('SELECT id FROM {{%game}} WHERE name="Dota 2"')->queryScalar();
        $lolId = $this->getDb()->createCommand('SELECT id FROM {{%game}} WHERE name="LoL"')->queryScalar();
        $csId = $this->getDb()->createCommand('SELECT id FROM {{%game}} WHERE name="CS"')->queryScalar();
        $valorantId = $this->getDb()->createCommand('SELECT id FROM {{%game}} WHERE name="Valorant"')->queryScalar();
        $nfsId = $this->getDb()->createCommand('SELECT id FROM {{%game}} WHERE name="NFS"')->queryScalar();
        $simsId = $this->getDb()->createCommand('SELECT id FROM {{%game}} WHERE name="SIMS"')->queryScalar();

        // Получение ID для жанров
        $mobaId = $this->getDb()->createCommand('SELECT id FROM {{%genre}} WHERE name="Moba"')->queryScalar();
        $rpgId = $this->getDb()->createCommand('SELECT id FROM {{%genre}} WHERE name="RPG"')->queryScalar();
        $actionId = $this->getDb()->createCommand('SELECT id FROM {{%genre}} WHERE name="Action"')->queryScalar();
        $simulatorId = $this->getDb()->createCommand('SELECT id FROM {{%genre}} WHERE name="Simulator"')->queryScalar();
        $strategyId = $this->getDb()->createCommand('SELECT id FROM {{%genre}} WHERE name="Strategy"')->queryScalar();

        // Добавление связей
        $this->batchInsert('{{%game_genre}}', ['game_id', 'genre_id'], [
            [$dota2Id, $mobaId],
            [$dota2Id, $rpgId],
            [$lolId, $mobaId],
            [$lolId, $rpgId],
            [$csId, $actionId],
            [$csId, $simulatorId],
            [$valorantId, $actionId],
            [$nfsId, $simulatorId],
            [$simsId, $simulatorId],
            [$simsId, $strategyId]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%game}}', ['name' => ['Dota 2', 'LoL', 'CS', 'Valorant', 'NFS', 'SIMS']]);
        $this->delete('{{%genre}}', ['name' => ['Moba', 'RPG', 'Action', 'Simulator', 'Strategy']]);
    }
}
