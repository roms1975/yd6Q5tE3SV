<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m251112_200926_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'ip' => $this->string(),
            'created' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated' => $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post}}');
    }
}
