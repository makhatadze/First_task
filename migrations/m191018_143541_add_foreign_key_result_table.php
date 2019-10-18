<?php

use yii\db\Migration;

/**
 * Class m191018_143541_add_foreign_key_result_table
 */
class m191018_143541_add_foreign_key_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {


        $this->addColumn('{{%result}}', 'quiz_id', $this->integer());
        $this->addForeignKey
        (
            'FK_result_quiz_quiz_id', '{{result}}','quiz_id','{{quiz}}','id'
            ,'SET NULL'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_result_quiz_quiz_id','{{%result}}');
        $this->dropTable('{{%result}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191018_143541_add_foreign_key_result_table cannot be reverted.\n";

        return false;
    }
    */
}
