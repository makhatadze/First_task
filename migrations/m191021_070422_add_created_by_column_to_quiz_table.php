<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%quiz}}`.
 */
class m191021_070422_add_created_by_column_to_quiz_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quiz}}', 'created_by', $this->integer());
        $this->addColumn('{{%quiz}}', 'updated_by', $this->integer());
        $this->addForeignKey(
            'FK_quiz_user_created_by', '{{quiz}}','created_by','{{user}}','id'
            ,'SET NULL'
        );
        $this->addForeignKey(
            'FK_quiz_user_updated_by', '{{quiz}}','updated_by','{{user}}','id'
            ,'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_quiz_user_created_by','{{%quiz}}');
        $this->dropForeignKey('FK_quiz_user_updated_by','{{%quiz}}');
        $this->dropTable('{{%quiz}}');
    }
}
