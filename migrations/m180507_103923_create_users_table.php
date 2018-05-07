<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m180507_103923_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => 'string unique',
            'password' => $this->string(),
            'authKey' => $this->string(),
            'accessToken' => $this->string(),
            'about' => $this->string(),
            'photo' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
