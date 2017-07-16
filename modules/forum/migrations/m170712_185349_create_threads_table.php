<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `threads`.
 */
class m170712_185349_create_threads_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('threads', [
            'id' => $this->primaryKey(),
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'creation_date' => Schema::TYPE_TIMESTAMP,
            'author' => Schema::TYPE_INTEGER . ' NOT NULL',
            'views' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('threads');
    }
}
