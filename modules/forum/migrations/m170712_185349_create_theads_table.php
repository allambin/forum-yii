<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `theads`.
 */
class m170712_185349_create_theads_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('threads', [
            'id' => $this->primaryKey(),
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT,
            'creation_date' => Schema::TYPE_TIMESTAMP,
            'author' => Schema::TYPE_INTEGER,
            'views' => Schema::TYPE_SMALLINT . ' UNSIGNED NOT NULL DEFAULT 0'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('theads');
    }
}
