<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pet}}`.
 */
class m240206_120154_create_pet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pet}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'location' => $this->string(),
            'imageFile' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pet}}');
    }
}
