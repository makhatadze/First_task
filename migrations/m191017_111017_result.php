<?php

use yii\db\Migration;

/**
 * Class m191017_111017_result
 */
class m191017_111017_result extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%result}}', [
            'id' => $this->primaryKey(),
            'quiz_id' => $this->integer(),
            'quiz_name' => $this->string(55),
            'correct_ans' => $this->integer(2),
            'min_correct_ans'=>$this->integer(2),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11)
        ]);

        $this->addForeignKey
        (
            'FK_result_quiz_quiz_id', '{{result}}','quiz_id','{{quiz}}','id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191017_111017_result cannot be reverted.\n";
        $this->dropForeignKey('FK_result_quiz_quiz_id','{{%result}}');
        $this->dropTable('{{%result}}');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191017_111017_result cannot be reverted.\n";

        return false;
    }
    */
}
