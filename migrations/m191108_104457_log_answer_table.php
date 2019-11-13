
<?php

use yii\db\Migration;

/**
 * Class m191108_102825_log_answer_table
 */
class m191108_104457_log_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%log_answer}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'quiz_id' => $this->integer(),
            'question_id' => $this->integer(),
            'answer' => $this->String(),
        ]);


        $this->addForeignKey
        (
            'FK__quiz_id', '{{log_answer}}', 'quiz_id', '{{quiz}}', 'id', 'CASCADE'
        );
        $this->addForeignKey
        (
            'FK__question_id', '{{log_answer}}', 'question_id', '{{questions}}', 'id', 'CASCADE'
        );
        $this->addForeignKey
        (
            'FK__user_id', '{{log_answer}}', 'user_id', '{{user}}', 'id', 'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addForeignKey('FK__quiz_id', '{{log_answer}}');
        $this->addForeignKey('FK__question_id', '{{log_answer}}');
        $this->addForeignKey('FK__user_id', '{{log_answer}}');

        $this->dropTable('{{log_answer}}');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191108_102825_log_answer_table cannot be reverted.\n";

        return false;
    }
    */
}
