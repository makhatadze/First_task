<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%result}}`.
 */
class m191024_080012_drop_columns_from_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%result}}','certificate_valid_time',$this->integer(11));
        $this->dropColumn('{{%result}}','quiz_id');
        $this->dropColumn('{{%result}}','updated_by');
        $this->dropColumn('{{%result}}','updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%result}}','updated_at');
        $this->dropColumn('{{%result}}','quiz_id');
        $this->dropColumn('{{%result}}','updated_by');
        $this->dropTable('{{%result}}');
    }
}
