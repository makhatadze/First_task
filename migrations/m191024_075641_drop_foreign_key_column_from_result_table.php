<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%result}}`.
 */
class m191024_075641_drop_foreign_key_column_from_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->dropForeignKey('FK_result_quiz_quiz_id', '{{%result}}');
        $this->dropForeignKey('FK_result_user_updated_by', '{{%result}}');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_result_quiz_quiz_id', '{{%result}}');
        $this->dropForeignKey('FK_result_user_updated_by', '{{%result}}');
        $this->dropTable('{{%result}}');
    }
}
