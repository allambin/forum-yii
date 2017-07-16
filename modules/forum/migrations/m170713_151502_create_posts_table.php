<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `posts`.
 */
class m170713_151502_create_posts_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('posts', [
            'id' => $this->primaryKey(),
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'creation_date' => Schema::TYPE_TIMESTAMP,
            'author' => Schema::TYPE_INTEGER . ' NOT NULL',
            'thread_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'fk-post-thread_id',
            'posts',
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
            'fk-post-thread_id',
            'posts'
        );

        $this->dropTable('posts');
    }
}
