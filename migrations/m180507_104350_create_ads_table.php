<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ads`.
 * Has foreign keys to the tables:
 *
 * - `users`
 */
class m180507_104350_create_ads_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ads', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'text' => $this->text(),
            'user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-ads-user_id',
            'ads',
            'user_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-ads-user_id',
            'ads',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `users`
        $this->dropForeignKey(
            'fk-ads-user_id',
            'ads'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-ads-user_id',
            'ads'
        );

        $this->dropTable('ads');
    }
}
