<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%questions}}`.
 */
class m191007_132339_create_questions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%questions}}', [
            'id' => $this->primaryKey(),
            'quiz_id' => $this->integer(),
            'name' => $this->string(255),
            'hint' => $this->string(255),
            'max_answers' => $this->integer(2),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11)
        ]);

        $this->addForeignKey
        (
          'FK_questions_quiz_quiz_id', '{{questions}}','quiz_id','{{quiz}}','id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('FK_questions_quiz_quiz_id','{{%questions}}');
        $this->dropTable('{{%questions}}');
    }
}
