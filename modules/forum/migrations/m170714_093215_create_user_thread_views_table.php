<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `user_thread_views`.
 */
class m170714_093215_create_user_thread_views_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_thread_views', [
            'id' => $this->primaryKey(),
            'creation_date' => Schema::TYPE_TIMESTAMP,
            'author' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'thread_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-user_thread_views-thread_id',
            'user_thread_views',
            'thread_id',
            'threads',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-user_thread_views-thread_id',
            'user_thread_views'
        );

        $this->dropTable('user_thread_views');
    }
}
