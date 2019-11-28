<?php

use yii\db\Migration;

/**
 * Class m191126_083536_Add_column_log_answer
 */
class m191126_083536_Add_column_log_answer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%log_answer}}', 'created_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%log_answer}}');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191126_083536_Add_column_log_answer cannot be reverted.\n";

        return false;
    }
    */
}
