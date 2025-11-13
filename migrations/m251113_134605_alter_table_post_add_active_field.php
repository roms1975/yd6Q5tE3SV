<?php

use yii\db\Migration;

class m251113_134605_alter_table_post_add_active_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{post}}', 'active', $this->boolean()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{post}}', 'active');
    }

}
