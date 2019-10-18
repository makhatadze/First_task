<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%result}}`.
 */
class m191018_112120_add_question_count_column_from_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%result}}', 'question_count', $this->integer(3));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%result}}','question_count');

        return false;
    }
}
