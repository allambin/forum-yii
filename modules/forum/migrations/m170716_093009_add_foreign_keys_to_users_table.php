<?php

use yii\db\Migration;

class m170716_093009_add_foreign_keys_to_users_table extends Migration
{
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-thread-author',
            'threads',
            'author',
            'users',
            'id'
        );

        $this->addForeignKey(
            'fk-post-author',
            'posts',
            'author',
            'users',
            'id'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-post-author',
            'posts'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170716_093009_add_foreign_keys_to_users_table cannot be reverted.\n";

        return false;
    }
    */
}
