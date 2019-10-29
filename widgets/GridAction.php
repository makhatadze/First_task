<?php


namespace app\widgets;


use Yii;

class gridAction extends \yii\grid\ActionColumn
{

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye-open', [
            'class' => 'btn btn-info',
            'style' => 'width: 31%'
        ]);
        $this->initDefaultButton('update', 'pencil', [
            'class' => 'btn btn-warning',
            'style' => 'width: 31%'
        ]);
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
            'class' => 'btn btn-danger',
            'style' => 'width: 31%'
        ]);
    }

}