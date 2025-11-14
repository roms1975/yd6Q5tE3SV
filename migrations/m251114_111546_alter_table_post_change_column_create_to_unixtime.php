<?php

use yii\db\Migration;

class m251114_111546_alter_table_post_change_column_create_to_unixtime extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{post}}', 'created', $this->bigInteger()->unsigned()->notNull());
        $this->alterColumn('{{post}}', 'updated', $this->bigInteger()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{post}}', 'created', $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'));
        $this->alterColumn('{{post}}', 'updated', $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP'));
    }

}
