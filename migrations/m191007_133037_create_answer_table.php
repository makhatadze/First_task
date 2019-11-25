<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%answer}}`.
 */
class m191007_133037_create_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%answer}}', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer(),
            'is_correct' => $this->boolean()->defaultValue(0),
            'name' => $this->string(255),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11)


        ]);

        $this->addForeignKey
        (
            'FK_answer_questions_questions_id', '{{answer}}','question_id',
            '{{questions}}','id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addForeignKey('FK_answer_questions_question_id','{{%answer}}');
        $this->dropTable('{{%answer}}');
    }
}
