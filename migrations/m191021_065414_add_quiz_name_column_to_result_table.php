<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%result}}`.
 */
class m191021_065414_add_quiz_name_column_to_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%result}}', 'quiz_name', $this->string(255));
        $this->addColumn('{{%result}}', 'created_by', $this->integer());
        $this->addColumn('{{%result}}', 'updated_by', $this->integer());
        $this->addForeignKey(
            'FK_result_user_created_by', '{{result}}','created_by','{{user}}','id'
            ,'SET NULL'
        );
        $this->addForeignKey(
            'FK_result_user_updated_by', '{{result}}','updated_by','{{user}}','id'
            ,'SET NULL'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_result_user_created_by','{{%result}}');
        $this->dropForeignKey('FK_result_user_updated_by','{{%result}}');
        $this->dropTable('{{%result}}');
    }
}
