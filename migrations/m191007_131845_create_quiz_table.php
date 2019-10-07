<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quiz}}`.
 */
class m191007_131845_create_quiz_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quiz}}', [
            'id' => $this->primaryKey(),
            'subject'=>$this->string(127),
            'min_corect_answer' => $this->integer(2),
            'created_at' => $this->integer(11),
            'update_at' => $this->integer(11),
            'max-question' =>$this->integer(2)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%quiz}}');
    }
}
