<?php

use yii\db\Migration;

class m251113_132244_create_table_post_links extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post_links}}', [
            'id' => $this->integer(),
            'token' => $this->string()->notNull(),
            'created' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post_links}}');
    }

}
