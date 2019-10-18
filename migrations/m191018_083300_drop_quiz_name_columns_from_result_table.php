<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%result}}`.
 */
class m191018_083300_drop_quiz_name_columns_from_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%result}}','quiz_name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%result}}');
    }
}
