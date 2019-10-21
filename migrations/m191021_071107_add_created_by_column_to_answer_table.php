<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%answer}}`.
 */
class m191021_071107_add_created_by_column_to_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%answer}}', 'created_by', $this->integer());
        $this->addColumn('{{%answer}}', 'updated_by', $this->integer());
        $this->addForeignKey(
            'FK_answer_user_created_by', '{{answer}}','created_by','{{user}}','id'
            ,'SET NULL'
        );
        $this->addForeignKey(
            'FK_answer_user_updated_by', '{{answer}}','updated_by','{{user}}','id'
            ,'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_answer_user_created_by','{{%answer}}');
        $this->dropForeignKey('FK_answer_user_updated_by','{{%answer}}');
        $this->dropTable('{{%answer}}');
    }
}
