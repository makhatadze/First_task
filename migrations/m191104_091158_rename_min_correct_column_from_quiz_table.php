<?php

use yii\db\Migration;

/**
 * Class m191104_091158_rename_min_correct_column_from_quiz_table
 */
class m191104_091158_rename_min_correct_column_from_quiz_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%quiz}}','min_corect_answer','min_correct_answer');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191104_091158_rename_min_correct_column_from_quiz_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191104_091158_rename_min_correct_column_from_quiz_table cannot be reverted.\n";

        return false;
    }
    */
}
