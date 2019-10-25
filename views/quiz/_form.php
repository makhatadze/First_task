<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Quiz */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="quiz-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'min_corect_answer')->textInput() ?>

    <?= $form->field($model, 'max_question')->textInput() ?>

    <?= $form->field($model, 'certificate_valid_time')->dropDownList(
        ['24' => '2 Year',
            '12' => '12 month',
            '6' => '6 month',
            '3' => '3 month',
            '1' => '1 month',

        ]

    )
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


