<?php

use yii\db\Migration;

/**
 * Class m191018_082119_alter_correct_ans_columns_from_result_table
 */
class m191018_082119_alter_correct_ans_columns_from_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%result}}','correct_ans','correct_answer');
        $this->renameColumn('{{%result}}','min_correct_ans','min_correct_answer');



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%result}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191018_082119_alter_correct_ans_columns_from_result_table cannot be reverted.\n";

        return false;
    }
    */
}
