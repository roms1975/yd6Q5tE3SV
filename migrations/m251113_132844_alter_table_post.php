<?php

use yii\db\Migration;

class m251113_132844_alter_table_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            '{{%fk-post_links-post}}',
            '{{%post_links}}',
            'id',
            '{{%post}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-post_links-post}}', '{{%post_links}}');
    }

}
