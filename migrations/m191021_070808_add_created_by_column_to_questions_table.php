<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%questions}}`.
 */
class m191021_070808_add_created_by_column_to_questions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%questions}}', 'created_by', $this->integer());
        $this->addColumn('{{%questions}}', 'updated_by', $this->integer());
        $this->addForeignKey(
            'FK_questions_user_created_by', '{{questions}}','created_by','{{user}}','id'
            ,'SET NULL'
        );
        $this->addForeignKey(
            'FK_questions_user_updated_by', '{{questions}}','updated_by','{{user}}','id'
            ,'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_questions_user_created_by','{{%questions}}');
        $this->dropForeignKey('FK_questions_user_updated_by','{{%questions}}');
        $this->dropTable('{{%questions}}');
    }
}
