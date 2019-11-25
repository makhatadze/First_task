<?php

use yii\db\Migration;

/**
 * Class m191024_085554_add_certificate_valid_time_quiz_table
 */
class m191024_085554_add_certificate_valid_time_quiz_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%quiz}}','certificate_valid_time',$this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('{{%quiz}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191024_085554_add_certificate_valid_time_quiz_table cannot be reverted.\n";

        return false;
    }
    */
}
