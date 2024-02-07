<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_pet}}`.
 */
class m240206_120225_create_user_pet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_pet}}', [
            'user_id' => $this->integer(),
            'pet_id' => $this->integer(),
            'PRIMARY KEY(user_id, pet_id)',
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_pet-user_id}}',
            '{{%user_pet}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_pet-user_id}}',
            '{{%user_pet}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `pet_id`
        $this->createIndex(
            '{{%idx-user_pet-pet_id}}',
            '{{%user_pet}}',
            'pet_id'
        );

        // add foreign key for table `{{%pet}}`
        $this->addForeignKey(
            '{{%fk-user_pet-pet_id}}',
            '{{%user_pet}}',
            'pet_id',
            '{{%pet}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_pet-user_id}}',
            '{{%user_pet}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_pet-user_id}}',
            '{{%user_pet}}'
        );

        // drops foreign key for table `{{%pet}}`
        $this->dropForeignKey(
            '{{%fk-user_pet-pet_id}}',
            '{{%user_pet}}'
        );

        // drops index for column `pet_id`
        $this->dropIndex(
            '{{%idx-user_pet-pet_id}}',
            '{{%user_pet}}'
        );

        $this->dropTable('{{%user_pet}}');
    }
}
